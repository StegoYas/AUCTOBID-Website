<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:25',
            'username' => 'required|string|max:25|unique:tb_masyarakat,username',
            'email' => 'required|string|email|max:50|unique:tb_masyarakat,email',
            'password' => 'required|string|min:6|confirmed',
            'telp' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat masyarakat baru
            $masyarakat = Masyarakat::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'telp' => $request->telp,
            ]);

            // Buat token (jika pakai Sanctum)
            $token = $masyarakat->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Masyarakat registered successfully',
                'data' => [
                    'masyarakat' => [
                        'id_user' => $masyarakat->id_user,
                        'nama_lengkap' => $masyarakat->nama_lengkap,
                        'username' => $masyarakat->username,
                        'email' => $masyarakat->email,
                        'telp' => $masyarakat->telp,
                        'created_at' => $masyarakat->created_at,
                        'updated_at' => $masyarakat->updated_at,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $masyarakat = Masyarakat::where('username', $request->username)->first();

        if (!$masyarakat || !Hash::check($request->password, $masyarakat->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $masyarakat->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'masyarakat' => [
                    'id_user' => $masyarakat->id_user,
                    'nama_lengkap' => $masyarakat->nama_lengkap,
                    'username' => $masyarakat->username,
                    'email' => $masyarakat->email,
                    'telp' => $masyarakat->telp,
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ], 200);
    }
    public function logout(Request $request)
{
    // Hapus token yang sedang digunakan
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Logged out successfully'
    ], 200);
}

}