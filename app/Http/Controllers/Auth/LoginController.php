<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    private $auth;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->middleware('guest')->except('logout');
        $this->auth = $auth;
    }



    public function firebaseLogin(Request $request)
    {
        $idToken = $request->idToken;
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
        } catch (InvalidToken $e) {
            return response(['message' => 'Unauthorized - Invalid Key'], 422);
        }
        catch (\InvalidArgumentException $e) {
            return response(['message' => 'Unauthorized - Invalid Key Format'], 422);
        }
        $uid = $verifiedIdToken->getClaim('sub');
        $firebase_user = $this->auth->getUser($uid);
        $user = User::firstOrCreate(
            ['firebase_uid' => $uid],
            [
                'email' => $firebase_user->email,
                'phone' => $firebase_user->phoneNumber,
                'name' => $firebase_user->displayName,
                'password' => $firebase_user->passwordHash,
                'is_active' => true,
                'more_info_needed' => true
            ]
        );

        if(!$user->cart){
            $user->cart()->save(new Cart());
        }

        \Illuminate\Support\Facades\Auth::login($user);
        return response(['message' => 'Authenticated'], 200);

    }
    public function loginWithGithub() {
        return Socialite::driver('github')->scopes(['email'])->redirect();
    }
    public function handleLoginWithGithub() {
        $user = Socialite::driver('github')->user();
        dd($user);
    }
}
