@extends('admin.layouts.master')

@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!---Internal  Multislider css-->
    <link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
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

        .dot-label {
            position: static !important;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">قائمة الأعضاء</h2>
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
                    <h4 class="card-title mb-0"><i class="fa-regular fa-newspaper fa-lg ps-2"></i>  الأعضاء</h4>
                    <form role="search" action="{{ route('admin.search') }}" method="GET"
                        class="col-9 col-lg-7 d-flex">
                        <input class="form-control form-control" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @canany(['إضافة عضو'])
                        <div class="dropdown">
                            <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                            <div class="dropdown-menu tx-13">
                                @can('إضافة عضو')
                                    <a class="dropdown-item" href="{{ route('admin.create') }}"><i class="fa-solid fa-users ps-2"></i> إضافة عضو</a>
                                @endcan
                            </div>
                        </div>
                    @endcanany
                </div>
                <div class="table-responsive country-table mb-2 mt-3">
                    @if ($admins->isNotEmpty())
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                            <thead>
                                <tr class="align-middle">
                                    <th class="wd-lg-25p align-middle">الصورة</th>
                                    <th class="wd-lg-25p align-middle">الإسم</th>
                                    <th class="wd-lg-25p align-middle">الإيميل</th>
                                    <th class="wd-lg-25p align-middle">الأدوار</th>
                                    <th class="wd-lg-25p align-middle">الحالة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                    @canany(['عرض الأعضاء', 'تعديل عضو', 'حذف عضو'])
                                        <th class="wd-lg-25p align-middle">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr class="align-middle" data-id="{{ $admin->id }}">
                                        <td class="tx-medium tx-inverse align-middle">
                                            <ul class="lightgallery list-unstyled row row-sm p-0 m-0 justify-content-center">
                                                @if ($admin->info && $admin->info->image)
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('storage/images/admins' . '/' . $admin->info->image) " data-src="{{ asset('storage/images/admins' . '/' . $admin->info->image) }}" data-sub-html="<h4>{{ $admin->name }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded-circle avatar-md" src="{{ asset('storage/images/admins' . '/' . $admin->info->image) }}">
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="col-sm-6 col-lg-4 p-0 m-0 justify-content-center" data-responsive=" asset('images/user.png') " data-src="{{ asset('images/user.png') }}" data-sub-html="<h4>{{ $admin->name }}</h4>" >
                                                        <a href="">
                                                            <img alt="avatar" style="max-width: 100px" class="img-responsive rounded-circle avatar-md" src="{{ asset('images/user.png') }}">
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td class="tx-medium tx-inverse align-middle">{{ $admin->name  }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ $admin->email }}</td>
                                        <td class="tx-medium tx-inverse align-middle">
                                            @if ($admin->roles->isNotEmpty())
                                                @if ($admin->roles->count() == 1)
                                                    {{ $admin->roles[0]->name }}
                                                @else
                                                    <a aria-controls="collapseExample{{ $admin->id }}" aria-expanded="false" class="btn btn-sm btn-indigo ripple mx-auto" data-toggle="collapse" href="#collapseExample{{ $admin->id }}" role="button">الأدوار <i class="fa-solid fa-caret-down pe-2"></i></a>
                                                    <div class="collapse" id="collapseExample{{ $admin->id }}">
                                                        <div class="mt-4">
                                                            <div class="listgroup-example2">
                                                                <ul class="list-group text-end">
                                                                        <ul class="list-style-disc">
                                                                            @foreach ($admin->roles as $role)
                                                                                <li>{{ $role->name }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="tx-medium tx-inverse align-middle">
                                            @if ($admin->status)
                                                <span class="label text-success d-flex align-items-center"><div class="dot-label bg-success ml-2"></div>مفعل</span>
                                            @else
                                                <span class="label text-danger d-flex align-items-center"><div class="dot-label bg-danger ml-2"></div> غير مفعل</span>
                                            @endif
                                        </td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($admin->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($admin->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        @canany(['عرض الأعضاء', 'تعديل عضو', 'حذف عضو'])
                                            <td class="align-middle text-center">
                                                @can('عرض الأعضاء')
                                                    <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="las la-search"></i>
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                @canany(['تعيين دور', 'تعيين صلاحية'])
                                                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-lock"></i>
                                                    </a>
                                                @endcanany
                                                @can('حذف عضو')
                                                    <button type="button" class="btn btn-sm btn-danger" id="delete-admin-confirm"
                                                        data-bs-toggle="modal" data-bs-target="#delete-admin"
                                                        data-action="{{ route('admin.destroy', $admin->id) }}" data-id="{{ $admin->id }}">
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
                                <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد أعضاء بعد</h5>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($admins->hasPages())
                    {{ $admins->links() }}
                @endif
            </div>
        </div>
    </div>

    @can('إضافة عضو')
        {{-- Fixed Add Button --}}
        <a class="btn btn-success fixed-add" href="{{ route('admin.create') }}"><i class="fa-solid fa-plus"></i></a>
    @endcan

    @can('حذف عضو')
        <!-- Start Delete Modal -->
        <div class="modal fade" id="delete-admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا العضو
                        <div class="alert alert-info rounded mt-3" role="alert">
                            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong><i class="fa-solid fa-circle-info ms-2"></i></strong> برجاء العلم عند حذف عضو تحذف معه الأخبار المتعلقة به إذا كنت لا تريد حذف الأخبار فقم بإلغاء تفعيل العضو بدلاً من حذفه
                        </div>
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="admin-destroy" method="POST" action="">
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
    <!-- Internal Owl Carousel js-->
    <script src="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.js')}}"></script>
    <!---Internal  Multislider js-->
    <script src="{{URL::asset('assets/plugins/multislider/multislider.js')}}"></script>
    <script src="{{URL::asset('assets/js/carousel.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    {{-- Delete Modal --}}
    <script>
        var action, adminId;

        $("body").on("click", '#delete-admin-confirm', function() {
            action = $(this).data("action");
            adminId = $(this).data("id");

            $("#delete-admin form").attr("action", action);
        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-admin button[data-bs-dismiss='modal']").click();
            $("tr[data-id=" + adminId + "]").fadeOut(600, function() {
                $(this).remove();
            });
        }
    </script>
    @include('ajax', ['form' => '#admin-destroy', 'method' => 'POST'])
@endsection
