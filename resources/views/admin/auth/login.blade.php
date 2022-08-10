@extends('admin.layouts.master2')

@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>مرحباً بك</h2>
                                            <h5 class="font-weight-semibold mb-4">تسجيل الدخول</h5>
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>البريد الإلكترونى</label> <input
                                                        class="form-control  @error('email') is-invalid @enderror"
                                                        placeholder="البريد الإلكترونى" type="email" name="email"
                                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>كلمة المرور</label> <input
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="كلمة المرور" type="password" name="password" required
                                                        autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label mr-4" for="remember">تذكرنى</label>
                                                </div><button class="btn btn-main-primary btn-block">تسجيل الدخول</button>
                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <p>
                                                    @if (Route::has('password.request'))
                                                        <a href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('images/login/1.png') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!--Internal  Parsley js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/i18n/ar.js')}}"></script>

    <script>
        $("form").parsley({
            excluded: ":disabled,:hidden",
            iffMessage: "كلمتا المرور غير متطابقتين",
        });
    </script>
@endsection
