<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest_news = News::select(['id', 'image', 'title', 'content'])->orderBy('created_at', 'desc')->take(10)->get();

        $categories = Category::select(['id', 'name'])->with(['news' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }])->orderBy('created_at', 'asc')->take(4)->get()->map(function ($query) {
                        $query->setRelation('news', $query->news->take(4));
                        return $query;
                    });

        //return response() -> json($categories);
        return view("web.home", compact([
            'latest_news',
            'categories'
        ]));
    }
}
