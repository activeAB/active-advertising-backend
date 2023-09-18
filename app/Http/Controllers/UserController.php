<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $currentUser = auth()->user();

        // Get the user IDs of the users to exclude
        $excludeUserIds = [$currentUser->id];

        $users = User::where('id', '!=', $excludeUserIds) // Exclude the logged-in user
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'required',
            'user_role' => 'required',
            'user_phone_number' => 'required',
            'user_address' => 'required',
            'user_image_url' => 'required',
            'user_password' => 'required',
        ]);
        $checkUser =  $user = User::where('user_email', $data['user_email'])->first();
        if ($checkUser) {
            return response()->json(['message' => 'user exist'], 401);
        }
        $data['user_password'] = bcrypt($data['user_password']);
        $user = User::create($data);
        return response()->json(['message' => 'User Registered successfully'], 200);
    }
    public function login(Request $request)
    {
        $validate_User = $request->validate([
            'user_email' => 'required',
            'user_password' => 'required'
        ]);
        $user = User::where('user_email', $validate_User['user_email'])->first();
        if (is_null($user) || !Hash::check($validate_User['user_password'], $user->user_password)) {

            return response()->json(["message" => "Invalid Credential"], 401);
        }
        $token = $user->createToken("hash")->plainTextToken;
        return response()->json([

            "message" => "Logged in Successfully",
            "token" => $token,
            "user" => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'email',
            'user_role',
            'user_phone_number' => 'required',
            'user_address' => 'required',
            'user_image_url',
            'user_password', // Allow user_password to be optionally updated
        ]);

        $user = User::findOrFail($id);

        if ($request->has('user_password')) {
            $data['user_password'] = bcrypt($request->input('user_password'));
        }

        $user->update($data);
        return $user;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

    public function userFind(string $email)
    {
        $users = User::where('user_email', $email)->get();
        return response()->json([
            'data' => $users,
        ], 200);
    }
}
