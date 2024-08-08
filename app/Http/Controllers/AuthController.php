<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        //        create password for the organizer
        $hashPassword1 = Hash::make('demopass1');
        $hashPassword2 = Hash::make('demopass2');
        DB::table('organizers')->where(['email' => 'demo1@worldskills.org'])->update(['password_hash' => $hashPassword1]);
        DB::table('organizers')->where(['email' => 'demo2@worldskills.org'])->update(['password_hash' => $hashPassword2]);
    }

    public function login(Request $request)
    {
        return view('index');
    }

    public function loginOrganizer(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);
        $user = Organizer::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password_hash)) {
            Auth::login($user);

            return redirect()->route('event.index')->with('success', 'Login Successful');
        } else {
            return back()->with(['error' => 'Email or password not correct']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('loginPage')->with('success', 'User Logout Successful');
    }
}
