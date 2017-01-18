<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class IndexController extends BaseController
{
    public function index() {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {
        if ($input = Input::all()) {
//            dd($input);
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $msg = [
                'password.required' => '新密码必须填写!',
                'password.between' => '新密码必须6到20位之间!',
                'password.confirmed' => '新密码和确认密码不匹配!',
            ];
            $validator = Validator::make($input, $rules, $msg);
//            dd($validator);
            if ($validator->passes()) {
                $user = User::first();
                if(Crypt::decrypt($user->user_pass) == $input['password_o']) {
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '修改成功!');
                } else {
                    return back()->with('errors', '原密码错误!');
                };
            } else {
                return back()->withErrors($validator);
            }
        } else {
            return view('admin.pass');
        }
    }
}
