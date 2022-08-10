<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\TemporaryFile;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RahulHaque\Filepond\Facades\Filepond;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('عرض الأخبار')) {
            $news = News::select(['id', 'image', 'title', 'content', 'category_id', 'created_by', 'created_at', 'updated_at'])
                        ->orderBy('created_at', 'desc')
                        ->without(['user.info'])
                        ->with([
                            'user:id,name',
                            'category:id,name',
                        ])->paginate(15);

            if (!$news) {
                return abort(404);
            }

            return view('admin.news.index', compact('news'));
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
        if (Auth::user()->can('إضافة خبر')) {
            $categories = Category::get();
            return view("admin.news.create", compact('categories'));
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
    public function store(NewsRequest $request)
    {
        if (Auth::user()->can('إضافة خبر')) {
            if ($request->has('image')) {
                $imageName = 'news-' . uniqid() . '-' . now()->timestamp;
                $imageInfo = Filepond::field($request->image)
                    ->moveTo('images/news/' . $imageName);
                $imageName = $imageInfo['basename'];
            } else {
                $imageName = null;
            }

            $news = News::create([
                'image' => $imageName,
                'title' => $request->title,
                'content' => $request->content,
                'article' => $request->article,
                'created_by' => Auth::user()->id,
                'category_id' => $request->category_id,
            ]);

            if ($news) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة الخبر بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }
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
        if (Auth::user()->can('تعديل خبر')) {
            $news = News::find($id);

            if (!$news) {
                return abort(404);
            }

            $categories = Category::get();

            return view('admin.news.edit', compact('news', 'categories'));
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
    public function update(NewsRequest $request, $id)
    {
        if (Auth::user()->can('تعديل خبر')) {
            $news = News::find($id);

            if (!$news) {
                return abort(404);
            }

            if ($request->has('image')) {
                if ($news->image == $request->image) {
                    $imageName = $news->image;
                } else {
                    $imageName = 'news-' . uniqid() . '-' . now()->timestamp;
                    $imageInfo = Filepond::field($request->image)
                        ->moveTo('images/news/' . $imageName);
                    $imageName = $imageInfo['basename'];
                }
            } else {
                if ($news->image && Storage::disk('public')->exists('images/news/' . $news->image)) {
                    Storage::disk('public')->delete('images/news/' . $news->image);
                }
                $imageName = null;
            }

            $news -> update([
                'image' => $imageName,
                'title' => $request->title,
                'content' => $request->content,
                'article' => $request->article,
                'created_by' => Auth::user()->id,
                'category_id' => $request->category_id,
            ]);

            if ($news) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تعديل الخبر بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            // return redirect() -> back() -> with(["success" => "تم تعديل القسم بنجاح"]);

            // return News::select('image')->find($id)->image;
            // return $request;
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
        if (Auth::user()->can('حذف خبر')) {
            $news = News::find($id);

            if (!$news) {
                return abort(404);
            }

            if ($news->image && Storage::disk('public')->exists('images/news/' . $news->image)) {
                Storage::disk('public')->delete('images/news/' . $news->image);
            }

            $news -> delete();

            if ($news) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف الخبر بنجاح',
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
    public function search($category_id = null)
    {
        if (Auth::user()->can('عرض الأخبار')) {
            if (!empty($category_id)) {
                $category = Category::select(['id', 'name'])->find($category_id);
                $category->setRelation('news', $category->news()->select(['id', 'image', 'title', 'content', 'created_by', 'created_at', 'updated_at'])->where('title', 'LIKE', '%' . request()->get("search") . '%')->orderBy('created_at', 'desc')->with('user', function ($query) {
                    $query->select(['id', 'name']);
                })->paginate(15));
            } else {
                $news = News::select(['id', 'image', 'title', 'content', 'category_id', 'created_by', 'created_at', 'updated_at'])
                            ->with([
                                'user:id,name',
                                'category:id,name'
                            ])
                            ->where('title', 'LIKE', '%' . request()->get("search") . '%')
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

                return view('admin.news.index', compact('news'));
            }

            if (!$category) {
                return abort(404);
            }

            // return $category;
            return view('admin.categories.show', compact('category'));
        } else {
            abort(401);
        }
    }
}
