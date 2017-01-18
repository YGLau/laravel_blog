<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        // 获取点击量最高的6篇文章
        $hotArticle = Article::orderBy('art_view', 'desc')->take(6)->get();
        // 按创建时间排序,拿到最新5篇文章
        $timeLine = Article::orderBy('art_time', 'desc')->paginate(5);
        // 友情链接
        $links = Links::orderBy('link_order', 'asc')->get();
        return view('home.index', compact('hotArticle', 'timeLine', 'links'));
    }

    public function cate($nav_id)
    {
        $nav = Navs::find($nav_id);
        $cate = Category::find($nav_id);
        $articles = Article::where('cate_id', $nav_id)->paginate(4);
        $subCates= Category::where('cate_pid', $nav_id)->get();
        //分类自增
        Category::where('cate_id', $nav_id)->increment('cate_view');
        return view('home.list', compact('nav', 'cate', 'articles', 'subCates'));
    }

    public function article($art_id)
    {
        $article = Article::join('category','article.cate_id','=','category.cate_id')->where('art_id', $art_id)->first();
        // 上一篇
        $linkArt['pre'] = Article::where('art_id', '<', $art_id)->orderBy('art_id', 'desc')->first();
        // 下一篇
        $linkArt['next'] = Article::where('art_id', '>', $art_id)->orderBy('art_id', 'asc')->first();
        // 相关文章
        $linkArts = Article::where('cate_id', $article->cate_id)->orderBy('art_id', 'desc')->take(4)->get();
        // 查看次数自增
        Article::where('art_id', $art_id)->increment('art_view');
        return view('home.new', compact('article', 'linkArt', 'linkArts'));
    }
}
