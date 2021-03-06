<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

     /**
     * Obtain the user information from Google.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // OAuth Two Providers
            $token = $user->token;
            $refreshToken = $user->refreshToken; // not always provided
            $expiresIn = $user->expiresIn;
            
            // OAuth One Providers
//            $token = $user->token;
//            $tokenSecret = $user->tokenSecret;
            
            // All Providers
            $user->getId();
            $user->getNickname();
            $user->getName();
            $user->getEmail();
            $user->getAvatar();
dd($user,$token,$refreshToken,$expiresIn);
        } catch (\Exception $e) {
            return redirect('/login');
        }
        
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            dd('login');
            // log them in
            auth()->login($existingUser, true);
        } else {
            dd('new user');
        }
        return redirect()->to('/home');
    }
}
