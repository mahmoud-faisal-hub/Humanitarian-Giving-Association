<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalaryRequest;
use App\Models\Galary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RahulHaque\Filepond\Facades\Filepond;

class GalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('عرض المعرض')) {
            $galary = Galary::orderBy('created_at', 'desc')->paginate(15);
            return view("admin.galary.index", compact('galary'));
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
        if (Auth::user()->can('إضافة وسائط')) {
            return view("admin.galary.create");
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
    public function store(GalaryRequest $request)
    {
        if (Auth::user()->can('إضافة وسائط')) {
            $fileName = 'galary-' . uniqid() . '-' . now()->timestamp;
            $fileInfos = Filepond::field($request->galary)
                ->moveTo('images/galary/' . $fileName);

            foreach ($fileInfos as $fileInfo) {
                $galary = Galary::create([
                    'file' => $fileInfo['basename'],
                    'extension' => $fileInfo['extension'],
                    'description' => $request->description,
                ]);
            }

            if ($galary) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة الوسائط بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return response()->json($request);
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galary  $galary
     * @return \Illuminate\Http\Response
     */
    public function show(Galary $galary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galary  $galary
     * @return \Illuminate\Http\Response
     */
    public function edit(Galary $galary)
    {
        if (Auth::user()->can('تعديل وسائط')) {
            return view("admin.galary.edit", compact('galary'));
        } else {
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galary  $galary
     * @return \Illuminate\Http\Response
     */
    public function update(GalaryRequest $request, Galary $galary)
    {
        if (Auth::user()->can('تعديل وسائط')) {
            if ($galary->file == $request->galary) {
                $fileInfo['basename'] = $galary->file;
                $fileInfo['extension'] = $galary->extension;
            } else {
                if (Storage::disk('public')->exists('images/galary/' . $galary->file)) {
                    Storage::disk('public')->delete('images/galary/' . $galary->file);
                }
                $fileName = 'galary-' . uniqid() . '-' . now()->timestamp;
                $fileInfo = Filepond::field($request->galary)
                    ->moveTo('images/galary/' . $fileName);
            }

            $galary->update([
                'file' => $fileInfo['basename'],
                'extension' => $fileInfo['extension'],
                'description' => $request->description,
            ]);

            if ($galary) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة الوسائط بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return response()->json($request);
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galary  $galary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galary $galary)
    {
        if (Auth::user()->can('حذف وسائط')) {
            if (!$galary) {
                return abort(404);
            }

            if ($galary->file && Storage::disk('public')->exists('images/galary/' . $galary->file)) {
                Storage::disk('public')->delete('images/galary/' . $galary->file);
            }

            $galary -> delete();

            if ($galary) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف الملف بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحذف - برجاء المحاولة مجدداً',
                ]);
            }
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
        if (Auth::user()->can('عرض المعرض')) {
            $galary = Galary::where('description', 'LIKE', '%' . request()->get("search") . '%')->orderBy('created_at', 'desc')->paginate(15);

            if (!$galary) {
                return abort(404);
            }

            // return $category;
            return view("admin.galary.index", compact('galary'));
        } else {
            abort(401);
        }
    }
}
