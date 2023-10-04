<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request): RegisterResource {
        $this->validate(
            $request,
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
            ]
        );

        $user = User::query()->create(
            [
                'full_name' => $request->input('full_name'),
                'type' => 'USER',
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'avatar_url' => 'https://www.clipartmax.com/png/middle/347-3473462_blue-icon-data-public-clip-art-black-and-white-library-link-icon.png',
            ]
        );

        return (new RegisterResource($user))
            ->additional([
                'success' => true,
                'message' => 'success register user'
            ]);
    }

    public function login(Request $request) {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (! auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'wrong credentials',
            ], 401);
        }

        $user = auth()->user();

        $tokenResult = $user->createToken(request('device', 'Unknown Device'));
        $token = $tokenResult->plainTextToken;

        return (new LoginResource((object)[
            'token' => $token,
            'user'=> $user,
        ]))->additional([
            'success'=> true,
            'message' => 'login success'
        ]);
    }
}
