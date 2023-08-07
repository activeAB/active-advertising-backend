<?php

namespace App\Http\Controllers;

use App\Models\Password_resets;
use App\Models\ss;
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
        DB::table('password_resets')->insert([
            'user_email' => $user->user_email,
            'reset_code' => $resetCode,
            'updated_at' => now(),
            'created_at' => now()
        ]);
        // Mail::to($user->user_email)->send(['text' => $resetCode]);
        $emailContent = "Hello there!\n\n"
            . "Thank you for using our service. To complete your account verification, please use the following code:\n\n"
            . "Verification Code: $resetCode\n\n"
            . "This code will expire in 15 minutes for security reasons. If you didn't request this verification, please ignore this email.\n\n"
            . "Best regards,\n"
            . "Active Advertising";
        Mail::raw($emailContent, function ($message) use ($request) {
            $message->to($request->input('user_email'));
            $message->subject('Your Account Verification Code');
        });

        return response()->json(['message' => 'Reset code sent successfully']);
    }

    public function checkCode(Request $request)
    {
        $validateInput = $request->validate([
            'user_email' => 'required',
            'reset_code' => 'required'
        ]);
        $resetCodes = Password_resets::orderBy('created_at', 'desc')->get()->where('user_email', $validateInput['user_email'])->first();
        if ($resetCodes['reset_code'] != $validateInput['reset_code']) {
            return ["message" => "invalid verification"];
        }
        return ["message" => "successfully Verified"];
    }

    public function changePassword(Request $request)
    {
        $validateInput = $request->validate([
            'user_email' => 'required'
        ]);
        $user = User::where('user_email', $validateInput['user_email'])->first();

        $data = $request->validate([
            'user_first_name',
            'user_last_name',
            'user_email',
            'user_role',
            'user_phone_number',
            'user_address',
            'user_image_url',
            'user_password' => 'required',
        ]);
        $data['user_password'] = bcrypt($data['user_password']);
        $user->update($data);
        return $user;
    }
}
