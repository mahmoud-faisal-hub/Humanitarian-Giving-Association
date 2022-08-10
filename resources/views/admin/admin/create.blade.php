@extends('admin.layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .wizard > .steps > ul li {
            margin-left: 20px !important;
        }

        .wizard > .steps > ul li .title {
            margin-right: 10px !important;
        }

        #error {
            display: none;
        }
    </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("admin.index") }}">الأعضاء</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة عضو</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="main-content-label mg-b-5">
									إضافة عضو جديد
								</div>
								<p class="mg-b-20">إضافة عضو جديد مع تعيين الأدوار والصلاحيات</p>
                                <div class="alert alert-danger mg-b-0" role="alert" id="error">
                                    <span id="message">خطأ</span>
                                </div>
                                <form id="admin-create" method="POST" action="{{ route('news.store') }}">
                                    @csrf
                                    <div id="wizard">
                                        <h3>إضافة عضو</h3>
                                        <section>
                                            <p class="mg-b-20">قم بإضافة بيانات العضو الجديد</p>
                                            <div class="row row-sm">
                                                <div class="col-12 col-lg-6 mg-t-20">
                                                    <label class="form-control-label">الإسم: <span class="tx-danger">*</span></label> <input class="form-control" id="name" name="name" placeholder="أدخل الإسم بالكامل" required="" type="text" autocomplete="name" maxlength="255">
                                                    <strong id="name_error" class="form-text text-danger"></strong>
                                                </div>
                                                <div class="col-12 col-lg-6 mg-t-20">
                                                    <label class="form-control-label">الإيميل: <span class="tx-danger">*</span></label> <input class="form-control" id="email" name="email" placeholder="أدخل الإيميل" required="" type="email" autocomplete="email" maxlength="255">
                                                    <strong id="email_error" class="form-text text-danger"></strong>
                                                </div>
                                                <div class="col-12 col-lg-6 mg-t-20">
                                                    <label class="form-control-label">كلمة المرور: <span class="tx-danger">*</span></label> <input class="form-control" id="password" data-parsley-iff="#confirm" name="password" placeholder="أدخل كلمة المرور" required="" type="password" autocomplete="new-password" minlength="8">
                                                    <strong id="password_error" class="form-text text-danger"></strong>
                                                </div>
                                                <div class="col-12 col-lg-6 mg-t-20">
                                                    <label class="form-control-label">تأكيد كلمة المرور: <span class="tx-danger">*</span></label> <input class="form-control" id="confirm" data-parsley-iff="#password" name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required="" type="password" autocomplete="new-password" minlength="8">
                                                    <strong id="password_confirmation_error" class="form-text text-danger"></strong>
                                                </div>
                                            </div>
                                        </section>
                                        @can('تعيين دور')
                                            <h3>تعيين أدوار</h3>
                                            <section>
                                                <p>قم بتعيين أدوار هذا العضو</p>
                                                <div class="row row-sm">
                                                    <label class="form-label mb-2" >الأدوار: </label>
                                                    <strong id="roles_error" class="form-text text-danger"></strong>
                                                    @foreach ($roles as $role)
                                                        <div class="col-6 col-md-3">
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="roles[]" type="checkbox" value="{{ $role->id }}" id="flexCheckChecked{{ $role->id }}">
                                                                    <label class="form-check-label mg-r-25 w-100" for="flexCheckChecked{{ $role->id }}">{{ $role->name }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </section>
                                        @endcan
                                        @can('تعيين صلاحية')
                                            <h3>تعيين صلاحيات</h3>
                                            <section>
                                                <p>قم بتعيين صلاحيات لهذا العضو</p>
                                                <div class="alert alert-info rounded" role="alert">
                                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <strong><i class="fa-solid fa-circle-info ms-2"></i></strong> يفترض أن الأدوار تحتوى على مجموعة من الصلاحيات لذا فإن قمت بتحديد ادوار لهذا المستخدم فلا ضرورة من تحديد نفس صلاحيات الدور مرة أخرى إلا إذا كنت تريده الإحتفاظ بصلاحايت معينة فى حالة إزالة الدور عنه
                                                </div>
                                                <div class="row row-sm">
                                                    <label class="form-label mb-2" >الصلاحيات: </label>
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
                                            </section>
                                        @endcan
                                    </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.steps js -->
    <script src="{{URL::asset('assets/plugins/jquery-steps/jquery.steps.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/i18n/ar.js')}}"></script>
    <!--Internal  Form-wizard js -->
    <script src="{{URL::asset('admin_resources/js/form-wizard.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    {{-- AJAX --}}
    <script>
        function ajaxError(response) {
            var fisrtError = Object.keys(response.responseJSON.errors)[0];
            $("#error").hide().find("#message").html("<i class='fa-solid fa-circle-xmark ms-2'></i> " + response.responseJSON.errors[fisrtError][0]).parent().fadeIn(600);
        }

        function ajaxSuccess() {
            $("#error").fadeOut(600);
            $("#wizard").steps('reset');
        }
    </script>
    @include('ajax', [
        'url' => route('admin.store'),
        'method' => 'POST',
        'clear' => true
    ])
@endsection
