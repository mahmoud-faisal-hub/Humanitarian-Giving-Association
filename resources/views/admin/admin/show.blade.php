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
        .filepond--root {
            margin-bottom: 0 !important;
        }
    </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
                            @if ($admin->id == Auth::id())
                                <h4 class="content-title mb-0 my-auto">الصفحة الشخصية</h4>
                            @else
                            <h4 class="content-title mb-0 my-auto"><a href="{{ route("admin.index") }}">الأعضاء</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الصفحة الشخصية</span>
                            @endif
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-4">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="pl-0">
									<div class="main-profile-overview">
										<div class="main-img-user profile-user">
                                            @if ($admin->info && $admin->info->image)
                                                <img alt="" src="{{URL::asset('storage/images/admins') . '/' . $admin->info->image}}">
                                            @else
                                                <img alt="" src="{{URL::asset('images/user.png')}}">
                                            @endif
                                            @if (Auth::user()->can('تعديل عضو') || Auth::id() == $admin->id)
                                                {{-- <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a> --}}
                                                <button type="button" class="profile-edit border-0" id="edit-image"
                                                    data-bs-toggle="modal" data-bs-target="#edit-image-modal"
                                                    data-action="{{ route('admin.destroy', $admin->id) }}" data-id="{{ $admin->id }}">
                                                    <i class="fas fa-camera text-primary"></i>
                                                </button>
                                            @endif
										</div>
										<div class="d-flex justify-content-between mg-b-20">
											<div>
												<h5 class="main-profile-name">{{ $admin->name }}</h5>
												<p class="main-profile-name-text">{{ $admin->email }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 col mb20">
												<h5>{{ $admin->news_count }}</h5>
												<h6 class="text-small text-muted mb-0">خبر</h6>
											</div>
										</div>
									</div><!-- main-profile-overview -->
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="row row-sm">
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
                                            <div class="counter-icon justify-content-center bg-primary-transparent">
                                                <i class="fa-regular fa-newspaper text-primary"></i>
                                            </div>
											<div class="mr-auto">
												<h5 class="tx-13">الأخبار</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">{{ $admin->news_count }}</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li class="">
											<a href="#settings" class="active" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">الإعدادات</span> </a>
										</li>
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="settings">
										<form role="form" id="settings" method="POST" action="{{ route('admin.update', $admin->id) }}">
                                            @csrf
                                            @method('PUT')
                                            @if (Auth::user()->can('تعديل عضو') && Auth::id() != $admin->id)
                                                <div class="form-group">
                                                    <div class="form-check form-switch">
                                                        <label for="Status">الحالة</label>
                                                        <input class="form-check-input me-2" name="status" type="checkbox" role="switch" id="status" value="1" @checked($admin->status)>
                                                        <strong id="status_error" class="form-text text-danger"></strong>
                                                    </div>
                                                </div>
                                            @endif
											<div class="form-group">
												<label for="FullName">الإسم</label>
												<input class="form-control" id="name" name="name" placeholder="أدخل الإسم بالكامل" required="" type="text" autocomplete="name" maxlength="255" value="{{ $admin->name }}" @disabled(Auth::user()->cannot('تعديل عضو') && Auth::id() != $admin->id)>
                                                <strong id="name_error" class="form-text text-danger"></strong>
                                            </div>
											<div class="form-group">
												<label for="Email">الإيميل</label>
												<input class="form-control" id="email" name="email" placeholder="أدخل الإيميل" required="" type="email" autocomplete="email" maxlength="255" value="{{ $admin->email }}" @disabled(Auth::user()->cannot('تعديل عضو') && Auth::id() != $admin->id)>
                                                <strong id="email_error" class="form-text text-danger"></strong>
                                            </div>
                                            @if (Auth::user()->can('تعديل عضو') || Auth::id() == $admin->id)
                                                <div class="form-group">
                                                    <label for="Password">كلمة المرور</label>
                                                    <input class="form-control" id="password" data-parsley-iff="#confirm" name="password" placeholder="أدخل كلمة المرور" type="password" autocomplete="new-password" minlength="8">
                                                    <strong id="password_error" class="form-text text-danger"></strong>
                                                </div>
                                                <div class="form-group">
                                                    <label for="RePassword">تأكيد كلمة المرور</label>
                                                    <input class="form-control" id="confirm" data-parsley-iff="#password" name="password_confirmation" placeholder="أعد إدخال كلمة المرور" type="password" autocomplete="new-password" minlength="8">
                                                    <strong id="password_confirmation_error" class="form-text text-danger"></strong>
                                                </div>
                                            @endif
											<div class="form-group">
												<label for="AboutMe">
                                                    @if ($admin->id == Auth::id())
                                                        عنى
                                                    @else
                                                        عن العضو
                                                    @endif
                                                </label>
												<textarea id="AboutMe" class="form-control" name="about" placeholder="أدخل بعض المعلومات@if ($admin->id == Auth::id()) عنك @else عن العضو @endif" maxlength="255" @disabled(Auth::user()->cannot('تعديل عضو') && Auth::id() != $admin->id)>{{ $admin->info? $admin->info->about : '' }}</textarea>
                                                <strong id="about_error" class="form-text text-danger"></strong>
                                            </div>
                                            @if (Auth::user()->can('تعديل عضو') || Auth::id() == $admin->id)
                                                <button  utton class="btn btn-primary waves-effect waves-light w-md" type="submit">حفظ</button>
                                            @endif
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

        @if (Auth::user()->can('تعديل عضو') || Auth::id() == $admin->id)
            <!-- Start Edit Image Modal -->
            <div class="modal fade" id="edit-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="d-inline" id="admin-destroy" method="POST" action="{{ route('admin.update.image', $admin->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header align-items-center">
                                <h5 class="modal-title" id="exampleModalLabel">تعديل الصورة</h5>
                                <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-0">
                                    <input name="image" type="file" id="formFile"
                                        accept="image/png, image/jpeg, image/jpg, image/gif" data-max-file-size="5MB" />
                                    <strong id="image_error" class="form-text text-danger"></strong>
                                </div>
                            </div>
                            <div class="modal-footer" dir="ltr">
                                <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn btn-primary">تعديل</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Edit Image Model -->
        @endif
@endsection
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/i18n/ar.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    {{-- Filepond Configration --}}
    <script>
        $.fn.filepond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform
        );

        $('input[type="file"]').filepond({
            server: {
                url: "{{ config('filepond.server.url') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',

                    @if ($admin->info && $admin->info->image)
                        'file-path': 'images/admins/',
                    @endif
                },
                load: '/load/',
            },
            // chunkUploads: "true",
            // chunkForce: "true",

            @if ($admin->info && $admin->info->image)
                files: [{
                    source: '{{ $admin->info->image }}',
                    options: {
                        type: 'local',
                    }
                }],
            @endif
            /* chunkUploads: "true",
            chunkForce: "true" */
            labelIdle: `اسحب وأفلت الصورة او <span class="filepond--label-action">تصفح</span>`,
            labelInvalidField: 'يحتوي الحقل على ملف غير صالح',
            labelFileWaitingForSize: 'في انتظار معلومات حجم الملف',
            labelFileSizeNotAvailable: 'حمجم الملف غير متوفر',
            labelFileLoading: 'جار التحميل',
            labelFileLoadError: 'خطأ أثناء التحميل',
            labelFileProcessing: 'جار التحميل',
            labelFileProcessingComplete: 'اكتمل التحميل',
            labelFileProcessingAborted: 'تم إلغاء التحميل',
            labelFileProcessingError: 'خطأ أثناء التحميل',
            labelFileProcessingRevertError: 'خطأ أثناء التراجع',
            labelFileRemoveError: 'خطأ أثناء الإزالة',
            labelTapToCancel: 'اضغط للإلغاء',
            labelTapToRetry: 'إضغط لإعادة المحاولة',
            labelTapToUndo: 'اضغط للتراجع',
            labelButtonRemoveItem: 'إزالة',
            labelButtonAbortItemLoad: 'إيقاف',
            labelButtonRetryItemLoad: 'أعد المحاولة',
            labelButtonAbortItemProcessing: 'إلغاء',
            labelButtonUndoItemProcessing: 'الغاء التحميل',
            labelButtonRetryItemProcessing: 'أعد المحاولة',
            labelButtonProcessItem: 'رفع',
        });
    </script>

    <script>
        $("form").parsley({
            excluded: ":disabled,:hidden",
            iffMessage: "كلمتا المرور غير متطابقتين",
        }).validate();
    </script>

    {{-- AJAX --}}
    @include('ajax', [
        'method' => 'POST',
    ])
@endsection
