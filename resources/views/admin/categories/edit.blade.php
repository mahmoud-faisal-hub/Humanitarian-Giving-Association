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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("category.index") }}">الأقسام</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل القسم</span>
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
                    <h4 class="card-title mb-1">تعديل القسم</h4>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="POST" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="form-label">عنوان الخبر <span class="tx-danger">*</span></label>
                            <input name="name" type="text" class="form-control" id="name" value="{{ $category->name }}">
                            <strong id="name_error" class="form-text text-danger"></strong>
                        </div>
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
        'url' => route('category.update', $category->id),
        'method' => 'POST',
    ])
@endsection
