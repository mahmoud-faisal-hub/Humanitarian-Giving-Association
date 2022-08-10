@extends('web.layouts.app')

@section('content')
    <main class="category-page py-4">
        {{-- Start Category News --}}
        <section class="category-news pb-5">
            <div class="container">
                <nav aria-label="breadcrumb mb-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">بحث</li>
                    </ol>
                </nav>
                <div class="row">
                    @forelse ($news as $article)
                        <div class="col-12 col-md-6">
                            <a href="{{ route('web.news.show', $article->id) }}" class="card-target">
                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4 m-auto text-center">
                                            <img src="{{ $article->image ? asset('storage/images/news') . '/' . $article->image : asset('front_resources/images/imageNotFound.png') }}"
                                                class="img-fluid" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body text-end">
                                                <h5 class="card-title">{{ $article->title }}</h5>
                                                <p class="card-text">
                                                    {{ getWord($article->content, 50) }}
                                                </p>
                                                <p class="card-text" dir="ltr">
                                                    <small class="text-muted">
                                                        {{ arabicDate(arabicNumbers($article->created_at->format('D، j M Y ~ g:i a'))) }}
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

                @if ($news->hasPages())
                    {{ $news->links() }}
                @endif
            </div>
        </section>
        {{-- End Category News --}}
    </main>
@endsection
