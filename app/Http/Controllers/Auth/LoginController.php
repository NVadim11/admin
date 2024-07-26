<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Account;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;

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
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//		$this->middleware('guest')->except('logout');
//		$this->middleware('guest:account')->except('logout');
    }

	public function showLoginForm()
	{
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if($user) {
            return redirect()->to('/user');
        }

        return view('auth.login', compact('user'));
	}

	public function accountLogin(Request $request)
	{
	    if(!$request->getMethod('POST')){
            abort(404);
        }

        $user = [];
        $exist = Account::where('email', $request->post('email'))->first();

        if(!$exist) {
            return response()->json(array('message' => 'Пользователь не найден!'));
        }

        if (Auth::guard('account')->attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user = Auth::guard('account')->user();

            $res = [
                'login' => $user->login ? '@'.$user->login : $user->first_name . ' ' . $user->last_name,
                'email' => $user->email
            ];

            return response()->json(array('user' => $res));
        } else {
            return response()->json(array('message' => 'Пользователь не найден!'));
        }
	}

    public function logout() {
        Auth::guard('account')->logout();
        return redirect('/');
    }

	public function username()
	{
		return 'username';
	}
}
