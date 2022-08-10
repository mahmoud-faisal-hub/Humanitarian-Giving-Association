<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\AdminInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use RahulHaque\Filepond\Facades\Filepond;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('عرض الأعضاء')) {
            $admins = Admin::select(['id', 'name', 'email', 'status', 'created_at', 'updated_at'])
                            ->orderBy('created_at', 'desc')
                            ->with([
                                'roles' => function ($query) {
                                    $query->select(['id', 'name'])->where('name', '!=', 'Super Admin');
                                },
                                'info'
                            ])->whereDoesntHave('roles', function ($query) {
                                $query->where('name', 'Super Admin');
                            })
                            ->paginate(15);


            if (!$admins) {
                return abort(404);
            }

            return view('admin.admin.index', compact('admins'));
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
        if (Auth::user()->can('إضافة عضو')) {
            $roles = Role::where('name', '!=', 'Super Admin')->get();
            $permissions = Permission::get();
            return view('admin.admin.create', compact(['roles', 'permissions']));
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
    public function store(AdminRequest $request)
    {
        if (Auth::user()->can('إضافة عضو')) {
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($admin) {
                if (Auth::user()->can('تعيين دور')) {
                    if ($request->has('roles')) {
                        $admin->assignRole($request->roles);
                    }
                }

                if (Auth::user()->can('تعيين صلاحية')) {
                    if ($request->has('permissions')) {
                        $admin->givePermissionTo($request->permissions);
                    }
                }

                return response()->json([
                    'status' => true,
                    'msg' => 'تم إضافة العضو بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return $request;
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
        if (Auth::user()->can('عرض الأعضاء') || Auth::id() == $id) {
            $admin = Admin::select(['id', 'name', 'email', 'status'])->withCount('news')->with('info')->find($id);

            return view('admin.admin.show', compact('admin'));
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
        if (Auth::user()->canAny(['تعيين دور', 'تعيين صلاحية'])) {
            $admin = Admin::select(['id'])->with('roles:id', 'permissions:id')->find($id);
            $roles = Role::where('name', '!=', 'Super Admin')->get();
            $permissions = Permission::get();
            return view('admin.admin.edit', compact(['admin', 'roles', 'permissions']));
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
    public function update(AdminRequest $request, $id)
    {
        if (Auth::user()->can('تعديل عضو') || Auth::id() == $id) {
            $admin = Admin::withCount('info')->find($id);
            if ($admin->info_count) {
                $info = AdminInfo::where('admin_id', $admin->id)->first();
            } else {
                $info = AdminInfo::create([
                    'admin_id' => $admin->id
                ]);
            }

            if ($request->has('password') && $request->password) {
                $password = Hash::make($request->password);
            } else {
                $password = $admin->password;
            }

            if (Auth::id() == $id) {
                $status = $admin->status;
            } else {
                $status = $request->status? : 0;
            }

            $admin -> update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'status' => $status
            ]);

            if ($admin) {
                $info->update([
                    'about' => $request->about,
                ]);

                if ($info) {
                    return response()->json([
                        'status' => true,
                        'msg' => 'تم تعديل البيانات بنجاح',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return $request;
        } else {
            abort(401);
        }
    }

    /**
     * Update image for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request, $id)
    {
        if (Auth::user()->can('تعديل عضو') || Auth::id() == $id) {
            $info = AdminInfo::where('admin_id', $id)->first();
            if (!$info) {
                $info = AdminInfo::create([
                    'admin_id' => $id
                ]);
            }

            if ($request->has('image')) {
                if ($info->image == $request->image) {
                    $imageName = $info->image;
                } else {
                    $imageName = 'admin-' . uniqid() . '-' . now()->timestamp;
                    $imageInfo = Filepond::field($request->image)
                        ->moveTo('images/admins/' . $imageName);
                    $imageName = $imageInfo['basename'];
                }
            } else {
                if ($info->image && Storage::disk('public')->exists('images/admins/' . $info->image)) {
                    Storage::disk('public')->delete('images/admins/' . $info->image);
                }
                $imageName = null;
            }

            $info -> update([
                'image' => $imageName,
            ]);

            if ($info) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تعديل البيانات بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ - برجاء المحاولة مجدداً',
                ]);
            }

            return $request;
        } else {
            abort(401);
        }
    }

    /**
     * Update roles and permissions for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        if ((Auth::user()->canAny(['تعيين دور', 'تعيين صلاحية'])) && Auth::id() != $id) {
            $admin = Admin::find($id);

            if (Auth::user()->can('تعيين دور')) {
                $admin->syncRoles($request->roles);
            }

            if (Auth::user()->can('تعيين صلاحية')) {
                $admin->syncPermissions($request->permissions);
            }

            if ($admin) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تعديل الصصلاحيات بنجاح',
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
        if (Auth::user()->can('حذف عضو')) {
            $admin = Admin::find($id);

            if (!$admin) {
                return abort(404);
            }

            $admin -> delete();

            if ($admin) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف العضو بنجاح',
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
        if (Auth::user()->can('عرض الأعضاء')) {
            $admins = Admin::select(['id', 'name', 'email', 'created_at', 'updated_at'])
                                            ->orderBy('created_at', 'desc')
                                            ->with([
                                                'roles' => function ($query) {
                                                    $query->select(['id', 'name'])->where('name', '!=', 'Super Admin');
                                                },
                                            ])->whereDoesntHave('roles', function ($query) {
                                                $query->where('name', 'Super Admin');
                                            })
                                            ->where('email', 'LIKE', '%' . request()->get("search") . '%')
                                            ->paginate(15);

            if (!$admins) {
                return abort(404);
            }

            return view('admin.admin.index', compact('admins'));
        } else {
            abort(401);
        }
    }
}
