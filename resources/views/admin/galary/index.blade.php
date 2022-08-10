@extends('admin.layouts.master')

@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Internal Gallery css -->
    <link href="{{URL::asset('assets/plugins/gallery/gallery.css')}}" rel="stylesheet">
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />

    <style>
        form[role="search"] input, form[role="search"] button {
            border-radius: 0 !important;
        }

        form[role="search"] input {
            border-top-right-radius: 0.25rem !important;
            border-bottom-right-radius: 0.25rem !important;
        }

        form[role="search"] button {
            border-top-left-radius: 0.25rem !important;
            border-bottom-left-radius: 0.25rem !important;
        }

        table video + i {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 25px;
            transition: all 0.3s ease-in-out;
        }

        table video:hover + i {
            color: #0162e8;
        }

        table video:hover, table video + i:hover {
            color: #0162e8;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">قائمة الوسائط</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-12">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa-solid fa-photo-film fa-lg ps-2"></i>  الوسائط</h4>
                    <form role="search" action="{{ route('admin.galary.search') }}" method="GET"
                        class="col-9 col-lg-7 d-flex">
                        <input class="form-control form-control" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @canany(['إضافة وسائط'])
                        <div class="dropdown">
                            <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                            <div class="dropdown-menu tx-13">
                                @can('إضافة وسائط')
                                    <a class="dropdown-item" href="{{ route('galary.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة وسائط</a>
                                @endcan
                            </div>
                        </div>
                    @endcanany
                </div>
                <div class="table-responsive country-table mb-2 mt-3">
                    @if ($galary->isNotEmpty())
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                            <thead>
                                <tr class="align-middle">
                                    <th class="wd-lg-25p align-middle">الملف</th>
                                    <th class="wd-lg-25p align-middle">الوصف</th>
                                    <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                    @canany(['تعديل وسائط', 'حذف وسائط'])
                                        <th class="wd-lg-25p align-middle">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $image = ['png', 'jpeg', 'jpg', 'gif'];
                                    $video = ['mp4', 'ogv', 'webm', 'avi'];
                                @endphp
                                @foreach ($galary as $file)
                                    <tr class="align-middle" data-id="{{ $file->id }}">
                                        @php
                                            $type;
                                            if (in_array($file->extension, $image)) {
                                                $type = 'image';
                                            } elseif (in_array($file->extension, $video)) {
                                                $type = 'video';
                                            }
                                        @endphp
                                        <td class="tx-medium tx-inverse align-middle">
                                            @if ($type == 'image')
                                                <ul class="lightgallery list-unstyled row row-sm p-0 m-0 justify-content-center">
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('storage/images/galary') . '/' . $file->file " data-src="{{ asset('storage/images/galary') . '/' . $file->file }}" data-sub-html="<h4>{{ $file->description }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded" src="{{ asset('storage/images/galary') . '/' . $file->file }}">
                                                        </a>
                                                    </li>
                                                </ul>
                                            @elseif ($type == 'video')
                                                <div class="btn show-file-modal position-relative p-0 lh-0" id="show-file" data-bs-toggle="modal"
                                                    data-bs-target="#show-file-modal"
                                                    data-src="{{ asset('storage/images/galary') . '/' . $file->file }}"
                                                    data-type="{{ $type }}" data-description="{{ $file->description }}">
                                                    <video class="img-responsive rounded" title="{{ $file->description }}" style="max-width: 100px">
                                                        <source src="{{ asset('storage/images/galary') . '/' . $file->file }}">
                                                        المتصفح الخاص بك لا يدعم تشغيل الفيديو
                                                    </video>
                                                    <i class="fa-solid fa-circle-play"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="tx-medium tx-inverse align-middle">{{ getWord($file->description, 10)  }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($file->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($file->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        @canany(['تعديل وسائط', 'حذف وسائط'])
                                            <td class="align-middle text-center">
                                                @can('تعديل وسائط')
                                                    <a href="{{ route('galary.edit', $file->id) }}" class="btn btn-sm btn-info">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('حذف وسائط')
                                                    <button type="button" class="btn btn-sm btn-danger" id="delete-file-confirm"
                                                        data-bs-toggle="modal" data-bs-target="#delete-file"
                                                        data-action="{{ route('galary.destroy', $file->id) }}" data-id="{{ $file->id }}">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="card text-center">
                            <div class="card-body">
                                <img src="{{ asset('assets/img/svgicons/note_taking.svg') }}" alt="" class="wd-35p">
                                <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد أخبار بعد</h5>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($galary->hasPages())
                    {{ $galary->links() }}
                @endif
            </div>
        </div>
    </div>

    @can('إضافة وسائط')
        {{-- Fixed Add Button --}}
        <a class="btn btn-success fixed-add" href="{{ route('galary.create') }}"><i class="fa-solid fa-plus"></i></a>
    @endcan

    <!-- Start Show File Modal -->
    <div class="modal fade" id="show-file-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">عرض الوسائط</h5>
                    <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-thumbnail img-fluid d-none w-100" alt="...">
                    <video class="d-none w-100" controls>
                        <source src="">
                            المتصفح الخاص بك لا يدعم تشغيل الفيديو
                    </video>
                    <p class="lead mb-0"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Show File Model -->

    @can('حذف وسائط')
        <!-- Start Delete Modal -->
        <div class="modal fade" id="delete-file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا الملف
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="file-destroy" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Model -->
    @endcan

    </div>
    </div>
@endsection

@section('js')
    <!-- Internal Gallery js -->
    <script src="{{URL::asset('assets/plugins/gallery/lightgallery-all.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/gallery/jquery.mousewheel.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/gallery.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    {{-- Delete Modal Config --}}
    <script>
        var action, fileId, fileName;

        $("body").on("click", '#delete-file-confirm', function() {
            action = $(this).data("action");
            fileId = $(this).data("id");

            $("#delete-file form").attr("action", action);
        });
    </script>

    {{-- Show File Modal Config --}}
    <script>
        var fileSrc, fileType;

        $("body").on("click", '#show-file', function() {
            fileSrc = $(this).data("src");
            fileType = $(this).data("type");

            if (fileType == "image") {
                $("#show-file-modal img").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").addClass("d-none");
            } else if (fileType == "video") {
                $("#show-file-modal img").addClass("d-none");
                $("#show-file-modal video").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").get(0).play();
            }
        });

        $("#show-file-modal").on('hide.bs.modal', function() {
            $(this).find("video").get(0).pause();
        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-file button[data-bs-dismiss='modal']").click();
            $("tr[data-id=" + fileId + "]").fadeOut(600, function() {
                $(this).remove();
            });
        }
    </script>
    @include('ajax', ['form' => '#file-destroy', 'method' => 'POST'])
@endsection

