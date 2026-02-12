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
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'alamat' => 'required|string|min:10',
    ]);

    $user = auth()->user();

    // Simpan ke table lokasis
    Lokasi::create([
        'user_id' => $user->id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'alamat' => $request->alamat,
    ]);

    // Update address di table users
    $user->address = $request->alamat;
    $user->save();
    return back()->with('success', 'Lokasi berhasil disimpan');
}
public function destroy(Lokasi $lokasi){
    $lokasi->delete();
}
}
