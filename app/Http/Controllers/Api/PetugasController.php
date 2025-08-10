<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;

use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class PetugasController extends Controller
{
   public function register(Request $request)
{
    // Validasi sederhana (tanpa unique dulu, biar kita bisa custom responsenya)
    $request->validate([
        'nama_petugas' => 'required|string|max:25',
        'username'     => 'required|string|max:25',
        'password'     => 'required|string|min:6',
        'level'        => 'required|in:administrator,petugas'
    ]);

    // Cek level ada atau tidak
    $level = Level::where('level', $request->level)->first();
    if (!$level) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Level tidak ditemukan'
        ], 404);
    }

    // Cek username sudah dipakai atau belum
    $usernameExists = Petugas::where('username', $request->username)->exists();
    if ($usernameExists) {
        return response()->json([
            'status'  => 'fail',
            'message' => 'Username sudah digunakan, silakan pilih username lain'
        ], 409);
    }

    // Simpan data
    $petugas = Petugas::create([
        'nama_petugas' => $request->nama_petugas,
        'username'     => $request->username,
        'password'     => Hash::make($request->password),
        'id_level'     => $level->id_level
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Registrasi berhasil',
        'data'    => $petugas
    ], 201);
}

}

