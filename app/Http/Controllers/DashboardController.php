<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\SensorLog;
use App\Models\Aktuator;
use App\Models\BatasAmbang;

class DashboardController extends Controller {
    // Menampilkan halaman Dashboard Kandang
    public function index() {
        $alat = Alat::with(['batasAmbang', 'aktuators'])->first();
        $aktuators = $alat ? $alat->aktuators : [];
        $latestLog = SensorLog::where('id_alat', $alat->id_alat)->latest()->first();
        $logs = SensorLog::where('id_alat', $alat->id_alat)->latest()->take(5)->get();

        return view('dashboard', compact('alat', 'latestLog', 'logs', 'aktuators'));
    }

    // Menampilkan halaman Monitoring & Grafik Tren
    public function monitoring() {
        $logs = SensorLog::latest()->take(24)->get()->reverse(); // Data untuk chart
        return view('monitoring', compact('logs'));
    }

    // Menampilkan halaman Riwayat Data (Tabel & Filter)
    public function riwayat() {
        $logs = SensorLog::latest()->paginate(9);
        return view('riwayat', compact('logs'));
    }

    // Menampilkan halaman Kendali Aktuator
    public function aktuator() {
        $aktuators = Aktuator::all();
        return view('aktuator', compact('aktuators'));
    }

    // Menampilkan halaman Pengaturan Ambang Batas
    public function pengaturan() {
        $ambang = BatasAmbang::first();
        return view('pengaturan', compact('ambang'));
    }

    // Aksi untuk memperbarui Pengaturan Ambang Batas via Web
    public function updateAmbang(Request $request) {
        $request->validate([
            'suhuMin' => 'required|numeric',
            'suhuMax' => 'required|numeric',
            'amoniaMax' => 'required|numeric',
        ]);

        BatasAmbang::first()->update($request->all());
        return redirect()->back()->with('success', 'Ambang batas berhasil diperbarui.');
    }

    // (Opsional) Endpoint API untuk menerima data dari ESP32 di masa depan
    public function apiStoreSensor(Request $request) {
        $log = SensorLog::create([
            'id_alat' => $request->id_alat,
            'suhu' => $request->suhu,
            'amonia' => $request->amonia,
            'status' => $request->suhu > 32 ? 'Kritis' : 'Aman'
        ]);

        return response()->json(['message' => 'Data berhasil direkam', 'data' => $log], 200);
    }
    public function toggleAktuator($id)
    {
        $aktuator = Aktuator::findOrFail($id);
        // Ubah status kebalikan dari sebelumnya (true jadi false, false jadi true)
        $aktuator->status = !$aktuator->status;
        $aktuator->save();

        return redirect()->back()->with('success', 'Status aktuator berhasil diubah!');
    }

    // Menampilkan halaman Login sesuai mockup
    public function showLogin() {
        return view('auth.login');
    }

    // Memproses autentikasi login (mencocokkan email dan password)
    public function processLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Menggunakan kolom email dan password dari tabel users buatan kita
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil masuk ke Dashboard!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}