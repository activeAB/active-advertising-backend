<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;

class PasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $request->validate(['user_email' => 'required']);
        $user = User::where('user_email', $request->user_email)->first();
        if (!$user) {
            $data = [
                "message" => "user not exist"
            ];
            return $data;
        }
        $resetCode = rand(1000, 9999);
        DB::table('password_reset')->insert([
            'user_email' => $user->user_email,
            'reset_code' => $resetCode,
            'updated_at' => now()
        ]);
        // Mail::to($user->user_email)->send(['text' => $resetCode]);
        $emailContent = "Hello, here is your verification code: " . $resetCode;
        Mail::raw($emailContent, function ($message) use ($request) {
            $message->to($request->input('user_email'));
            $message->subject('Password Reset Verification Code');
        });

        return response()->json(['message' => 'Reset code sent successfully']);
    }
}
