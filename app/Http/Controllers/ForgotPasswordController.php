<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Franchise;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\SMSController;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use Hash;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected AESCipher $aes, 
        protected SMSController $sms
    ) {}

    public function forgotPassword(Request $request) {
        return view('auth.forgot-password');
    }

    public function sendOTP(Request $request) {

        $username = User::where('email', $request->username)->first();
        $franchise = Franchise::where('userID', $username->id)
            ->where('contactNumber', $request->contactNumber)
            ->orderBy('created_at', 'DESC')
            ->first();

        if($username && $franchise) {

            PasswordReset::where('userID', $username->id)->delete();

            $passwordReset = PasswordReset::create([
                'userID' => $username->id,
                'contactNumber' => $franchise->contactNumber,
                'token' => strtoupper(\Str::random(5))
            ]);

            $this->sms->sendOTP($franchise, $passwordReset);
        
            return response()->json([
                'Message' => 'We have successfully sent an OTP token to your registered mobile number for password reset. Please check your SMS inbox.',
                'id' => $this->aes->encrypt($username->id) . '/' . $this->aes->encrypt($passwordReset->id) . '?key=' . \Str::random(20)
            ], 200);

        }
        else {
            return response()->json(['Message' => 'Username & Contact Number is invalid.'], 500);
        }
    }

    public function confirmOTP(Request $request) {

        $test = PasswordReset::where('id', $this->aes->decrypt($request->resetID))
        ->where('userID', $this->aes->decrypt($request->id))
        ->first();

        if($test) {
            if (Carbon::parse($test->created_at)->diffInMinutes(Carbon::now()) < 60) {
                return view('auth.confirm-otp', [
                    'id' => $request->id, 
                    'resetID' => $request->resetID
                ]);
            }
            else {
                return abort(404);
            }
        }
        else {
            return abort(404);
        }
    }

    public function verifyOTP(Request $request) {
       
        $otp = PasswordReset::where('id', $this->aes->decrypt($request->resetID))
            ->where('userID', $this->aes->decrypt($request->id))
            ->where('token', $request->otp)
            ->first();

        if($otp) {
            if (Carbon::parse($otp->created_at)->diffInMinutes(Carbon::now()) < 60) {

                return response()->json([
                    'Message' => 'OTP has been Verified. Proceed to resetting your password',
                    'id' => $this->aes->encrypt($otp->userID) . '/' . $this->aes->encrypt($otp->id) . '?key=' . \Str::random(20)
                ], 200);
            }
            else {
                return response()->json(['Message' => 'Your OTP has expired. Please request a new one to verify your account and reset your password.'], 500);
            }
        }
        else {
            return response()->json(['Message' => 'You have entered an invalid OTP. Please check your inbox to verify your account and reset your password.'], 500);
        }

    }

    public function resetPassword(Request $request) {

        $test = PasswordReset::where('id', $this->aes->decrypt($request->resetID))
        ->where('userID', $this->aes->decrypt($request->id))
        ->first();

        if($test) {
            if (Carbon::parse($test->created_at)->diffInMinutes(Carbon::now()) < 60) {
                return view('auth.reset-password', [
                    'id' => $request->id, 
                    'resetID' => $request->resetID
                ]);
            }
            else {
                return abort(404);
            }
        }
        else {
            return abort(404);
        }
    }

    public function newPassword(Request $request) {

        PasswordReset::where('id', $this->aes->decrypt($request->resetID))->delete();
        User::where('id', $this->aes->decrypt($request->id))->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['Message' => 'You have successfully reset your password. Please log in with your account credentials to proceed.'], 200);
    }
}
