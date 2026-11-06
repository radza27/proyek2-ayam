<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog;

class RiwayatController extends Controller
{
    public function index() {
        $logs = SensorLog::latest()->paginate(9);
        return view('riwayat', compact('logs'));
    }
}