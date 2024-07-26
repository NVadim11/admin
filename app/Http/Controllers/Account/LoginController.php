<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    /**
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('accounts');
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        if(customer_auth()) {

            return view('account.redirect_to_account');
            //return redirect()->route('customer.account.home');
        }

        $is_ajax        = $request->ajax();
        $template       = $is_ajax ? 'modals.login' : 'auth.login';
        $login_route    = $is_ajax ? '#enter'     : route('customer.login');
        $forget_route   = $is_ajax ? '#reocover'  : route('customer.forget');
        $register_route = $is_ajax ? '#reg'       : route('customer.register');

        return view($template, compact('login_route', 'forget_route', 'register_route'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email|exists:accounts|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];
        $messages = [
            'email.not_confirm' => 'Ваш емейл не подтвержден. Перейдите по ссылке в письме, чтобы подтвердить вашу регистрацию',
            'email.exists' => 'Неверный e-mail/пароль',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $message = '';

        if(!$validator->fails()) {

            $customer = Customer::where($this->username(), $request->get($this->username()))->first();

            if(!$customer || !$customer->confirm) {

                $validator->errors()->add('email', $messages['email.not_confirm']);

                $message = $validator->errors();

            } else if(Auth::guard('accounts')->attempt($request->only($this->username(),'password'), $request->filled('remember'))){

                // update saved products from session
                customer_user()->appendSavedToLater();

//                return customer_user()->redirectOnLogin();

                $message = 'ok';

            } else {
                $validator->errors()->add('email', $messages['email.exists']);
                $message = $validator->errors();
            }
        }

        return $message;

//        return redirect()
//            ->route('signin', 'login')
//            ->withErrors($validator)
//            ->withInput();
    }

    public function logout(Request $request) {
        Auth::guard('accounts')->logout();
        return redirect('/');
    }


    /**
     * @return string
     */
    public function username()
    {
        return 'email';
    }

}
