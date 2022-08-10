@extends('web.layouts.app')

@push('styles')
    <style>
        iframe {
            display: flex;
            margin: auto;
            box-shadow: 10px 10px 15px 0px rgb(0 0 0 / 34%);
            -webkit-box-shadow: 10px 10px 15px 0px rgb(0 0 0 / 34%);
            -moz-box-shadow: 10px 10px 15px 0px rgba(0, 0, 0, 0.34);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
@endpush

@section('content')
    <main class="contact-page py-4">
        {{-- Start Contact --}}
        <section class="contact pb-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تواصل معنا</li>
                    </ol>
                </nav>
                <p><span class="text-success">تليفون: </span> </p>
                <p><span class="text-success">عنوان: </span> ١٤ ش . الحسنى - العجوزة - جيزة</p>
                <p><span class="text-success">العنوان البريدي: </span> </p>
                <iframe class="mt-4 rounded"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d215.81836350959674!2d31.19224988013069!3d30.062845207814583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14584140f677c5c3%3A0xf1d72ee27c34d90a!2s14%20Sudan%2C%20Mit%20Akaba%2C%20Agouza%2C%20Giza%20Governorate%203754232!5e0!3m2!1sen!2seg!4v1660147400506!5m2!1sen!2seg"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
        {{-- End Contact --}}
    </main>
@endsection
