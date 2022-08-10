@extends('web.layouts.app')

@push('styles')
    <style>
        body {
            margin-top: 0 !important;
        }

        @media (min-width: 992px) {
            header nav.top-nav {
                background-color: #fff2;
            }

            header nav.pagination-nav {
                background-color: #fff1;
            }
        }
    </style>
@endpush

@section('content')
    {{-- {{ dd($news) }} --}}
    <main class="home-page" class="py-4">
        {{-- Start Home Section --}}
        <section class="home">
            <div class="overlay text-white text-center">
                <div class="container">
                    <h1 class="animate__animated animate__zoomInUp">
                        مرحباً فى موقع جمعية العطاء الإنسانى والتنمية المستدامة
                    </h1>
                    <p class="animate-typing lead" data-animate-loop="false" data-type-speed="100" data-type-delay="200"
                        data-remove-speed="50" data-remove-delay="500" data-cursor-speed="500">
                        بدأ التفكير فى أهمية القيام بجهد تطوعى من أجل بناء الإنسان والمجتمع والنهوض به .
                        وعلى ضوء ذلك تم التشاور مع الكثيرين وتبادل وجهات النظر ، لتجسيد تلك الأفكار ،
                        وتقدمنا بطلب لوزارة التضامن الإجتماعى ،
                        ووافقوا مشكورين لنا طبقًا للقانون واللوائح على جمعية خيرية باسم
                        ( العطاء الإنسانى والتنمية المستدامة ) .
                        سراب عوض رئيس مجلس إدارة الجمعية
                    </p>
                    <span id="scrollBottom"><i class="fa-solid fa-angles-down fa-xl"></i></span>
                    {{-- <div class="animate-typing" data-animate-loop="false" data-type-speed="100" data-type-delay="200"
                            data-remove-speed="50" data-remove-delay="500" data-cursor-speed="500">
                            test
                        </div> --}}
                </div>
            </div>
        </section>
        {{-- End Home Section --}}

        {{-- Start About Us Section --}}
        <section class="about-us bg-white text-center py-5">
            <div class="container">
                <div class="header">
                    <h1 class="mb-5">عن الجمعية</h1>
                </div>
                <p class="pb-4 mb-0">
                    جمعية العطاء الانسانى والتنمية المستدامة مقيدة بمديرية التضامن الإجتماعى بالجيزة تحت رقم 7184 بتاريخ
                    ٧-٣-٢٠٢٢ ، طبقا لأحكام القانون ١٤٩ لسنة ٢٠١٩ ، بشأن تنظيم ممارسة العمل الأهلى - بإدارة العجوزة بالتضامن
                    الاجتماعى .
                    <br>
                    مجال العمل الرئيسى : خدمات ثقافية وعلمية
                </p>
                <div>
                    <a href="#" id="test" class="btn btn-success btn-lg">تواصل معنا</a>
                </div>
            </div>
        </section>
        {{-- End About Us Section --}}

        {{-- Start Latest News Section --}}
        <section class="latest-news">
            <div class="container">
                <div class="header text-center">
                    <h1 class="mb-5 py-1">أخر أخبار الجمعية</h1>
                </div>
                <div id="carouselExampleCaptions" class="carousel slide rounded overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-indicators" dir="ltr">
                        @for ($i = 0; $i < count($latest_news); $i++)
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="{{ $i }}" {{ $i == 0 ? 'class=active aria-current=true' : '' }}
                                aria-label="Slide {{ $i + 1 }}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @foreach ($latest_news as $key => $news)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <a href="{{ route('web.news.show', $news->id) }}">
                                    <img src="{{ $news->image ? asset('storage/images/news') . '/' . $news->image : asset('front_resources/images/imageNotFound.png') }}"
                                        class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $news->title }}</h5>
                                        <p>
                                            {{ getWord($news->content, 50) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالى</span>
                    </button>
                </div>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-6">
                            <div class="card text-center my-3">
                                <div class="card-header">
                                    {{ $category->name }}
                                </div>
                                <div class="card-body">
                                    @forelse ($category->news as $news)
                                        <a href="{{ route('web.news.show', $news->id) }}" class="card-target">
                                            <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                                <div class="row g-0">
                                                    <div class="col-md-4 m-auto">
                                                        <img src="{{ $news->image ? asset('storage/images/news') . '/' . $news->image : asset('front_resources/images/imageNotFound.png') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body text-end">
                                                            <h5 class="card-title">{{ $news->title }}</h5>
                                                            <p class="card-text">
                                                                {{ getWord($news->content, 20) }}
                                                            </p>
                                                            <p class="card-text" dir="ltr">
                                                                <small class="text-muted">
                                                                    {{ arabicDate(arabicNumbers($news->created_at->format('D، j M Y ~ g:i a'))) }}
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="alert alert-warning" role="alert">
                                            لا يوجد أخبار بعد
                                        </div>
                                    @endforelse
                                </div>
                                <a href="{{ route('web.category.show', $category->id) }}" class="text-decoration-none">
                                    <div class="card-footer text-muted">
                                        المزيد
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        {{-- End Latest News Section --}}

        {{-- Start Contact Us Section --}}
        <section class="contact-us text-center">
            <div class="overlay">
                <div class="container">
                    <div class="header">
                        <i class="fa fa-headphones"></i>
                        <h1 class="mb-5 py-1">تواصل معنا</h1>
                    </div>
                    <div class="contact-form">
                        <form class="row g-3 needs-validation" id="message" novalidate>
                            <div class="col-12 col-md-6 px-3">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                        placeholder="الإسم بالكامل" aria-describedby="name_error" required>
                                    <div class="invalid-feedback is-invalid" id="name_error">
                                        برجاء إدخال الإسم بالكامل
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" id="validationCustom02"
                                        placeholder="الإيميل" aria-describedby="email_error" required>
                                    <div class="invalid-feedback" id="email_error">
                                        برجاء إدخال الإيميل بطريقة صحيحة
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group has-validation">
                                        <input type="number" name="phone" class="form-control"
                                            id="validationCustomUsername" placeholder="رقم الهاتف"
                                            aria-describedby="phone_error" required>
                                        <div class="invalid-feedback" id="phone_error">
                                            برجاء إدخال رقم الهاتف
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 px-3">
                                <div class="form-group">
                                    <div class="input-group has-validation">
                                        <textarea class="form-control" name="message" id="validationCustomUsernameg" aria-describedby="message_error"
                                            placeholder="الرسالة" required></textarea>
                                        <div class="invalid-feedback" id="message_error">
                                            برجاء إدخال الرسالة
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">إرسال</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Contact Us Section --}}
    </main>

    <!--Start Notification Messages-->

    <span
        class="notification notification-success default-background text-white bg-success col-12 col-md-6 col-lg-5 col-xl-4">
        <i class="fa-solid fa-circle-check"></i> <span class="msg"></span>
    </span>
    <span class="notification notification-fail default-background text-white bg-danger col-12 col-md-6 col-lg-5 col-xl-4">
        <i class="fa-solid fa-circle-xmark"></i> <span class="msg"></span>
    </span>

    <!--End Notification Messages-->
@endsection

@push('scripts')
    {{-- Animate CSS --}}
    <script>
        function isElementInViewport(elem) {
            var $elem = $(elem);

            // Get the scroll position of the page.
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            // Get the position of the element on the page.
            var elemTop = Math.round($elem.offset().top);
            var elemBottom = elemTop + $elem.height();

            return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
        }

        // Check if it's time to start the animation.
        function checkAnimation(elm, animationClass) {
            var $elem = $(elm);

            // If the animation has already been started
            if ($elem.hasClass(animationClass)) return;

            if (isElementInViewport($elem)) {
                // Start the animation
                $elem.addClass(animationClass);
            }
        }

        // Capture scroll events
        $(window).scroll(function() {
            checkAnimation('.about-us h1', 'animate__animated animate__jackInTheBox');
            checkAnimation('.latest-news .header h1', 'animate__animated animate__jackInTheBox');
            checkAnimation('.carousel', 'animate__animated animate__fadeInUp');
            checkAnimation('.contact-us .header', 'animate__animated animate__jackInTheBox');
        });
    </script>

    {{-- Home Section --}}
    <script>
        $(window).on("scroll resize", function() {
            // Navbar Scroll Ainmation
            if ($(window).scrollTop() > 0) {
                $("header nav.pagination-nav").css("background-color", "#4caf50");
                $("header nav.top-nav").css("background-color", "#3AC47D");
            } else {
                if ($(window).width() >= 992) {
                    $("header nav.pagination-nav, header nav.top-nav").css("background-color", "#fff1");
                    $("header nav.top-nav").css("background-color", "#fff2");
                } else {
                    $("header nav.pagination-nav").css("background-color", "#4caf50");
                    $("header nav.top-nav").css("background-color", "#3AC47D");
                }
            }
        });

        // $(window).on("resize");

        $("section.home #scrollBottom").on("click", function() {
            $("html, body").scrollTop($("section.home").offset().top + $("section.home").outerHeight() - $(
                "header").outerHeight());
        });
    </script>

    {{-- Ajax --}}
    @include('ajax', [
        'form' => '#message',
        'url' => route('web.message.store'),
        'method' => 'POST',
        'clear' => true,
    ])
@endpush
