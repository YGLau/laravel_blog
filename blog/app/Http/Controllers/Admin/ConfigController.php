<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ConfigController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Config::orderBy('conf_order', 'asc')->get();
        foreach ($data as $k => $v) {
            switch ($v->field_type) {
                case 'input';
                    $data[$k]->_html = '<input type="text" name="conf_content[]" class="lg" value="'.$v->conf_content.'" />';
                    break;
                case 'textarea';
                    $data[$k]->_html = '<textarea type="text" name="conf_content[]" class="lg">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio';
                    $arr = explode(',', $v->field_value);
                    $str = '';
                    foreach ($arr as $m => $n) {
                        $r = explode('|', $n);
                        $c = $v->conf_content == $r[0]? ' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" '.$c.' value="'.$r[0].'">'.$r[1].'        ';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index', compact('data'));
    }

    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k => $v) {
            Config::where('conf_id', $v)->update(['conf_content' => $input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors', '修改成功!');
    }

    public function changeOrder()
    {
        $input = Input::all();
        $Config = Config::find($input['conf_id']);
        $Config->conf_order = $input['conf_order'];
        $flag = $Config->update();
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

    public function putFile()
    {
        $config = Config::pluck('conf_content', 'conf_name')->all();
        // 组装出路劲
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($config, true).';';
        file_put_contents($path, $str);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config.add');
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
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];
        $msg = [
            'conf_name.required' => '名称必须填写!',
            'conf_title.required' => '标题必须填写!',
        ];
        $validator = Validator::make($data, $rules, $msg);
        if ($validator->passes()) {
            $re = Config::create($data);
            if ($re) {
                return redirect('admin/conf');
            } else {
                return back()->with('errors', '插入错误!');
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
        $field = Config::find($id);
        return view('admin.config.edit', compact('field'));
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
        $re = Config::where('conf_id', $id)->update($input);
        if ($re) {
            $this->putFile();
            return redirect('admin/conf');
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
        $re = Config::where('conf_id', $id)->delete();
        if ($re) {
            $this->putFile();
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
