<?php

namespace App\Http\Controllers\Lokasi;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'alamat' => 'nullable|string',
    ]);

    Lokasi::create([
        'user_id' => auth()->id(), // WAJIB LOGIN
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'alamat' => $request->alamat,
    ]);

    return back()->with('success', 'Lokasi berhasil disimpan');
}
public function destroy(Lokasi $lokasi){
    $lokasi->delete();
}
}
