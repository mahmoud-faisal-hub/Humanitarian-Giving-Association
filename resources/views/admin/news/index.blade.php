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
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">قائمة الأخبار</h2>
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
                    <h4 class="card-title mb-0"><i class="fa-regular fa-newspaper fa-lg ps-2"></i>  الأخبار</h4>
                    <form role="search" action="{{ route('admin.news.search') }}" method="GET"
                        class="col-9 col-lg-7 d-flex">
                        <input class="form-control form-control" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @canany(['إضافة خبر'])
                        <div class="dropdown">
                            <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                            <div class="dropdown-menu tx-13">
                                @can('إضافة خبر')
                                    <a class="dropdown-item" href="{{ route('news.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة خبر</a>
                                @endcan
                            </div>
                        </div>
                    @endcanany
                </div>
                <div class="table-responsive country-table mb-2 mt-3">
                    @if ($news->isNotEmpty())
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                            <thead>
                                <tr class="align-middle">
                                    <th class="wd-lg-25p align-middle">الصورة</th>
                                    <th class="wd-lg-25p align-middle">العنوان</th>
                                    <th class="wd-lg-25p align-middle">المحتوى</th>
                                    <th class="wd-lg-25p align-middle">القسم</th>
                                    <th class="wd-lg-25p align-middle">أضيف بواسطة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                    @canany(['عرض الأخبار', 'تعديل خبر', 'حذف خبر'])
                                        <th class="wd-lg-25p align-middle">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $_news)
                                    <tr class="align-middle" data-id="{{ $_news->id }}">
                                        <td class="tx-medium tx-inverse align-middle">
                                            <ul class="lightgallery list-unstyled row row-sm p-0 m-0 justify-content-center">
                                                @if ($_news->image)
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('storage/images/news') . '/' . $_news->image " data-src="{{ asset('storage/images/news') . '/' . $_news->image }}" data-sub-html="<h4>{{ $_news->title }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded" src="{{ asset('storage/images/news') . '/' . $_news->image }}">
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('assets/img/20.jpg') " data-src="{{ asset('assets/img/20.jpg') }}" data-sub-html="<h4>{{ $_news->title }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded" src="{{ asset('assets/img/20.jpg') }}">
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td class="tx-medium tx-inverse align-middle">{{ getWord($_news->title, 10)  }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ getWord($_news->content, 10) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ $_news->category->name }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ $_news->user->name }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($_news->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($_news->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        @canany(['عرض الأخبار', 'تعديل خبر', 'حذف خبر'])
                                            <td class="align-middle text-center">
                                                @can('عرض الأخبار')
                                                    <a href="{{ route('web.news.show', $_news->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="las la-search"></i>
                                                    </a>
                                                @endcan
                                                @can('تعديل خبر')
                                                    <a href="{{ route('news.edit', $_news->id) }}" class="btn btn-sm btn-info">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('حذف خبر')
                                                    <button type="button" class="btn btn-sm btn-danger" id="delete-news-confirm"
                                                        data-bs-toggle="modal" data-bs-target="#delete-news"
                                                        data-action="{{ route('news.destroy', $_news->id) }}" data-id="{{ $_news->id }}">
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

                @if ($news->hasPages())
                    {{ $news->links() }}
                @endif
            </div>
        </div>
    </div>

    @can('إضافة خبر')
        {{-- Fixed Add Button --}}
        <a class="btn btn-success fixed-add" href="{{ route('news.create') }}"><i class="fa-solid fa-plus"></i></a>
    @endcan

    @can('حذف خبر')
        <!-- Start Delete Modal -->
        <div class="modal fade" id="delete-news" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا الخبر
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="news-destroy" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn btn-danger">حذف</button>
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

    {{-- Delete Modal --}}
    <script>
        var action, newsId;

        $("body").on("click", '#delete-news-confirm', function() {
            action = $(this).data("action");
            newsId = $(this).data("id");

            $("#delete-news form").attr("action", action);
        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-news button[data-bs-dismiss='modal']").click();
            $("tr[data-id=" + newsId + "]").fadeOut(600, function() {
                $(this).remove();
            });
        }
    </script>
    @include('ajax', ['form' => '#news-destroy', 'method' => 'POST'])
@endsection
