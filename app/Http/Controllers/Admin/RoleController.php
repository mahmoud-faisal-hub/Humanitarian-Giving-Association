<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('عرض الأدوار')) {
            $roles = Role::where('name', '!=', 'Super Admin')->paginate(15);

            return view("admin.roles.index", compact('roles'));
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
        if (Auth::user()->can('إضافة دور')) {
            $permissions = Permission::get();

            return view("admin.roles.create", compact('permissions'));
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
    public function store(RoleRequest $request)
    {
        if (Auth::user()->can('إضافة دور')) {
            $role = Role::create([
                'name' => $request->name,
            ])->givePermissionTo($request->permissions);

            if ($role) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة الدور بنجاح',
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
        if (Auth::user()->can('تعديل دور')) {
            $role = Role::with('permissions:id')->find($id);
            $permissions = Permission::get();

            return view("admin.roles.edit", compact('role', 'permissions'));
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
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('تعديل دور')) {
            $role = Role::find($id);

            if (!$role) {
                return abort(404);
            }

            $role->syncPermissions($request->permissions)->update(['name' => $request->name]);

            if ($role) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تعديل الدور بنجاح',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('حذف دور')) {
            $role = Role::find($id);

            if (!$role) {
                return abort(404);
            }

            $role->delete();

            if ($role) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف الدور بنجاح',
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
        if (Auth::user()->can('عرض الأدوار')) {
            $roles = Role::where('name', 'LIKE', '%' . request()->get("search") . '%')->where('name', '!=', 'Super Admin')->paginate(15);

            if (!$roles) {
                return abort(404);
            }

            // return $category;
            return view("admin.roles.index", compact('roles'));
        } else {
            abort(401);
        }
    }
}
