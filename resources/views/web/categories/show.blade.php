@extends('web.layouts.app')

@section('content')
    <main class="category-page py-4">
        {{-- Start Category News --}}
        <section class="category-news pb-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-center mb-5">{{ $category->name }}</h1>
                <div class="row">
                    @forelse ($category->news as $news)
                        <div class="col-12 col-md-6">
                            <a href="{{ route('web.news.show', $news->id) }}" class="card-target">
                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4 m-auto text-center">
                                            <img src="{{ $news->image ? asset('storage/images/news') . '/' . $news->image : asset('front_resources/images/imageNotFound.png') }}"
                                                class="img-fluid" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body text-end">
                                                <h5 class="card-title">{{ $news->title }}</h5>
                                                <p class="card-text">
                                                    {{ getWord($news->content, 50) }}
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
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> لا يوجد أخبار بعد
                        </div>
                    @endforelse
                </div>

                @if ($category->news->hasPages())
                    {{ $category->news->links() }}
                @endif
            </div>
        </section>
        {{-- End Category News --}}
    </main>
@endsection
