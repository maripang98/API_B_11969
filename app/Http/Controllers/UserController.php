<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Output
        return response()->json([
            'user' => $user,
            'message' => 'User registered successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Mencari user
        $user = User::where('email', $request->email)->first();

        // Pemeriksaan apakah ada user
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create Personal Access Token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Output
        return response()->json([
            'detail' => $user,
            'token' => $token
        ]);
    }
}
