@extends('admin.layouts.master')
@section('css')
    <style>
        .main-mail-list {
            border-top-width: 1px !important;
        }

        .main-mail-item:last-child {
            border-bottom: 0;
        }

        form[role="search"] input, form[role="search"] button {
            border-radius: 0 !important;
        }

        form[role="search"] select {
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
					<div class="my-auto">
						<div class="d-flex"><h4 class="content-title mb-0 my-auto">الرسائل</h4></div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm main-content-mail">
					<div class="col-12">
						<div class="card">
							<div class="main-content-body main-content-body-mail card-body">
								<div class="main-mail-header">
									<div>
										<h4 class="main-content-title mg-b-5">الوارد</h4>
                                        @if ($usereadCount)
										    <p>لديك {{ $usereadCount }} رسائل غير مقروءة</p>
                                        @endif
									</div>
                                    <form role="search" action="{{ route('admin.message.search') }}" method="GET"
                                        class="col-7 d-flex">
                                        <select class="form-select w-25 rounded-0 rounded-end border-start-0" name="selectBy"
                                            aria-label="Default select example" dir="ltr">
                                            <option value="1" selected dir="rtl">اسم الراسل</option>
                                            <option value="2" dir="rtl">الإيميل</option>
                                            <option value="3" dir="rtl">رقم الهاتف</option>
                                        </select>
                                        <input class="form-control form-control-lg rounded-0" name="search" type="search" placeholder="بحث"
                                            aria-label="بحث">
                                        <button class="btn btn-lg btn-primary rounded-0 rounded-start" type="submit"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </form>
								</div><!-- main-mail-list-header -->
								<div class="main-mail-list">
                                    @forelse ($messages as $message)
                                        <a href="{{ route('admin.message.show', $message->id) }}" class="main-mail-item @if(!$message->readers_count) unread @endif">
                                            <div class="main-mail-body m-0">
                                                <div class="main-mail-from text-dark">
                                                    {{ $message->name }}
                                                </div>
                                                <div class="main-mail-subject">
                                                    <strong>{{ $message->email }}</strong><br><span>{{ getWord($message->message, 20) }}</span>
                                                </div>
                                            </div>
                                            <div class="main-mail-date">
                                                {{ arabicDate(arabicNumbers($message->created_at->format('j / m / Y ~ g:i a'))) }}
                                            </div>
                                        </a>
                                    @empty
                                        <div class="text-center my-5">
                                            <img src="{{ asset('assets/img/svgicons/note_taking.svg') }}" alt="" class="wd-35p">
                                            <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد رسائل بعد</h5>
                                        </div>
                                    @endforelse
								</div>
								<div class="mg-lg-b-30"></div>
                                @if ($messages->hasPages())
                                    {{ $messages->links() }}
                                @endif
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div><!-- container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--- Internal Check-all-mail js -->
    <script src="{{URL::asset('assets/js/check-all-mail.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
@endsection
