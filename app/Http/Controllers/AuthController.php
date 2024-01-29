<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

use Throwable;


class AuthController extends Controller
{
    const EXPIRY_RESET_TIME = 300;
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
        $user->save();

        // Send the OTP email
        Mail::to($user->email)->send(new OtpMail($otp));

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
            ->first();
        if ($user == null) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'OTP_INVALID',
                    'data' => null
                ]
            );
        }

        $timeDiff = Carbon::now()->diffInSeconds($user->updated_at);

        if ($timeDiff >= self::EXPIRY_RESET_TIME) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'OTP_EXPIRED',
                    'data' => null
                ]
            );
        }

        if ($user->otp != $otp) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'OTP_INVALID',
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

    public function register(Request $request) {
        // Manually validate email uniqueness
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check for email uniqueness
        $validator->after(function ($validator) use ($request) {
            $existingUser = User::where('email', $request->input('email'))->first();

            if ($existingUser) {
                $validator->errors()->add('email', 'Email sudah digunakan, gunakan email lain');
            }
        });

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(RegisterResource::errorResponse($validator->errors()->first('email')), 400);
        }
        // dd($request->all());
        $userRole = User::ROLE_MEMBER;
        if ($request->has('role') && $request->input('role') == User::ROLE_ADMIN) {
            $userRole = User::ROLE_ADMIN;
        }

        else if ($request->has('role') && $request->input('role') == User::ROLE_SUPER_ADMIN) {
            $userRole = User::ROLE_SUPER_ADMIN;
        }

        $successMessage = 'success register user';
        $user = User::query()->create(
            [
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'zip_code'=> (int)$request->input('zip_code'),
                'role' => $userRole,
                'password' => $request->input('password'),
                'avatar_url' => 'https://www.clipartmax.com/png/middle/347-3473462_blue-icon-data-public-clip-art-black-and-white-library-link-icon.png',
            ]
        );

        $id = User::query()
            ->get(["id"])
            ->where($user->email, $request->input('email'));

        return (new RegisterResource($user));
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

    public function toAdmin($email,$zip_code) {

        // $zip_code = (int)$zip_code;
        // dd($email, $zip_code);

        $user = User::query()
            ->where('email', $email)
            ->where('zip_code', $zip_code)
            ->first();

        // If the user is found, update the role
        if ($user) {
            $user->update(['role' => User::ROLE_ADMIN]);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User with email: ' . $email . ' from Member is now an Admin. Welcome, ' . $user->full_name . '!',
                    'data' => $user
                ]
            );
        } else {
            // Handle the case where the user is not found
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User not found with email: ' . $email . ' and specified role and zip_code. And user is still',
                    'data' => null
                ]
            );
        }

    }
}
