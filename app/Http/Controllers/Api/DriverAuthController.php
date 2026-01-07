<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DriverAuthController extends Controller
{
    /**
     * Login driver dan generate token
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari driver berdasarkan email
        $driver = Driver::where('email', $request->email)->first();

        // Check apakah driver ada dan password benar
        if (!$driver || !Hash::check($request->password, $driver->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Check status driver
        // if ($driver->status !== 'active') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Akun Anda sedang ' . $driver->status . '. Hubungi admin.',
        //     ], 403);
        // }

        // Generate token
        $token = $driver->createToken('driver-mobile-app')->plainTextToken;

        // Return success response dengan token dan data driver
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'email' => $driver->email,
                    'phone' => $driver->phone,
                    'own_type' => $driver->own_type,
                    'nama_pemilik' => $driver->nama_pemilik,
                    'status' => $driver->status,
                ],
            ],
        ], 200);
    }

    /**
     * Get driver profile (protected route)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        // auth()->user() akan return driver yang sedang login
        $driver = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $driver->id,
                'name' => $driver->name,
                'email' => $driver->email,
                'phone' => $driver->phone,
                'own_type' => $driver->own_type,
                'nama_pemilik' => $driver->nama_pemilik,
                'status' => $driver->status,
            ],
        ], 200);
    }

    public function turnOffStatus(Request $request)
    {
        $driver = $request->user();
        $driver->status = 'inactive';
        $driver->save();

        return response()->json([
            'success' => true,
            'message' => 'Status driver telah diubah menjadi inactive.',
        ], 200);
    }

    /**
     * Logout driver (revoke token)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Delete current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ], 200);
    }
}