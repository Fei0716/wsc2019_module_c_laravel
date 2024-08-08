<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = Attendee::where([
                'lastname' => $request->lastname,
                'registration_code' => $request->registration_code,
            ])->first();

            if (!$user) {
                return response()->json(['message' => 'Invalid Login'], 401);
            }
            $token = md5($user->username);
            $user->login_token = $token;
            $user->save();

            return response()->json([
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'username' => $user->username,
                'email' => $user->email,
                'token' => $token,
            ], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e], 403);
        }

    }

    public function logout(Request $request)
    {
        $token = $request->token;
        $user = Attendee::where([
            'login_token' => $request->token,
        ])->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 403);
        }
        $user->login_token = '';
        $user->save();

        return response()->json(['message' => 'Logout success'], 200);

    }
}
