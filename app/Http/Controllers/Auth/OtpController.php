<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailOtpRequestedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class OtpController extends Controller
{
    //send email otp
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::firstWhere('email', $request->email);


        // create user if not exists
        if (!$user) {
            $user = User::create([
                'email' => $request->email,
            ]);
        }
        if ($user->otp) {
            // Log::info('user already has otp', $user->otp->toArray());
            $user->otp->delete();
        }

        $otp = $user->otp()->create([
            'token' => rand(1000, 9999),
            'identifier' => $request->email,
            'expired_at' => now()->addMinutes(30)
        ]);
        //  Log::info('otp created', $otp->toArray());


        //return $user->otp;


        // EmailOtpRequested::dispatch($user);

        $user->notify(new EmailOtpRequestedNotification($otp));

        return Redirect::route('auth.verify', $user)
            ->with('message', 'OTP has been sent to your email');
    }

    // verify otp
    public function showVerifyOtp(Request $request, User $user)
    {
        if (!$user->otp) {
            return Redirect::route('auth');
        }
        return Inertia::render('Auth/VerifyCode', [
            'email' => $user->email,
            'otp' => $user->otp->token,
            'message' => 'Le code de verification a été envoyé à votre addresse.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric'
        ]);


        $user = User::firstWhere('email', $request->email);
        if (!$user) {
            return Response::json([
                'message' => 'User not found',
                'status' => ResponseCode::HTTP_NOT_FOUND
            ], ResponseCode::HTTP_NOT_FOUND);
        }

        /*        if ($user->otp->hasExpired()) {
                    return Response::json([
                        'success' => false,
                        'message' => 'OTP expired',
                    ], ResponseCode::HTTP_UNAUTHORIZED);
                }*/

        if ($user->otp->token != $request->code) {
            return Response::json([
                'success' => false,
                'message' => 'OTP not match',
            ], ResponseCode::HTTP_UNAUTHORIZED);
        }

        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        // delete otp
        $user->otp->delete();

        return Redirect::intended();
    }
}
