@extends('web.layouts.app')

@section('content')
    <main class="category-page" class="py-4">
        {{-- Start Categories --}}
        <section class="category-news pb-5">
            <div class="container">
                <div class="row text-center">
                    <h1 class="mb-5 animate__animated animate__jackInTheBox">الأقسام</h1>
                    @forelse ($categories as $category)
                        <div class="col-4 col-md-2 mb-5">
                            <a href="{{ route('web.category.show', $category->id) }}"
                                class="btn btn-primary position-relative">
                                {{ $category->name }}
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $category->news_count }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> لا يوجد أقسام بعد
                        </div>
                    @endforelse
                    @if ($categories->hasPages())
                        {{ $categories->links() }}
                    @endif
                </div>
            </div>
        </section>
        {{-- End Categories --}}
    </main>
@endsection
