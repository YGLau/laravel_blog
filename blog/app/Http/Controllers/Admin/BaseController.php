<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BaseController extends Controller
{
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()) {
//            $realPath = $file->getRealPath(); // 获取文件全路径
            $extension = $file->getClientOriginalExtension(); // 获取文件扩展名
            $newName = date('YmdHis').mt_rand(100, 999).'.'.$extension;
            $file->move(base_path().'/uploads',$newName);
            $filePath = 'uploads/'.$newName;
            return $filePath;
        }
    }
}
