<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        //$this->middleware('guest');

        $this->redirectTo = route('customer.login');
    }

    public function broker()
    {
        return Password::broker('customers');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $email
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $email = null, $token = null)
    {        
        if(customer_auth()) {
            return redirect()->route('customer.account.home');
        }

        $tokenData = DB::table('password_resets')
            ->where('email', $email)->first();

        if(!$tokenData || !Hash::check($token, $tokenData->token)) {
            return redirect()->
                route('customer.forget')->withErrors(['Ссылка устарела']);
        }

        return view('auth.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.confirmed' => 'Введенный пароль не совпадает с подтверждением',
        ];
    }

}
