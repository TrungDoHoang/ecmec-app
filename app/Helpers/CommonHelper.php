<?php

use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Mail;

if (!function_exists('sendVerifyRegisterEmail')) {
    function sendVerifyRegisterEmail($token, $email)
    {
        // Logic here
        $verifyUrl = env('FRONTEND_URL') . '/verify-email?token=' . $token;
        Mail::to($email)->send(new VerifyEmailMail($verifyUrl));
    }
}
