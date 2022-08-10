@extends('admin.layouts.master')

@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("admin.index") }}">الأعضاء</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الصلاحيات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">تعديل الصلاحيات</h4>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.update', $admin->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @can('تعيين دور')
                            <div class="row row-sm">
                                <label class="form-label mb-2" >الأدوار: </label>
                                <strong id="roles_error" class="form-text text-danger"></strong>
                                @foreach ($roles as $role)
                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="roles[]" type="checkbox" value="{{ $role->id }}" id="flexCheckChecked{{ $role->id }}" @checked($admin->roles->contains('id', $role->id))>
                                                <label class="form-check-label mg-r-25 w-100" for="flexCheckChecked{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endcan
                        @can('تعيين صلاحية')
                            <div class="row row-sm">
                                <label class="form-label mb-2" >الصلاحيات: </label>
                                <strong id="permissions_error" class="form-text text-danger"></strong>
                                <div class="alert alert-info rounded" role="alert">
                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa-solid fa-circle-info ms-2"></i></strong> يفترض أن الأدوار تحتوى على مجموعة من الصلاحيات لذا فإن قمت بتحديد ادوار لهذا المستخدم فلا ضرورة من تحديد نفس صلاحيات الدور مرة أخرى إلا إذا كنت تريده الإحتفاظ بصلاحايت معينة فى حالة إزالة الدور عنه
                                </div>
                                @foreach ($permissions as $permission)
                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->id }}" id="flexCheckChecked{{ $permission->id }}" @checked($admin->permissions->contains('id', $permission->id))>
                                                <label class="form-check-label mg-r-25 w-100" for="flexCheckChecked{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endcan
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen ms-2"></i> تعديل</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection

@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    {{-- AJAX --}}
    @include('ajax', [
        'url' => route('admin.update.permissions', $admin->id),
        'method' => 'POST',
    ])
@endsection
