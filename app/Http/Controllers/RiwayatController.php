<?php

namespace App\Http\Controllers;

use App\Models\SensorLog; 
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    private function buildFilteredQuery(Request $request)
    {
        $query = SensorLog::query();

        // 1. Filtering rentang waktu
        $filter = $request->get('filter', 'minggu_ini');
        if ($filter === 'hari_ini') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === '3_hari') {
            $query->where('created_at', '>=', Carbon::now()->subDays(3));
        } elseif ($filter === 'minggu_ini') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === '10_hari') {
            $query->where('created_at', '>=', Carbon::now()->subDays(10));
        } elseif ($filter === 'bulan_ini') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter === 'custom' && $request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // 2. Pengurutan Terbaru / Terlama
        $sort = $request->get('sort', 'terbaru');
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        return $query;
    }

    public function index(Request $request)
    {
        $logs = $this->buildFilteredQuery($request)->paginate(9);

        return view('riwayat', compact('logs'));
    }

    public function exportCsv(Request $request)
    {
        $logs = $this->buildFilteredQuery($request)->get();
        $filename = 'riwayat-data-prima-farm-' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 agar karakter/angka rapi saat dibuka di Microsoft Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom CSV (pakai titik koma ';' agar langsung terpecah kolom di Excel Indonesia)
            fputcsv($file, ['Tanggal & Waktu', 'Suhu (°C)', 'Gas Amonia (ppm)', 'Status', 'Sumber'], ';');

            foreach ($logs as $log) {
                $waktu = Carbon::parse($log->created_at)->format('d M Y, H:i:s') . ' WIB';
                $status = $log->status ?? (($log->suhu > 30 || $log->amonia >= 20) ? 'Waspada' : 'Aman');
                $sumber = $log->sumber ?? 'ESP32-01';

                fputcsv($file, [
                    $waktu,
                    number_format($log->suhu, 1),
                    number_format($log->amonia, 1),
                    $status,
                    $sumber,
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}