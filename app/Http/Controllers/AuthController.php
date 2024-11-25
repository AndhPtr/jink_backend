<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone_num' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'profile_picture' => 'nullable|string|max:255', // Optional
            'about' => 'nullable|string|max:255',           // Optional
            'password' => 'required|string|min:8|confirmed', // Password confirmation is required
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'phone_num' => $request->phone_num,
            'address' => $request->address,
            'profile_picture' => $request->profile_picture, // Optional
            'about' => $request->about,                     // Optional
            'password' => Hash::make($request->password),
        ]);

        // Generate a Sanctum token for the newly registered user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Revoke the user's token (if using personal access tokens)
        $user->currentAccessToken()->delete();

        // Alternatively, if you want to logout the user and revoke all tokens:
        // $user->tokens->each(function ($token) {
        //     $token->delete();
        // });

        // Return success response
        return response()->json(['message' => 'Successfully logged out']);
    }
}
