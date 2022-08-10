@extends('admin.layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex"><h4 class="content-title mb-0 my-auto"><a href="{{ route("admin.message.index") }}">الرسائل</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قراءة رسالة</span></div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				<div class="row row-sm">
					<!-- /Col -->
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">الرسالة <span class="badge badge-primary">وارد</span></h4>
							</div>
							<div class="card-body">
								<div class="email-media">
									<div class="mt-0 d-sm-flex">
										<div class="media-body">
											<div class="float-left d-none d-md-flex fs-15">
												<span class="mr-3">{{ arabicDate(arabicNumbers($message->created_at->format('j / m / Y ~ g:i a'))) }}</span>
												@canany(['حذف رسالة'])
                                                    <div class="mr-3">
                                                        <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal  tx-18" data-toggle="tooltip" title="" data-original-title="إظهار المزيد"></i></a>
                                                        <div class="dropdown-menu">
                                                            @can('حذف رسالة')
                                                                <button type="button" class="dropdown-item" id="delete-message-confirm"
                                                                    data-bs-toggle="modal" data-bs-target="#delete-message"
                                                                    data-action="{{ route('galary.destroy', $message->id) }}" data-id="{{ $message->id }}">
                                                                    <i class="las la-trash ms-2"></i> حذف
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @endcanany
											</div>
											<div class="media-title  font-weight-bold mt-3" dir="ltr"><span class="text-muted">( {{ $message->email }} )</span> {{ $message->name }}</div>
											<p class="mb-0">{{ $message->phone }}</p>
											<small class="mr-2 d-md-none">{{ arabicDate(arabicNumbers($message->created_at->format('j / m / Y ~ g:i a'))) }}</small>
										</div>
									</div>
								</div>
								<div class="eamil-body mt-5">
									<p>{{ $message->message }}</p>
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

        @can('حذف رسالة')
            <!-- Start Delete Modal -->
            <div class="modal fade" id="delete-message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                            <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                            </button>
                        </div>
                        <div class="modal-body">
                            هل أنت متأكد من أنك تريد حذف هذه الرسالة
                        </div>
                        <div class="modal-footer" dir="ltr">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <form class="d-inline" id="message-destroy" method="POST" action="">
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
@endsection
@section('js')
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>

    {{-- Delete Modal Config --}}
    <script>
        var action, messageId;

        $("main").on("click", '#delete-message-confirm', function() {

            action = $(this).data("action");
            messageId = $(this).data("id");

            $("#delete-message form").attr("action", action);

        });
    </script>

    {{-- AJAX --}}
    <script>
        function ajaxSuccess() {
            $("#delete-message button[data-bs-dismiss='modal']").click();
        }
    </script>
    @include('ajax', ['form' => '#message-destroy', 'method' => 'POST'])
@endsection
