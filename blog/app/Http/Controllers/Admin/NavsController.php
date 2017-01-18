<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class NavsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Navs::orderBy('nav_order', 'asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $navs = Navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $flag = $navs->update();
        if ($flag) {
            $data = [
                'status' => 1,
                'msg' => '修改成功!',
            ];
        } else {
            $data = [
                'status' => 0,
                'msg' => '修改失败!',
            ];
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.navs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Input::except('_token');
        $rules = [
            'nav_name' => 'required',
            'nav_order' => 'required',
        ];
        $msg = [
            'nav_name.required' => '链接名称必须填写!',
            'nav_order.required' => '排序必须填写!',
        ];
        $validator = Validator::make($data, $rules, $msg);
        if ($validator->passes()) {
            $re = Navs::create($data);
            if ($re) {
                return redirect('admin/navs');
            } else {
                return back()-with('errors', '插入错误!');
            }
        } else {
            return back()->withErrors($validator);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Navs::find($id);
        return view('admin.navs.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except('_token', '_method');
        $re = Navs::where('nav_id', $id)->update($input);
        if ($re) {
            return redirect('admin/navs');
        } else {
            return back()->with('errors', '更新失败!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = Navs::where('nav_id', $id)->delete();
        if ($re) {
            $data = [
                'status' => 1,
                'msg' => '删除成功!',
            ];
        } else {
            $data = [
                'stastus' => 0,
                'msg' => '删除失败!',
            ];
        }
        return $data;
    }
}
