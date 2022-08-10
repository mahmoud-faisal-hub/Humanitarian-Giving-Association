@extends('web.layouts.app')

@section('content')
    <main class="news-page py-4">
        {{-- Start News --}}
        <section class="news pb-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('web.category.show', $news->category->id) }}">{{ $news->category->name }}</a>
                        </li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">المكتبة</li> --}}
                    </ol>
                </nav>
                <h1 class="mb-1">{{ $news->title }}</h1>
                <small class="text-muted">
                    {{ arabicDate(arabicNumbers($news->created_at->format('D، j M Y ~ g:i a'))) }}
                </small>
                <div class="ck-content mt-4">
                    {!! $news->article !!}
                </div>
                <p class="mt-4"></p>
            </div>
        </section>
        {{-- End News --}}
    </main>
@endsection
