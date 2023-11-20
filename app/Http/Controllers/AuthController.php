<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    const EXPIRY_RESET_TIME = 60;
    public function resetPassword(Request $request) {
        $email = $request->input('email');
        $user = User::query()->where('email', $email)->first();
        if ($user == null) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'email not found',
                    'data' => null
                ]
            );
        }

        $otp = random_int(100000, 999999);
        $resetToken = uniqid();
        $user->update([
            'reset_token' => $resetToken,
            'otp' => strval($otp),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reset password success. Please check your email',
            'data' => [
                'message' => '"otp" FIELD IS ONLY FOR INTEGRATION PURPOSE. WILL BE REMOVED LATER ON',
                'reset_token' => $resetToken,
                'countdown' => self::EXPIRY_RESET_TIME,
                'otp' => strval($otp)
            ]
        ]);
    }

    public function forgotPasswordOtp(Request $request) {
        $reset_token = $request->query('reset_token');
        $otp = $request->input('otp');
        $user = User::query()
            ->where('reset_token', $reset_token)
            ->where('otp', $otp)
            ->first();
        if ($user == null) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'reset token or otp is not valid',
                    'data' => null
                ]
            );
        }

        $timeDiff = Carbon::parse('2019-09-13 11:37 AM')->diffInSeconds($user->updated_at);

        if ($timeDiff >= self::EXPIRY_RESET_TIME) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'reset token expired',
                    'data' => null
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'otp validation success',
            'data' => [
                'change_password_token' => $reset_token,
            ]
        ]);
    }

    public function changePassword (Request $request) {
        $changePasswordToken = $request->query('change_password_token');
        $user = User::query()
            ->where('reset_token', $changePasswordToken)
            ->first();
        if ($user == null) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'change password token is not valid',
                    'data' => null
                ]
            );
        }
        $user->update([
            'password' => $request->input('password')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'change password success',
            'data' => null
        ]);
    }

    public function register(Request $request): RegisterResource {
        $this->validate(
            $request,
            [
                'email' => ['required', 'email','unique:users,email'],
                'password' => ['required'],
            ],
            [
            ]
        );

        $userRole = User::ROLE_MEMBER;
        if ($request->has('role') && $request->input('role') == User::ROLE_ADMIN) {
            $userRole = User::ROLE_ADMIN;
        }

        $user = User::query()->create(
            [
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'role' => $userRole,
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
                'success' => false,
                'message' => 'wrong credentials',
                'data' => null
            ]);
        }

        $user = auth()->user();

        /** @var \App\Models\MyUserModel $user **/
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
}
