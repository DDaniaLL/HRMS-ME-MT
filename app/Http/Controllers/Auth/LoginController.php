<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'employee_number';

    }

    protected function validateLogin(Request $request)
    {
        // $this->validate($request, [
        //     $this->username() => 'exists:users,'.$this->username().',employee_number,10011001',
        //     'password' => 'required|string',
        // ], [
        //     $this->username().'.exists' => 'This login method is not accepted, Only login via Okta is possible.',
        // ]);
    }

    public function redirectToProvider()
    {

        return Socialite::driver('okta')->redirect();

    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('okta')->user();

        $localUser = User::where('email', $user->email)->first();

        // Create a local user with the email and token from Okta
        // if (!$localUser) {
        //     $localUser = User::create([
        //         'email' => $user->email,
        //         'name' => $user->name,
        //         'token' => $user->token,
        //     ]);
        // } else {

        if (! $localUser) {
            return redirect(route('login'))->withErrors(['Account is not found - Contact HR']);
        } else {

            // if the user already exists, just update the token:
            $localUser->token = $user->token;
            $localUser->save();
        }

        try {
            Auth::login($localUser);
        } catch (\Throwable $e) {
            return redirect('/login/okta');
        }

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
