<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Article::orderBy('art_id', 'desc')->Paginate(10);
        return view('admin.article.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add', compact('data'));
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
        $input['art_time'] = time();
        $rules = [
            'cate_id' => 'required',
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $msg = [
            'cate_id.required' => '分类不能为空!',
            'art_title.required' => '文章标题不能为空!',
            'art_content.required' => '文章内容不能为空!',
        ];
        $validator = Validator::make($input, $rules, $msg);
        if ($validator->passes()) {
            $re = Article::create($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '插入失败!');
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
        $field = Article::find($id);
        $data = (new Category)->tree();
        return view('admin.article.edit', compact('field', 'data'));
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
        $input= Input::except('_token', '_method');
        $re = Article::where('art_id', $id)->update($input);
        if ($re) {
            return redirect('admin/article');
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
        $re = Article::where('art_id', $id)->delete();
        if ($re) {
            $data = [
                'status' => 1,
                'msg' => '删除成功!'
            ];
        } else {
            $data = [
                'status' => 0,
                'msg' => '删除失败!'
            ];
        }
        return $data;
    }
}
