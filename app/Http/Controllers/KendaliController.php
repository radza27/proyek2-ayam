<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aktuator;

class KendaliController extends Controller
{
    public function index() {
        $aktuators = Aktuator::all();
        return view('aktuator', compact('aktuators'));
    }

    public function toggle($id) {
        $aktuator = Aktuator::findOrFail($id);
        $aktuator->status = !$aktuator->status;
        $aktuator->save();

        return redirect()->back()->with('success', 'Status aktuator berhasil diubah!');
    }
}