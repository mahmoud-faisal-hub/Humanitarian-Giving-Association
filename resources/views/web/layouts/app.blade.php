<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('front_resources/images/logo.png') }}">

    <!-- Scripts -->
    {{-- <script src="{{ asset('front_resources/js/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin_resources/js/filepond.jquery.js') }}"></script> --}}
    <script src="{{ asset('admin_resources/js/ckeditor.js') }}"></script>
    <script src="{{ mix('front_resources/js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('front_resources/css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!--Start Loading-->

    <section class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </section>

    <!--Start Loading Script-->
    <script>
        window.onload = function() {

            $('body').css("overflow", "overlay");
            $('.double-bounce1, .double-bounce2').fadeOut(1000, function() {
                $('.spinner').fadeOut(1000);
            });

        }
    </script>
    <!--End Loading Script-->

    <!--End Loading-->

    <div id="app">
        <header class="fixed-top">
            {{-- Start Header Navbar --}}
            <nav class="navbar top-nav navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('web.home') }}">
                        <img src="{{ asset('front_resources/images/logo.png') }}" class="img-fluid" alt="..."
                            title="جمعية العطاء الإنسانى والتنمية المستدامة">
                    </a>
                    <span class="d-none d-lg-inline-block date-time">
                        <i class="fa-solid fa-calendar-days px-1"></i> <span class="date"></span>
                        <i class="fa-solid fa-clock pe-3 ps-1"></i> <span class="time"></span>
                    </span>
                    <form role="search" action="{{ route('web.news.search') }}" method="GET">
                        <input class="form-control form-control-lg me-3" name="search" type="search" placeholder="بحث"
                            aria-label="بحث">
                        <button class="btn btn-lg btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </nav>
            {{-- End Header Navbar --}}

            {{-- Start Pagination Navbar --}}
            <nav class="navbar pagination-nav navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand d-lg-none" href="{{ route('web.home') }}">
                        <img src="{{ asset('front_resources/images/logo.png') }}" class="img-fluid" alt="..."
                            title="جمعية العطاء الإنسانى والتنمية المستدامة">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-start" id="navbarNav" dir="rtl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('web.home') }}">
                                    <i class="fa-solid fa-house fa-lg px-1"></i> الصفحة الرئيسية
                                </a>
                            </li>
                            @for ($i = 0; $i < min(count($categories), $max_nav); $i++)
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('web.category.show', $categories[$i]->id) }}">{{ $categories[$i]->name }}</a>
                                </li>
                            @endfor
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('web.galary.index', 'images') }}">الصور</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('web.galary.index', 'videos') }}">الفيديوهات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('web.contact.index') }}">تواصل معنا</a>
                            </li>
                            @if (count($categories) > $max_nav)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        المزيد
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end text-end"
                                        aria-labelledby="navbarDropdown">
                                        @for ($i = $max_nav; $i < min(count($categories), $max_cats); $i++)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('web.category.show', $categories[$i]->id) }}">{{ $categories[$i]->name }}
                                                </a>
                                            </li>
                                        @endfor
                                        @if (count($categories) == $max_cats)
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#">جميع الأقسام</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        </ul>
                        <form class="d-lg-none" role="search" action="{{ route('web.news.search') }}"
                            method="GET">
                            <input class="form-control form-control-lg" name="search" type="search"
                                placeholder="بحث" aria-label="بحث">
                            <button class="btn btn-lg btn-primary" type="submit"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>
            </nav>
            {{-- End Pagination Navbar --}}
        </header>

        {{-- Start Side Links --}}
        <aside class="side-links d-none d-md-flex">
            <ul>
                <a href="#">
                    <li class="facebook"><i class="fa-brands fa-facebook-f fa-lg"></i></li>
                </a>
                <a href="#">
                    <li class="youtube"><i class="fa-brands fa-youtube fa-lg"></i></li>
                </a>
            </ul>
        </aside>
        {{-- End Side Links --}}

        {{-- Start Content --}}
        @yield('content')
        {{-- End Content --}}

        {{-- Start Footer --}}
        <footer>
            <div class="map">
                <div class="container">
                    <ul class="row">
                        <li class="col-6 col-md-3 col-lg-2">
                            <a href="{{ route('web.home') }}">الصفحة الرئيسية</a>
                        </li>
                        @for ($i = 0; $i < min(count($categories), $max_cats); $i++)
                            <li class="col-6 col-md-3 col-lg-2">
                                <a
                                    href="{{ route('web.category.show', $categories[$i]->id) }}">{{ $categories[$i]->name }}</a>
                            </li>
                        @endfor
                        @if (count($categories) == $max_cats)
                            <li class="col-6 col-md-3 col-lg-2">
                                <a href="#">جميع الأقسام</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-4 text-lg-end">
                            &copy; 2022 جميع حقوق الطبع والنشر محفوطة لجعية العطاء
                            الإنسانى
                        </div>
                        <div class="col-12 col-lg-4 my-3 my-lg-0">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook fa-xl"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube fa-xl"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-4 text-lg-start">تم التصميم والتطوير بواسطة
                            <a href="https://www.facebook.com/Dev.Mahmoud.Faisal" class="dev">
                                محمود فيصل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- End Footer --}}

        {{-- Start Scroll To Top Button --}}
        <div class="scroll-to-top">
            <i class="fa-solid fa-angles-up fa-xl"></i>
        </div>
        {{-- End Scroll To Top Button --}}
    </div>

    <script src="{{ asset('front_resources/js/notification.js') }}"></script>
    <script src="{{ asset('front_resources/js/jquery.animateTyping.js') }}"></script>

    @stack('scripts')
</body>

</html>
