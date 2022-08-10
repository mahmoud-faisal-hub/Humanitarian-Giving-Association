@extends('admin.layouts.master')

@section('css')
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
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">قائمة الأقسام</h2>
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
                    <h4 class="card-title mb-0"><i class="fa-solid fa-layer-group ps-2"></i>  الأقسام</h4>
                    <form role="search" action="{{ route('admin.category.search') }}" method="GET"
                        class="col-9 col-lg-7 d-flex">
                        <input class="form-control form-control" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @canany(['إضافة قسم'])
                        <div class="dropdown">
                            <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                            <div class="dropdown-menu tx-13">
                                @can('إضافة قسم')
                                    <a class="dropdown-item" href="{{ route('category.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة قسم</a>
                                @endcan
                            </div>
                        </div>
                    @endcanany
                </div>
                <div class="table-responsive country-table mb-2 mt-3">
                    @if ($categories->isNotEmpty())
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                            <thead>
                                <tr class="align-middle">
                                    <th class="wd-lg-25p align-middle">الإسم</th>
                                    <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                    @canany(['عرض الأخبار', 'تعديل قسم', 'حذف قسم'])
                                        <th class="wd-lg-25p align-middle">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="align-middle" data-id="{{ $category->id }}">
                                        <td class="tx-medium tx-inverse align-middle">{{ $category->name  }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($category->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($category->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        @canany(['عرض الأخبار', 'تعديل قسم', 'حذف قسم'])
                                            <td class="align-middle text-center">
                                                @can('عرض الأخبار')
                                                    <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="las la-search"></i>
                                                    </a>
                                                @endcan
                                                @can('تعديل قسم')
                                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-info">
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

                @if ($categories->hasPages())
                    {{ $categories->links() }}
                @endif
            </div>
        </div>
    </div>

    @can('إضافة قسم')
        {{-- Fixed Add Button --}}
        <a class="btn btn-success fixed-add" href="{{ route('category.create') }}"><i class="fa-solid fa-plus"></i></a>
    @endcan

    @can('حذف قسم')
        <!-- Start Delete Modal -->
        <div class="modal fade" id="delete-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا القسم
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="category-destroy" method="POST" action="">
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
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    {{-- Delete Modal Config --}}
    <script>
        var action, categoryId, categoryName;

        $("body").on("click", '#delete-category-confirm', function() {

            action = $(this).data("action");
            categoryId = $(this).data("id");

            $("#delete-category form").attr("action", action);

        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-category button[data-bs-dismiss='modal']").click();
            $("tr[data-id=" + categoryId + "]").fadeOut(600, function() {
                $(this).remove();
            });
        }
    </script>
    @include('ajax', ['form' => '#category-destroy', 'method' => 'POST'])
@endsection
