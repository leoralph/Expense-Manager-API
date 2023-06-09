<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => __('messages.auth.failed')
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            'message' => __('messages.auth.success'),
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        auth('web')->logout();

        return response()->json([
            'message' => __('messages.auth.logout')
        ], 200);
    }

    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
