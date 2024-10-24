<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "login" => 'required|string|unique:users,login',
                "password" => [
                    'required',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'login' => $validatedData['login'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'guest',
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        if (!Auth::attempt($validatedData)) {
            return response([
                'status' => false,
                'errors' => 'Wrong credentials'
            ], 422);
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
        ]);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "login" => 'nullable|string|unique:users,login',
            "password" => [
                'nullable',
                Password::min(8)->mixedCase()->numbers()->symbols()    
            ]
            ]);

        $data = array_filter($request->all());

        $user->update($data);

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    }
}
