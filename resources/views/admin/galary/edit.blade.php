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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route("galary.index") }}">الوسائط</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل ملف</span>
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
                    <h4 class="card-title mb-1">تعديل ملف</h4>
                    <p class="mb-2">تعديل ملف معين من الوسائط</p>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="POST" action="{{ route('galary.update', $galary->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="formFile" class="form-label">الوسائط <span class="tx-danger">*</span></label>
                            <input name="galary" class="" type="file" id="formFile"
                                accept="image/png, image/jpeg, image/jpg, image/gif, video/mp4, video/ogg, video/webm, video/x-msvideo"
                                data-max-file-size="1024MB" />
                            <strong id="galary_error" class="form-text text-danger"></strong>
                        </div>
                        <div class="form-group">
                            <label for="content" class="form-label">الوصف</label>
                            <textarea name="description" class="form-control" id="content" rows="2">{{ $galary->description }}</textarea>
                            <strong id="description_error" class="form-text text-danger"></strong>
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
            FilePondPluginMediaPreview,
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

                    @if ($galary->file)
                        'file-path': 'images/galary/',
                    @endif
                },
                load: '/load/',
            },

            @if ($galary->file)
                files: [{
                    source: '{{ $galary->file }}',
                    options: {
                        type: 'local',
                    }
                }],
            @endif

            chunkUploads: "true",
            chunkForce: "true",
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

    {{-- AJAX --}}
    @include('ajax', ['url' => route('galary.update', $galary->id), 'method' => 'POST'])
@endsection


