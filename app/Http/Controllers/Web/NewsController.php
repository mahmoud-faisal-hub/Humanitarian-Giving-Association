<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $news = News::select(['id', 'title', 'article', 'created_at', 'category_id']) -> with(['category' => function ($query) {
            $query->select('id', 'name');
        }]) -> find($id);

        if (!$news) {
            return abort(404);
        }

        // return response() -> json($news);
        return view('web.news.index', compact('news'));
    }

    /**
     * Display the search resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        // return "";
        //$news = News::select(['id', 'image', 'title', 'content', 'created_at'])->where('title', 'LIKE', '%' . request()->get("search") . '%')->orWhere('content', 'LIKE', '%' . request()->get("search") . '%')->orderBy('created_at', 'desc')->paginate(40);
        $news = News::select(['id', 'image', 'title', 'content', 'created_at'])->search(request()->get("search"), ['title', 'content', 'article'])->paginate(40);
        return view('web.news.search', compact('news'));
    }
}
