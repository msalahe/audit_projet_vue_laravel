<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            logger('handle');
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if (!$finduser) {
                logger('not find user');

                $finduser = User::where('email', $user->email)->whereNull('google_id')->first();
                if (!$finduser) {
                logger('not find user email');
                return redirect()->intended('/login?e=1');
                }
                $finduser->google_id = $user->id;
                $finduser->save();
            }
            auth()->login($finduser);
            $userToken = $finduser->createToken("API_TOKEN")->plainTextToken;

            return redirect()->intended('/?s=' . $userToken . '&role='.$finduser->role->name);
        } catch (Exception $e) {
            return redirect()->intended('/login?e=1');
        }
    }
}
