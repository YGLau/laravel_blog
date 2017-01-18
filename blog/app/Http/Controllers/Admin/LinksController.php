<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LinksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $flag = $links->update();
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
        return view('admin.links.add');
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
            'link_name' => 'required',
            'link_order' => 'required',
        ];
        $msg = [
            'link_name.required' => '链接名称必须填写!',
            'link_order.required' => '排序必须填写!',
        ];
        $validator = Validator::make($data, $rules, $msg);
        if ($validator->passes()) {
            $re = Links::create($data);
            if ($re) {
                return redirect('admin/links');
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
        $field = Links::find($id);
        return view('admin.links.edit', compact('field'));
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
        $re = Links::where('link_id', $id)->update($input);
        if ($re) {
            return redirect('admin/links');
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
        $re = Links::where('link_id', $id)->delete();
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
