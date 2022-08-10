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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("role.index") }}">الأدوار</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة دور</span>
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
                    <h4 class="card-title mb-1">إضافة دور</h4>
                    <p class="mb-2">إضافة المزيد من الأدوار</p>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="POST" action="{{ route('role.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="category" class="form-label">إسم الدور <span class="tx-danger">*</span></label>
                            <input name="name" type="text" class="form-control" id="category" required>
                            <strong id="name_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="row row-sm">
                            <label class="form-label mb-2" >صلاحيات الدور: </label>
                            <strong id="permissions_error" class="form-text text-danger"></strong>
                            @foreach ($permissions as $permission)
                                <div class="col-6 col-md-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->id }}" id="flexCheckChecked{{ $permission->id }}">
                                            <label class="form-check-label mg-r-25 w-100" for="flexCheckChecked{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus ms-2"></i> إضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection

@section('js')
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <!--Internal  Parsley js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/i18n/ar.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        $("form").parsley({
            excluded: ":disabled,:hidden",
            iffMessage: "كلمتا المرور غير متطابقتين",
        }).validate();
    </script>

    {{-- AJAX --}}
    @include('ajax', [
        'url' => route('role.store'),
        'method' => 'POST',
        'clear' => true
    ])
@endsection


