<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $this->registerSession($user->id, $token, $request);

        return response()->json([
            'message' => 'Registration successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Enforce 1 active session limit
        $activeSession = UserSession::where('user_id', $user->id)
                                      ->where('expires_at', '>', now())
                                      ->first();

        if ($activeSession) {
            return response()->json(['message' => 'Your account is already active on another device.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $this->registerSession($user->id, $token, $request);

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        
        $request->user()->currentAccessToken()->delete();

        UserSession::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    private function registerSession($userId, $token, Request $request)
    {
        UserSession::create([
            'user_id' => $userId,
            'token' => hash('sha256', $token),
            'ip_address' => $request->ip(),
            'last_activity' => now(),
            'expires_at' => now()->addHours(24),
        ]);
    }
}
