<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\SensorLog;

class DashboardController extends Controller {
    
    public function index() {
        $alat = Alat::with(['batasAmbang', 'aktuators'])->first();
        $aktuators = $alat ? $alat->aktuators : [];
        $latestLog = $alat ? SensorLog::where('id_alat', $alat->id_alat)->latest()->first() : null;
        $logs = $alat ? SensorLog::where('id_alat', $alat->id_alat)->latest()->take(5)->get() : [];

        return view('dashboard', compact('alat', 'latestLog', 'logs', 'aktuators'));
    }

    public function apiStoreSensor(Request $request) {
        $log = SensorLog::create([
            'id_alat' => $request->id_alat,
            'suhu' => $request->suhu,
            'amonia' => $request->amonia,
            'status' => $request->suhu > 32 ? 'Kritis' : 'Aman'
        ]);

        return response()->json(['message' => 'Data berhasil direkam', 'data' => $log], 200);
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function processLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil masuk ke Dashboard!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}