<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatasAmbang;

class BatasAmbangController extends Controller
{
    public function index() {
        $ambang = BatasAmbang::first();
        return view('pengaturan', compact('ambang'));
    }

    public function update(Request $request) {
        $request->validate([
            'suhuMin' => 'required|numeric',
            'suhuMax' => 'required|numeric',
            'amoniaMax' => 'required|numeric',
        ]);

        $ambang = BatasAmbang::first();
        if ($ambang) {
            $ambang->update($request->all());
        } else {
            BatasAmbang::create($request->all());
        }

        return redirect()->back()->with('success', 'Ambang batas berhasil diperbarui.');
    }
}