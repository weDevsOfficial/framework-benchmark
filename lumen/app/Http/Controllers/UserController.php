<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['users' => User::all()]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'created_at' => new \DateTimeImmutable(),
            'updated_at' => new \DateTimeImmutable(),
        ]);

        return response()->json(['user' => $user], 201);
    }

    // Helper Route. Doesn't affect the benchmarkable routes.
    public function truncate(): JsonResponse
    {
        User::truncate();
        return response()->json(['message' => 'Table deleted']);
    }

    // Helper Route. Doesn't affect the benchmarkable routes.
    public function generate(): JsonResponse
    {
        foreach (range(1, 50) as $i) {
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password',
                'created_at' => new \DateTimeImmutable(),
                'updated_at' => new \DateTimeImmutable(),
            ]);
        }

        return response()->json(['users' => User::all()]);
    }
}
