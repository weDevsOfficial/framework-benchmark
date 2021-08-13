<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class PingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'pong']);
    }

    public function compute(): JsonResponse
    {
        $x = 0;
        $y = 1;
        $max = 10000;

        for ($i = 0; $i <= $max; $i++) {
            $z = $x + $y;
            $x = $y;
            $y = $z;
        }
        return response()->json(['message' => 'Done']);
    }
}
