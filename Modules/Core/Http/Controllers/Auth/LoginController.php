<?php

namespace Modules\Core\Http\Controllers\Auth;

use Auth;
use Da\TwoFA\Manager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Core\Entities\User;
use Modules\Core\Http\Controllers\Controller;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('core::auth.login');
    }

    public function login(Request $request)
    {
        $manager = new Manager();

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::where('login', $request->get('login'))->first();

        if($user && $user->auth_verify) {
            $login = $request->get('login');
            $password = $request->get('password');

            if(
                $request->post('code_1') &&
                $request->post('code_2') &&
                $request->post('code_3') &&
                $request->post('code_4') &&
                $request->post('code_5') &&
                $request->post('code_6')
            ) {
                $code = $request->post('code_1').
                        $request->post('code_2').
                        $request->post('code_3').
                        $request->post('code_4').
                        $request->post('code_5').
                        $request->post('code_6');

                if($manager->verify($code, $user->auth_verify_secret)) {
                    if ($this->attemptLogin($request)) {
                        return $this->sendLoginResponse($request);
                    }
                }
            } else {
                return \Illuminate\Support\Facades\View::make("core::auth.two_fact")
                    ->with("user", $user)
                    ->with("login", $login)
                    ->with("password", $password)
                    ->render();
//                return view('core::auth.login', compact('user', 'login', 'password'));
            }
        } else {
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout() {
        Auth::guard('web')->logout();
        return redirect('/admin');
    }

    public function username()
    {
        return 'login';
    }


}
