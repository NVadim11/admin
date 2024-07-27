<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Entities\Account;
use Modules\Graves\Entities\Grave;
use Symfony\Component\VarDumper\VarDumper;

class IndexController extends Controller
{

    public function signup(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if($user) {
            return redirect()->to('user');
        }

        return view('account.signup', compact('user'));
    }

    public function register(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if($user) {
            return redirect()->to('user');
        }

        return view('account.signup');
    }

    public function user(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }
        $account = Account::where('id', $user->id)->first();

        $graves_control = Grave::whereRaw("control_by = " . $user->id)
            ->orderByRaw("pos ASC")
            ->get();

        $graves_created = Grave::whereRaw("created_by = " . $user->id)
            ->orderByRaw("pos ASC")
            ->get();

        $graves_parents = Grave::whereRaw("id in (select grave_id from accounts_graves_parents where account_id = " . $user->id . ")")
            ->orderByRaw("pos ASC")
            ->get();

        $graves_following = Grave::whereRaw("id in (select grave_id from accounts_graves_follow where account_id = " . $user->id . ")")
            ->orderByRaw("pos ASC")
            ->get();

        return view('account.profile', compact('user', 'account', 'graves_control', 'graves_created', 'graves_parents', 'graves_following'));
    }

    public function userOrders(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        return view('account.orders', compact('user'));
    }

    public function userSpecial(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        return view('account.special', compact('user'));
    }

    public function userFavorite(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        return view('account.favorite', compact('user'));
    }

    public function userBooking(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        return view('account.booking', compact('user'));
    }

    public function userCard(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        return view('account.card', compact('user'));
    }

    public function checkData($type, $data, $id) {
        $user = Account::where('id', $id)->first();

        switch($type) {
            case 'login':
                if($user->login == $data) {
                    $res = [
                        'res' => false,
                        'message' => 'Логин уже есть в базе'
                    ];

                    return json_encode($res);
                }
                break;
            case 'email': break;
            case 'phone': break;
        }
    }

    public function userUpdate(Request $request)
    {
        $user = Auth::guard('account')->user() ? Auth::guard('account')->user() : [];

        if(!$user) {
            return redirect()->to('signin');
        }

        if( $request->post('current_password') &&
            $request->post('new_password') &&
            $request->post('repeat_new_password')) {

            if(Hash::check($request->post('current_password'), $user->password)) {
                $new_password = $request->post('new_password');
            } else {
                return response()->json(array('result' => 'invalid_password'));
            }
        }

        if(!empty($request->avatar) && $request->avatar != 'undefined') {
            $file = $request->avatar;
            if ($file instanceof UploadedFile) {
                try {
                    $image = $file->store('/images');
                    $response['uploadName'] = '/uploads/' . $image;
                    $response['success'] = true;
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return "Ошибка при загрузке файла";
            }
        }

        if(!empty($request->post('login'))) {
            $exist = Account::where('login', $request->post('login'))->where('id', '!=', $user->id)->first();
            if($exist) {
                return response()->json(array('result' => 'nick_exist'));
            }
        }

        if(!empty($request->post('phone'))) {
            $exist = Account::where('phone', $request->post('phone'))->where('id', '!=', $user->id)->first();
            if($exist) {
                return response()->json(array('result' => 'phone_exist'));
            }
        }

        if(!empty($request->post('email'))) {
            $exist = Account::where('email', $request->post('email'))->where('id', '!=', $user->id)->first();
            if($exist) {
                return response()->json(array('result' => 'email_exist'));
            }
        }

        $user = Account::where('id', $user->id)->first();
        $user->login = $request->post('login');
        $user->first_name = $request->post('first_name');
        $user->last_name = $request->post('last_name');
        $user->phone = $request->post('phone');
        $user->country = $request->post('country');
        $user->city = $request->post('city');
        $user->instagram = $request->post('instagram');
        $user->facebook = $request->post('facebook');
        $user->telegram = $request->post('telegram');

        if(!empty($request->avatar) && $request->avatar != 'undefined') {
            $user->avatar = 'images/' . $request->avatar->hashName();
        }

        if(!empty($new_password)) {
            $user->password = Hash::make($new_password);
            $user->hash = Str::random(64);
        }

        $user->save();

        return response()->json(array('result' => 'true'));
//        return view('account.profile', compact('user'));
    }
}
