<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$category = Category::with("news.user") -> get();*/
        $categories = Category::select(['id' ,'name'])->withCount('news')->paginate(50);
        //return response() -> json($categories);
        return view("web.categories.index", compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $category = Category::select(['id', 'name']) -> find($id);

        if (!$category) {
            return abort(404);
        }

        $category->setRelation('news', $category->news()->select(['id', 'image', 'title', 'content', 'created_at'])->orderBy('created_at', 'desc')->paginate(40));

        if (!$category) {
            return abort(404);
        }

        // return response() -> json($category);
        return view('web.categories.show', compact('category'));
    }
}
