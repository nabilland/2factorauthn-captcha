<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

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
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $maxAttempts = 2;
    protected $decayMinutes = 1; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        if ($this->isCaptchaRequired($request)) {
            $rules['captcha'] = 'required|captcha';
        }

        $request->validate($rules);
    }

    protected function isCaptchaRequired(Request $request)
    {
        return $this->hasTooManyLoginAttempts($request);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors(['captcha' => 'Too many login attempts. Please enter the captcha.']);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->uses_two_factor_auth) {
            $google2fa = new Google2FA();

            if ($request->session()->has('2fa_passed')) {
                $request->session()->forget('2fa_passed');
            }

            $request->session()->put('2fa:user:id', $user->id);
            $request->session()->put('2fa:auth:attempt', true);
            $request->session()->put('2fa:auth:remember', $request->has('remember'));

            $otp_secret = $user->google2fa_secret;
            $one_time_password = $google2fa->getCurrentOtp($otp_secret);

            return redirect()->route('2fa')->with('one_time_password', $one_time_password);
        }

        return redirect()->intended($this->redirectPath());
    }
}
