<?php

namespace App\Http\Controllers\Account;

use App\Notifications\CustomerRegisterNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Entities\Account;
use Illuminate\Support\Facades\Mail;
use Auth;
use Modules\News\Entities\News;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
//            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:accounts'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $this->messages());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function createCustomer(array $data)
    {
        return Account::create([
            'hash'          => Str::random(64),
            'first_name'    => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'         => $data['email'],
            'confirm'       => 1,
            'password'      => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @param  bool   $is_confirm
     * @return Customer
     */
    protected function createSubscription(array $data, $is_confirm)
    {
        $subscription = Subscription::where('email', $data['email'])->first();

        if(!$subscription){
            $subscription = new Subscription();
            $subscription->email = $data['email'];
            $subscription->fio = $data['first_name'];
        }

        if($is_confirm) {
            $subscription->confirm = 1;
        }

        $subscription->hash = Str::random(64);
        $subscription->save();

        return $subscription;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if(customer_auth()) {
            return redirect()->route('customer.account.home');
        }

        $is_ajax        = $request->ajax();
        $template       = $is_ajax ? 'modals.register' : 'auth.register';
        $login_route    = $is_ajax ? '#enter'     : route('customer.login');
        $forget_route   = $is_ajax ? '#reocover'  : route('customer.forget');
        $register_route = $is_ajax ? '#reg'       : route('customer.register');

        return view($template, compact('login_route', 'forget_route', 'register_route'));
    }

    public function confirmRegistration(string $token)
    {
        $customer = Account::where('hash', $token)->first();

        if($customer) {

            if(!$customer->confirm) {
                $customer->hash = NULL;
                $customer->confirm = 1;
                $customer->save();
            }

            $subscription = Subscription::where('email', $customer->email)->first();
            if($subscription && !$subscription->confirm) {
                $subscription->confirm = 1;
                $subscription->save();
            }

            $this->guard()->login($customer);

            $message_class = 'ok';
            $message_text = 'Спасибо! Ваш e-mail успешно подтвержден.';
        } else {
            $message_class = 'error';
            $message_text = 'Код подтверждения регистрации не найден. Возможно, вы уже подтвердили вашу почту ранее.';
        }
        
        Session::flash('message_class', $message_class);
        Session::flash('message_text', $message_text);
        
        return redirect()->route($message_class=='ok' ? 'user' : 'signin');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $result = false;
//        $validator = $this->validator($request->all());
//        if ($validator->fails()) {
//            return redirect()->route('register')
//                ->withErrors($validator)
//                ->withInput();
//        }

        $exist = Account::where('email', $request->get('email'))->first();

        if($exist) {
            return response()->json(array('result' => $result, 'message' => 'Пользователь уже зарегистрирован!'));
        }

        $result = true;
        $user = $this->createCustomer($request->all());

//        $is_subscribe = $request->get('subscribe');
        // подписка будет создана в любом случае - подвержденная или нет

//        $subscription = $this->createSubscription($request->all(), $is_subscribe);
//
        $this->guard()->login($user);
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if($user) {
            $res = [
                'login' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email
            ];

            $data['email'] = $user->email;
            $data['password'] = $request->get('password');

            $data['month'] = array(
                '01' => array('en' => 'january', 'uk' => 'cічня'),
                '02' => array('en' => 'february', 'uk' => 'лютого'),
                '03' => array('en' => 'march', 'uk' => 'березня'),
                '04' => array('en' => 'april', 'uk' => 'квітня'),
                '05' => array('en' => 'may', 'uk' => 'травня'),
                '06' => array('en' => 'june', 'uk' => 'червня'),
                '07' => array('en' => 'july', 'uk' => 'липня'),
                '08' => array('en' => 'august', 'uk' => 'серпня'),
                '09' => array('en' => 'september', 'uk' => 'вересня'),
                '10' => array('en' => 'october', 'uk' => 'жовтня'),
                '11' => array('en' => 'november', 'uk' => 'листопада'),
                '12' => array('en' => 'december', 'uk' => 'грудня'),
            );

            $data['news'] = News::where('vis', 1)
                ->orderBy('date', 'DESC')
                ->limit(2)
                ->get()
                ->toArray();

            Mail::send('emails.register', array('data' => $data), function ($message) use ($user) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($user->email, '')->subject('Регистрация на сайте');
            });

            return response()->json(array('user' => $res));
        }

        return response()->json(array('result' => 'false'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {        
        return Auth::guard('account');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        Session::flash('show_success_popup', 1);

        return redirect()->route('customer.login');
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
//            'password.min' => 'Пароль должен быть не менее 8 символов, используйте латинские буквы и цифры',
//            'password.required'  => 'Пароль должен быть не менее 8 символов, используйте латинские буквы и цифры',
        ];
    }
}
