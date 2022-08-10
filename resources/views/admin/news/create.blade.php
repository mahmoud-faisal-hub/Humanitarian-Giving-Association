@extends('admin.layouts.master')

@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("news.index") }}">الأخبار</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة خبر</span>
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
                    <h4 class="card-title mb-1">إضافة خبر</h4>
                    <p class="mb-2">إضافة المزيد من الأخبار</p>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="formFile" class="form-label">صورة مرفقة <span class="tx-danger">*</span></label>
                            <input name="image" type="file" id="formFile"
                                accept="image/png, image/jpeg, image/jpg, image/gif" data-max-file-size="5MB" />
                            <strong id="image_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-label">عنوان الخبر <span class="tx-danger">*</span></label>
                            <input name="title" type="text" class="form-control" id="title">
                            <strong id="title_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="form-group">
                            <label for="content" class="form-label">المحتوى <span class="tx-danger">*</span></label>
                            <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                            <strong id="content_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="form-label">إختر القسم <span class="tx-danger">*</span></label>
                            <select name="category_id" class="form-select" aria-label="الأقسام">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <strong id="category_id_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">الخبر <span class="tx-danger">*</span></label>
                            <textarea name="article" class="form-control" id="editor" rows="10"></textarea>
                            <strong id="article_error" class="form-text text-danger"></strong>
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
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
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

    {{-- CKeditor Configration --}}
    @include('ckeditor')

    <script>
        function ajaxSuccess() {
            $(".filepond--action-revert-item-processing").click();
        }
    </script>

    {{-- AJAX --}}
    @include('ajax', ['url' => route('news.store'), 'method' => 'POST', 'clear' => true])
@endsection
