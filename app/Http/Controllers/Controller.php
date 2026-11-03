<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function sukses(mixed $data = null, string $pesan = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $pesan,
            'data'    => $data,
        ], $status);
    }

    protected function gagal(string $pesan, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $pesan,
        ], $status);
    }
}
