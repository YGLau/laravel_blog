<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use \View;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        // 最新发布的8篇文章
        $newArticles = Article::orderBy('art_time', 'desc')->take(8)->get();
        // 点击排行5篇文章
        $hotClick = Article::orderBy('art_view', 'desc')->take(5)->get();
        $navs = Navs::all();
        View::share('navs', $navs);
        View::share('newArticles', $newArticles);
        View::share('hotClick', $hotClick);
    }
}
