<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($data);

        return $this->sukses([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'  => $user->fresh(),
        ], 'Registrasi berhasil', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $kredensial = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $kredensial['email'])->first();

        if (! $user || ! Hash::check($kredensial['password'], $user->password)) {
            return $this->gagal('Email atau password salah', 401);
        }

        return $this->sukses([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'  => $user,
        ], 'Login berhasil');
    }
}
