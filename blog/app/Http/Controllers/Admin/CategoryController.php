<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Category)->tree();
        return view('admin.category.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     * route:admin/category/create
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'cate_name' => 'required',
            'cate_order' => 'required',
        ];
        $msg = [
            'cate_name.required' => '分类名称必填!',
            'cate_order.required' => '排序必填',
        ];
        $validator = Validator::make($input, $rules, $msg);
        if ($validator->passes()) {
            $flag = Category::create($input);
            if ($flag) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '插入错误,请稍后重试!');
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
     * route: admin/category/{category}/edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Category::find($id);
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
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
        $data = Input::except('_token', '_method');
        $flag = Category::where('cate_id', $id)->update($data);
        if ($flag) {
            return redirect('admin/category');
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
        $re = Category::where('cate_id', $id)->delete();
        Category::where('cate_pid', $id)->update(['cate_pid' => 0]);
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

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $flag = $cate->update();
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
}
