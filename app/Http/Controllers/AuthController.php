<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse {
        $this->validate(
            $request,
            [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'phone_number' => ['required', 'unique:users,phone_number'],
                'password' => ['required'],
            ],
            [
            ]
        );

        $user = User::query()->create(
            [
                'name' => $request->input('name'),
                'type' => 'USER',
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => $request->input('password'),
            ]
        );

        return response()->json([
            'user_id' => $user->id,
            'message' => 'user created',
        ]);
    }

    public function login(Request $request): JsonResponse {
        $credentials = [
            'name' => $request->input('name'),
            'password' => $request->input('password')
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'numeric',
        ]);

        if (!$validator->fails()) {
            $credentials = [
                'phone_number' => $request->input('name'),
                'password' => $request->input('password')
            ];
        }

        $validator = Validator::make($request->all(), [
            'name' => 'email',
        ]);

        if (!$validator->fails()) {
            $credentials = [
                'email' => $request->input('name'),
                'password' => $request->input('password')
            ];
        }

        if (! auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'wrong credentials',
            ], 401);
        }

        $user = auth()->user();

        $tokenResult = $user->createToken(request('device', 'Unknown Device'));
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'competition_type' => $user->competition_type,
            'expires_at' => now()->addYear(),
        ]);
    }
}
