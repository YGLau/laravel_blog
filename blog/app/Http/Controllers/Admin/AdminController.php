<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class AdminController extends BaseController
{
    public function login()
    {
        if ($input = Input::all()) {
            // 验证验证码
            $code = new \Code();
            $codeRes = $code->get();
            if (strtoupper($input['code']) != $codeRes) {
                return back()->with('msg', '验证码错误');
            }
            // 验证用户名和密码
            $user = User::first();
            if ($input['user_name'] != $user->user_name || $input['user_pass'] != Crypt::decrypt($user->user_pass)) {
                return back()->with('msg', '用户名或密码错误');
            }
            // 写入session
            session(['user' => $user]);
            // 跳转到后台首页
            return redirect('admin/index');
        } else {
//            session(['user' => null]);
            return view('admin.login');
        }
    }

    public function code()
    {
        $code = new \Code();
        $code->make();
    }

    public function getCode()
    {
        $code = new \Code();
        echo $code->get();
    }

    public function quit()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }

}
