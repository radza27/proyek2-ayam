<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index() {
        $logs = SensorLog::latest()->paginate(9);
        return view('riwayat', compact('logs'));
    }

    public function exportCsv()
    {
        $fileName = 'riwayat_sensor_primafarm_' . date('Y-m-d_H-i') . '.csv';
        
        // Mengambil seluruh data sensor terbaru dari database
        $logs = SensorLog::latest()->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal & Waktu', 'Suhu (C)', 'Gas Amonia (PPM)', 'Status', 'Sumber'];

        $callback = function() use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            
            // BOM UTF-8 agar karakter khusus aman dan terbaca baik di Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Menggunakan pemisah KOMA (',') standar CSV
            fputcsv($file, $columns, ',');

            foreach ($logs as $log) {
                $row = [
                    Carbon::parse($log->created_at)->format('d M Y, H:i:s') . ' WIB',
                    $log->suhu . ' C',
                    $log->amonia . ' ppm',
                    $log->status ?? 'Aman',
                    'ESP32-01'
                ];

                fputcsv($file, $row, ',');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}