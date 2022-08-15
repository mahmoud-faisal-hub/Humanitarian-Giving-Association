<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('عرض الأقسام')) {
            /*$category = Category::with("news.user") -> get();
            return response() -> json($category);*/
            $categories = Category::paginate(15);
            return view("admin.categories.index", compact('categories'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('إضافة قسم')) {
            return view("admin.categories.create");
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (Auth::user()->can('إضافة قسم')) {
            $category = Category::create([
                'name' => $request->name,
            ]);

            if ($category) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة القسم بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return redirect() -> back() -> with(["success" => "تم تسجيل القسم بنجاح"]);
        } else {
            abort(401);
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
        if (Auth::user()->can('عرض الأخبار')) {
            // $category = Category::with("news.user") -> find($id);

            $category = Category::select(['id', 'name'])->find($id);
            if (!$category) {
                abort(404);
            }

            $category->setRelation('news', $category->news()->select(['id', 'image', 'title', 'content', 'created_by', 'created_at', 'updated_at'])->orderBy('created_at', 'desc')->with('user', function ($query) {
                $query->select(['id', 'name']);
            })->paginate(15));

            if (!$category) {
                return abort(404);
            }

            // return $category;
            return view('admin.categories.show', compact('category'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('تعديل قسم')) {
            $category = Category::select('id', 'name') -> find($id);

            if (!$category) {
                return abort(404);
            }

            //$category = Category::select('id', 'name') -> find($id);

            return view('admin.categories.edit', compact('category'));
        } else {
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (Auth::user()->can('تعديل قسم')) {
            $category = Category::select('id', 'name') -> find($id);

            if (!$category) {
                return abort(404);
            }

            $category -> update([
                'name' => $request->name
            ]);

            if ($category) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تعديل القسم بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            // return redirect() -> back() -> with(["success" => "تم تعديل القسم بنجاح"]);
        } else {
            abort(401);
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
        if (Auth::user()->can('حذف قسم')) {
            $category = Category::find($id);

            if (!$category) {
                return abort(404);
            }

            $category -> delete();

            if ($category) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف القسم بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحذف - برجاء المحاولة مجدداً',
                ]);
            }

            // return redirect() -> back() -> with(["success" => "تم الحذف القسم بنجاح"]);
        } else {
            abort(401);
        }
    }

    /**
     * Display the search resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (Auth::user()->can('عرض الأقسام')) {
            $categories = Category::where('name', 'LIKE', '%' . request()->get("search") . '%')->paginate(15);

            if (!$categories) {
                return abort(404);
            }

            // return $category;
            return view("admin.categories.index", compact('categories'));
        } else {
            abort(401);
        }
    }
}
