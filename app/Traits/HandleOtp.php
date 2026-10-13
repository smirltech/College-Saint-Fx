<?php

namespace App\Traits;

use App\Models\Otp;
use App\Notifications\EmailOtpRequestedNotification;

trait HandleOtp
{
    public function sendOtp(string $email)
    {

        $otp = Otp::updateOrCreate(
            [
                'identifier' => $email,
            ],
            [
                'token' => rand(1000, 9999),
                'identifier' => $email,
                'expired_at' => now()->addMinutes(30)
            ]);

        $otp->notify(new EmailOtpRequestedNotification($otp));

        return $otp;
    }

    public function verifyOtp(Otp $otp, string $code): bool
    {
        if ($otp->token == $code) {
            $otp->delete();
            return true;
        }
        return false;
    }
}
