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
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">قائمة الأدوار</h2>
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
                    <h4 class="card-title mb-0"><i class="fa-solid fa-user-lock ps-2"></i>  الأدوار</h4>
                    <form role="search" action="{{ route('role.search') }}" method="GET"
                        class="col-9 col-lg-7 d-flex">
                        <input class="form-control form-control" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @canany(['إضافة دور'])
                        <div class="dropdown">
                            <i class="mdi mdi-dots-horizontal text-gray" data-toggle="dropdown" type="button"></i>
                            <div class="dropdown-menu tx-13">
                                @can('إضافة دور')
                                    <a class="dropdown-item" href="{{ route('role.create') }}"><i class="fa-solid fa-circle-plus ps-2"></i> إضافة دور</a>
                                @endcan
                            </div>
                        </div>
                    @endcanany
                </div>
                <div class="table-responsive country-table mb-2 mt-3">
                    @if ($roles->isNotEmpty())
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center align-middle">
                            <thead>
                                <tr class="align-middle">
                                    <th class="wd-lg-25p align-middle">الإسم</th>
                                    <th class="wd-lg-25p align-middle">تاريخ الإضافة</th>
                                    <th class="wd-lg-25p align-middle">تاريخ التعديل</th>
                                    @canany(['تعديل دور', 'حذف دور'])
                                        <th class="wd-lg-25p align-middle">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr class="align-middle" data-id="{{ $role->id }}">
                                        <td class="tx-medium tx-inverse align-middle">{{ $role->name  }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($role->created_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        <td class="tx-medium tx-inverse align-middle">{{ arabicDate(arabicNumbers($role->updated_at->format('D، j M Y ~ g:i a'))) }}</td>
                                        @canany(['تعديل دور', 'حذف دور'])
                                            <td class="align-middle text-center">
                                                @can('تعديل دور')
                                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-info">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('حذف دور')
                                                    <button type="button" class="btn btn-sm btn-danger" id="delete-role-confirm"
                                                        data-bs-toggle="modal" data-bs-target="#delete-role"
                                                        data-action="{{ route('role.destroy', $role->id) }}" data-id="{{ $role->id }}">
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
                                <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد أدوار بعد</h5>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($roles->hasPages())
                    {{ $roles->links() }}
                @endif
            </div>
        </div>
    </div>

    @can('إضافة دور')
        {{-- Fixed Add Button --}}
        <a class="btn btn-success fixed-add" href="{{ route('role.create') }}"><i class="fa-solid fa-plus"></i></a>
    @endcan

    @can('حذف دور')
        <!-- Start Delete Modal -->
        <div class="modal fade" id="delete-role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                        </button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد من أنك تريد حذف هذا الدور
                    </div>
                    <div class="modal-footer" dir="ltr">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <form class="d-inline" id="role-destroy" method="POST" action="">
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
        var action, roleId, roleName;

        $("body").on("click", '#delete-role-confirm', function() {

            action = $(this).data("action");
            roleId = $(this).data("id");

            $("#delete-role form").attr("action", action);

        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-role button[data-bs-dismiss='modal']").click();
            $("tr[data-id=" + roleId + "]").fadeOut(600, function() {
                $(this).remove();
            });
        }
    </script>
    @include('ajax', ['form' => '#role-destroy', 'method' => 'POST'])
@endsection
