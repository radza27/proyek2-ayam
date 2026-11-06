<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog;

class MonitoringController extends Controller
{
    public function index() {
        $logs = SensorLog::latest()->take(24)->get()->reverse(); // Data untuk chart
        return view('monitoring', compact('logs'));
    }
}