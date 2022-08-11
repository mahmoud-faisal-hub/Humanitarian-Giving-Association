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
        table.latest-galaries video + i {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 25px;
            transition: all 0.3s ease-in-out;
        }

        table.latest-galaries video:hover + i {
            color: #0162e8;
        }

        table.latest-galaries video:hover, table.latest-galaries video + i:hover {
            color: #0162e8;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بك!</h2>
                <p class="mg-b-0">الصفحة الرئيسية للوحة التحكم الخاصة بالموقع.</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        @can('عرض إحصائيات الأخبار')
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                @can('عرض الأخبار')
                    <a href="{{ route('news.index') }}" class="card overflow-hidden bg-primary-gradient">
                @else
                    <div class="card overflow-hidden bg-primary-gradient">
                @endcan
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon justify-content-center">
                                    <i class="fa-regular fa-newspaper"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13 tx-white-8 mb-3">الأخبار</h5>
                                    <h2 class="counter mb-0 text-white">{{ $newsCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline" class="pt-1">
                            {{-- 5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12,78 --}}
                            @foreach ($newsRecord as $date => $record)
                                @if ($date === array_key_last($newsRecord))
                                    {{ $record }}
                                @else
                                    {{ $record }},
                                @endif
                            @endforeach
                        </span>
                @can('عرض الأخبار')
                    </a>
                @else
                    </div>
                @endcan
            </div>
        @endcan
        @can('عرض إحصائيات الأقسام')
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                @can('عرض الأقسام')
                    <a href="{{ route('category.index') }}" class="card overflow-hidden bg-danger-gradient">
                @else
                    <div class="card overflow-hidden bg-danger-gradient">
                @endcan
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon text-warning justify-content-center">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13 tx-white-8 mb-3">الأقسام</h5>
                                    <h2 class="counter mb-0 text-white">{{ $categoriesCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline2" class="pt-1">
                            {{-- 5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12 --}}
                            @foreach ($categoriesRecord as $date => $record)
                                @if ($date === array_key_last($categoriesRecord))
                                    {{ $record }}
                                @else
                                    {{ $record }},
                                @endif
                            @endforeach
                        </span>
                @can('عرض الأقسام')
                    </a>
                @else
                    </div>
                @endcan
            </div>
        @endcan
        @can('عرض إحصائيات المعرض')
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                @can('عرض المعرض')
                    <a href="{{ route('galary.index') }}" class="card overflow-hidden bg-success-gradient">
                @else
                    <div class="card overflow-hidden bg-success-gradient">
                @endcan
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon text-primary justify-content-center">
                                    <i class="fa-solid fa-photo-film"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13 tx-white-8 mb-3">المعرض</h5>
                                    <h2 class="counter mb-0 text-white">{{ $galariesCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline3" class="pt-1">
                            @foreach ($galariesRecord as $date => $record)
                                @if ($date === array_key_last($galariesRecord))
                                    {{ $record }}
                                @else
                                    {{ $record }},
                                @endif
                            @endforeach
                        </span>
                @can('عرض المعرض')
                    </a>
                @else
                    </div>
                @endcan
            </div>
        @endcan
        @can('عرض إحصائيات الرسائل')
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                @can('عرض الرسائل')
                    <a href="{{ route('admin.message.index') }}" class="card overflow-hidden bg-warning-gradient">
                @else
                    <div class="card overflow-hidden bg-warning-gradient">
                @endcan
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon text-success justify-content-center">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13 tx-white-8 mb-3">الرسائل</h5>
                                    <h2 class="counter mb-0 text-white">{{ $messagesCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline4" class="pt-1">
                            @foreach ($messagesRecord as $date => $record)
                                @if ($date === array_key_last($messagesRecord))
                                    {{ $record }}
                                @else
                                    {{ $record }},
                                @endif
                            @endforeach
                        </span>
                @can('عرض الرسائل')
                    </a>
                @else
                    </div>
                @endcan
            </div>
        @endcan
    </div>
    <!-- row closed -->

    @canany(['عرض إحصائيات الأخبار', 'عرض إحصائيات الأقسام', 'عرض إحصائيات المعرض', 'عرض إحصائيات الرسائل', 'عرض إحصائيات الأعضاء'])
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">الإحصائيات</h4>
                        </div>
                        <p class="tx-12 text-muted mb-0">عرض مخطط الإحصائيات</p>
                    </div>
                    <div class="card-body">
                        <div class="total-revenue">
                            @can('عرض إحصائيات الأخبار')
                                <div>
                                    <label><span class="bg-primary"></span>الأخبار</label>
                                </div>
                            @endcan
                            @can('عرض إحصائيات الأقسام')
                                <div>
                                    <label><span class="bg-danger"></span>الأقسام</label>
                                </div>
                            @endcan
                            @can('عرض إحصائيات المعرض')
                                <div>
                                    <label><span class="bg-success"></span>المعرض</label>
                                </div>
                            @endcan
                            @can('عرض إحصائيات الرسائل')
                                <div>
                                    <label><span class="bg-orange"></span>الرسائل</label>
                                </div>
                            @endcan
                            @can('عرض إحصائيات الأعضاء')
                                <div>
                                    <label><span class="bg-secondary"></span>الأعضاء</label>
                                </div>
                            @endcan
                        </div>
                        <div class="mt-5" style="width:100%;">
                            {!! $chartjs->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    @endcanany

    <!-- row opened -->
    <div class="row row-sm row-deck">
        @can('عرض الأخبار')
            <div class="col-lg-12 col-xl-6">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4"><i class="fa-regular fa-newspaper fa-lg ps-2"></i> أخر الأخبار المضافة</h4>
                        @canany(['إضافة خبر', 'عرض الأخبار'])
                            <div class="dropdown">
                                <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                                <div class="dropdown-menu tx-13">
                                    @can('إضافة خبر')
                                        <a class="dropdown-item" href="{{ route('news.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة خبر</a>
                                    @endcan
                                    @can('عرض الأخبار')
                                        <a class="dropdown-item" href="{{ route('news.index') }}"><i class="fa-regular fa-newspaper ps-2"></i> جميع الأخبار</a>
                                    @endcan
                                </div>
                            </div>
                        @endcanany
                    </div>
                    <div class="table-responsive country-table">
                        @if ($latestNews->isNotEmpty())
                            <table class="latest-news table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
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
                                    @foreach ($latestNews as $news)
                                        <tr class="align-middle" data-id="{{ $news->id }}">
                                            {{-- <td class="align-middle">05 Dec 2019</td> --}}
                                            <td class="tx-medium tx-inverse align-middle">
                                                <ul class="lightgallery list-unstyled row row-sm p-0 m-0 justify-content-center">
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('storage/images/news') . '/' . $news->image " data-src="{{ asset('storage/images/news') . '/' . $news->image }}" data-sub-html="<h4>{{ $news->title }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded" src="{{ asset('storage/images/news') . '/' . $news->image }}">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="tx-medium tx-inverse align-middle">{{ getWord($news->title, 10)  }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ getWord($news->content, 10) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ $news->category->name }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ $news->user->name }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($news->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($news->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            @canany(['عرض الأخبار', 'تعديل خبر', 'حذف خبر'])
                                                <td class="align-middle">
                                                    @can('عرض الأخبار')
                                                        <a href="{{ route('web.news.show', $news->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="las la-search"></i>
                                                        </a>
                                                    @endcan
                                                    @can('تعديل خبر')
                                                        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-sm btn-info">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('حذف خبر')
                                                        <button type="button" class="btn btn-sm btn-danger" id="delete-news-confirm"
                                                            data-bs-toggle="modal" data-bs-target="#delete-news"
                                                            data-action="{{ route('news.destroy', $news->id) }}" data-id="{{ $news->id }}">
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
                </div>
            </div>
        @endcan

        @can('عرض المعرض')
            <div class="col-lg-12 col-xl-6">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4"><i class="fa-solid fa-photo-film fa-lg ps-2"></i> أخر الوسائط المضافة</h4>
                        @canany(['إضافة وسائط', 'عرض المعرض'])
                            <div class="dropdown">
                                <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                                <div class="dropdown-menu tx-13">
                                    @can('إضافة وسائط')
                                        <a class="dropdown-item" href="{{ route('galary.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة وسائط</a>
                                    @endcan
                                    @can('عرض المعرض')
                                        <a class="dropdown-item" href="{{ route('galary.index') }}"><i class="fa-solid fa-photo-film ps-2"></i> جميع الوسائط</a>
                                    @endcan
                                </div>
                            </div>
                        @endcanany
                    </div>
                    <div class="table-responsive country-table">
                        @if ($latestGalaries->isNotEmpty())
                            <table class="latest-galaries table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
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
                                    @foreach ($latestGalaries as $galary)
                                        <tr class="align-middle" data-id="{{ $galary->id }}">
                                            {{-- <td class="align-middle">05 Dec 2019</td> --}}
                                            @php
                                                $type;
                                                if (in_array($galary->extension, $image)) {
                                                    $type = 'image';
                                                } elseif (in_array($galary->extension, $video)) {
                                                    $type = 'video';
                                                }
                                            @endphp
                                            <td class="tx-medium tx-inverse align-middle">
                                                @if ($type == 'image')
                                                    <ul class="lightgallery list-unstyled row row-sm p-0 m-0 justify-content-center">
                                                        <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('storage/images/galary') . '/' . $galary->file " data-src="{{ asset('storage/images/galary') . '/' . $galary->file }}" data-sub-html="<h4>{{ $galary->description }}</h4>" >
                                                            <a href="">
                                                                <img alt="avatar" style="max-width: 100px" class="img-responsive rounded" src="{{ asset('storage/images/galary') . '/' . $galary->file }}">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @elseif ($type == 'video')
                                                    <div class="btn show-file-modal position-relative p-0 lh-0" id="show-file" data-bs-toggle="modal"
                                                        data-bs-target="#show-file-modal"
                                                        data-src="{{ asset('storage/images/galary') . '/' . $galary->file }}"
                                                        data-type="{{ $type }}" data-description="{{ $galary->description }}">
                                                        <video class="img-responsive rounded" title="{{ $galary->description }}">
                                                            <source src="{{ asset('storage/images/galary') . '/' . $galary->file }}">
                                                            المتصفح الخاص بك لا يدعم تشغيل الفيديو
                                                        </video>
                                                        <i class="fa-solid fa-circle-play"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="tx-medium tx-inverse align-middle">{{ getWord($galary->description, 10)  }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($galary->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($galary->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            @canany(['تعديل وسائط', 'حذف وسائط'])
                                                <td class="align-middle">
                                                    @can('تعديل وسائط')
                                                        <a href="{{ route('galary.edit', $galary->id) }}" class="btn btn-sm btn-info">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('حذف وسائط')
                                                        <button type="button" class="btn btn-sm btn-danger" id="delete-galary-confirm"
                                                            data-bs-toggle="modal" data-bs-target="#delete-galary"
                                                            data-action="{{ route('galary.destroy', $galary->id) }}" data-id="{{ $galary->id }}">
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
                                    <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد وسائط بعد</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan

        @can('عرض الأقسام')
            <div class="col-lg-12 col-xl-6">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4"><i class="fa-solid fa-layer-group fa-lg ps-2"></i> أخر الأقسام المضافة</h4>
                        @canany(['إضافة قسم', 'عرض الأقسام'])
                            <div class="dropdown">
                                <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                                <div class="dropdown-menu tx-13">
                                    @can('إضافة قسم')
                                        <a class="dropdown-item" href="{{ route('category.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة قسم</a>
                                    @endcan
                                    @can('عرض الأقسام')
                                        <a class="dropdown-item" href="{{ route('category.index') }}"><i class="fa-solid fa-layer-group ps-2"></i> جميع الأقسام</a>
                                    @endcan
                                </div>
                            </div>
                        @endcanany
                    </div>
                    <div class="table-responsive country-table">
                        @if ($latestCategories->isNotEmpty())
                            <table class="latest-categories table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="wd-lg-25p align-middle">إسم القسم</th>
                                        <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                        <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                        @canany(['عرض الأقسام', 'تعديل قسم', 'حذف قسم'])
                                            <th class="wd-lg-25p align-middle">العمليات</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestCategories as $category)
                                        <tr class="align-middle" data-id="{{ $category->id }}">
                                            {{-- <td class="align-middle">05 Dec 2019</td> --}}
                                            <td class="tx-medium tx-inverse align-middle">{{ $category->name }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($category->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($category->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            @canany(['عرض الأقسام', 'تعديل قسم', 'حذف قسم'])
                                                <td class="align-middle">
                                                    @can('عرض الأقسام')
                                                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="las la-search"></i>
                                                        </a>
                                                    @endcan
                                                    @can('تعديل قسم')
                                                        <a href="{{  route('category.edit', $category->id) }}" class="btn btn-sm btn-info">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('حذف قسم')
                                                        <button type="button" class="btn btn-sm btn-danger" id="delete-category-confirm"
                                                            data-bs-toggle="modal" data-bs-target="#delete-category"
                                                            data-action="{{ route('category.destroy', $category->id) }}" data-id="{{ $category->id }}">
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
                                    <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد أقسام بعد</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan

        @can('عرض الرسائل')
            <div class="col-lg-12 col-xl-6">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4"><i class="fa-solid fa-envelope fa-lg ps-2"></i> أخر الرسائل المضافة</h4>
                        @canany(['عرض الرسائل'])
                            <div class="dropdown">
                                <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                                <div class="dropdown-menu tx-13">
                                    @can('عرض الرسائل')
                                        <a class="dropdown-item" href="{{ route('admin.message.index') }}"><i class="fa-solid fa-envelope ps-2"></i> جميع الرسائل</a>
                                    @endcan
                                </div>
                            </div>
                        @endcanany
                    </div>
                    <div class="table-responsive country-table">
                        @if ($latestMessages->isNotEmpty())
                            <table class="latest-messages table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="wd-lg-25p align-middle">الحالة</th>
                                        <th class="wd-lg-25p align-middle">إسم الراسل</th>
                                        <th class="wd-lg-25p align-middle">الإيميل</th>
                                        <th class="wd-lg-25p align-middle">رقم الهاتف</th>
                                        <th class="wd-lg-25p align-middle">الرسالة</th>
                                        <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                        <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                        @canany(['عرض الرسائل', 'حذف رسالة'])
                                            <th class="wd-lg-25p align-middle">العمليات</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestMessages as $message)
                                        <tr class="align-middle" data-id="{{ $message->id }}">
                                            {{-- <td class="align-middle">05 Dec 2019</td> --}}
                                            <td class="tx-medium tx-inverse align-middle">
                                                @if ($message->readers_count)
                                                    <span class="badge badge-secondary">مقروء</span>
                                                @else
                                                    <span class="badge badge-danger">جديد</span>
                                                @endif
                                            </td>
                                            <td class="tx-medium tx-inverse align-middle">{{ $message->name }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ $message->email }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ $message->phone }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ getWord($message->message, 10) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($message->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($message->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                            @canany(['عرض الرسائل', 'حذف رسالة'])
                                                <td class="align-middle">
                                                    @can('عرض الرسائل')
                                                        <a href="{{ route('admin.message.show', $message->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="las la-search"></i>
                                                        </a>
                                                    @endcan
                                                    @can('حذف رسالة')
                                                        <button type="button" class="btn btn-sm btn-danger" id="delete-message-confirm"
                                                            data-bs-toggle="modal" data-bs-target="#delete-message"
                                                            data-action="{{ route('admin.message.destroy', $message->id) }}" data-id="{{ $message->id }}">
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
                                    <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد رسائل بعد</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <!-- /row -->
    </div>
    </div>
    <!-- Container closed -->

    @can('عرض المعرض')
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
    @endcan

    @can('حذف خبر')
        <!-- Start News Delete Modal -->
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
        <!-- End News Delete Model -->
    @endcan

    @can('حذف وسائط')
        <!-- Start Galary Delete Modal -->
        <div class="modal fade" id="delete-galary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا الملف
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="galary-destroy" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Galary Delete Model -->
    @endcan

    @can('حذف قسم')
        <!-- Start Category Delete Modal -->
        <div class="modal fade" id="delete-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا القسم
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="category-destroy" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Category Delete Model -->
    @endcan

    @can('حذف رسالة')
        <!-- Start Message Delete Modal -->
        <div class="modal fade" id="delete-message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذه الرسالة
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="message-destroy" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Message Delete Model -->
    @endcan
@endsection
@section('js')
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Counters -->
    <script src="{{URL::asset('assets/plugins/counters/waypoints.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/counters/counterup.min.js')}}"></script>
    <!--Internal Time Counter -->
    <script src="{{URL::asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/counters/counter.js')}}"></script>
    <!-- Internal Gallery js -->
    <script src="{{URL::asset('assets/plugins/gallery/lightgallery-all.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/gallery/jquery.mousewheel.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/gallery.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


    {{-- Show File Modal Config --}}
    <script>
        var fileSrc, fileType, fileDescription;

        $("body").on("click", '#show-file', function() {
            fileSrc = $(this).data("src");
            fileType = $(this).data("type");
            fileDescription = $(this).data("description");

            if (fileType == "image") {
                $("#show-file-modal img").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").addClass("d-none");
            } else if (fileType == "video") {
                $("#show-file-modal img").addClass("d-none");
                $("#show-file-modal video").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").get(0).play();
            }

            $("#show-file-modal p").text(fileDescription);
        });

        $("#show-file-modal").on('hide.bs.modal', function() {
            $(this).find("video").get(0).pause();
        });
    </script>

    {{-- News Delete Modal --}}
    <script>
        var action, newsId;

        $("body").on("click", '#delete-news-confirm', function() {

            action = $(this).data("action");
            newsId = $(this).data("id");

            $("#delete-news form").attr("action", action);

        });
    </script>

    {{-- Galary Delete Modal --}}
    <script>
        var action, galaryId;

        $("body").on("click", '#delete-galary-confirm', function() {

            action = $(this).data("action");
            galaryId = $(this).data("id");

            $("#delete-galary form").attr("action", action);

        });
    </script>

    {{-- Category Delete Modal --}}
    <script>
        var action, categoryId;

        $("body").on("click", '#delete-category-confirm', function() {

            action = $(this).data("action");
            categoryId = $(this).data("id");

            $("#delete-category form").attr("action", action);

        });
    </script>

    {{-- Message Delete Modal --}}
    <script>
        var action, messageId;

        $("body").on("click", '#delete-message-confirm', function() {

            action = $(this).data("action");
            messageId = $(this).data("id");

            $("#delete-message form").attr("action", action);

        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            console.log(submittedForm);
            switch (submittedForm) {
                case 'news-destroy':
                    $("#delete-news button[data-bs-dismiss='modal']").click();
                    $("table.latest-news tr[data-id=" + newsId + "]").fadeOut(600, function() {
                        $(this).remove();
                    });
                    break;

                case 'galary-destroy':
                    $("#delete-galary button[data-bs-dismiss='modal']").click();
                    $("table.latest-galaries tr[data-id=" + galaryId + "]").fadeOut(600, function() {
                        $(this).remove();
                    });
                    break;

                case 'category-destroy':
                    $("#delete-category button[data-bs-dismiss='modal']").click();
                    $("table.latest-categories tr[data-id=" + categoryId + "]").fadeOut(600, function() {
                        $(this).remove();
                    });
                    break;

                case 'message-destroy':
                    $("#delete-message button[data-bs-dismiss='modal']").click();
                    $("table.latest-messages tr[data-id=" + messageId + "]").fadeOut(600, function() {
                        $(this).remove();
                    });
                    break;
            }
        }
    </script>

    @include('ajax', ['form' => '#news-destroy', 'method' => 'POST'])
    @include('ajax', ['form' => '#galary-destroy', 'method' => 'POST'])
    @include('ajax', ['form' => '#category-destroy', 'method' => 'POST'])
    @include('ajax', ['form' => '#message-destroy', 'method' => 'POST'])
@endsection
