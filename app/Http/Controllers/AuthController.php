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

    public function forgotPassword(Request $request) {
        $email = $request->input('email');
        // TODO send email
        return response()->json([
            'success' => true,
            'message' => 'forgot password success',
            'data' => [
                'countdown_time' => 60,
            ]
        ]);
    }

    public function forgotPasswordOtpValidation(Request $request) {
        // TODO still hard coded and
        $otp = $request->input('otp');

        if ($otp == '123456') {
            return response()->json([
                'success' => true,
                'message' => 'success otp valid',
                'data' => null,
            ]);
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'invalid otp',
                'data' => [
                    'last_attempt' => false
                ]
            ]);
        }
    }

    public function changePassword(Request $request) {
        $newPassword = $request->input('password');
        $email = $request->input('email');

        $user = User::query()->where(
            'email', $email
        )->first();

        $user->password = $newPassword;
        $user->save();

        return response()->json([
            'success' => true,
            'message'=> 'change password success',
            'data' => null
        ]);
    }
}
