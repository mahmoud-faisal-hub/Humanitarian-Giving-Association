@extends('web.layouts.app')

@section('content')
    <main class="galary-page py-4">
        {{-- Start Galary Files --}}
        <section class="galary-files pb-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @if (request()->type == 'images')
                                الصور
                            @elseif (request()->type == 'videos')
                                الفيديوهات
                            @else
                                المعرض
                            @endif
                        </li>
                    </ol>
                </nav>
                <div class="row text-center align-items-center">
                    <h1 class="mb-5 animate__animated animate__jackInTheBox">
                        @if (request()->type == 'images')
                            الصور
                        @elseif (request()->type == 'videos')
                            الفيديوهات
                        @else
                            المعرض
                        @endif
                    </h1>
                    @php
                        $image = ['png', 'jpeg', 'jpg', 'gif'];
                        $video = ['mp4', 'ogv', 'webm', 'avi'];
                    @endphp
                    @forelse ($galary as $file)
                        @php
                            $type;
                            if (in_array($file->extension, $image)) {
                                $type = 'image';
                            } elseif (in_array($file->extension, $video)) {
                                $type = 'video';
                            }
                        @endphp
                        <div class="col-6 col-md-4 col-lg-3 mb-2">
                            <div class="btn show-file-modal w-100" id="show-file" data-bs-toggle="modal"
                                data-bs-target="#show-file-modal"
                                data-src="{{ $file->file ? asset('storage/images/galary') . '/' . $file->file : asset('front_resources/images/imageNotFound.png') }}"
                                data-type="{{ $type }}" data-description="{{ $file->description }}">
                                @if ($type == 'image')
                                    <img src="{{ $file->file ? asset('storage/images/galary') . '/' . $file->file : asset('front_resources/images/imageNotFound.png') }}"
                                        class="img-thumbnail img-fluid w-100" alt="..."
                                        title="{{ $file->description }}">
                                @elseif ($type == 'video')
                                    <video class="img-thumbnail img-fluid w-100" title="{{ $file->description }}">
                                        <source src="{{ asset('storage/images/galary') . '/' . $file->file }}">
                                        Your browser does not support the video tag.
                                    </video>
                                    <i class="fa-solid fa-circle-play"></i>
                                @endif
                            </div>
                            <span class="lead">{{ $file->description }}</span>
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> لا يوجد عناصر فى المعرض بعد
                        </div>
                    @endforelse
                    @if ($galary->hasPages())
                        {{ $galary->links() }}
                    @endif
                </div>
            </div>
        </section>
        {{-- End Galary Files --}}
    </main>

    <!-- Start Show File Modal -->
    <div class="modal fade" id="show-file-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">عرض الوسائط</h5>
                    <button type="button" class="btn-close me-auto ms-1" data-bs-dismiss="modal" aria-label="إلغاء">
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-thumbnail img-fluid d-none w-100" alt="...">
                    <video class="d-none w-100" controls>
                        <source src="">
                        Your browser does not support the video tag.
                    </video>
                    <p class="lead mb-0"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Show File Model -->
@endsection

@push('scripts')
    {{-- Show File Modal Config --}}
    <script>
        var fileSrc, fileType, fileDescription;

        $("main").on("click", '#show-file', function() {
            fileSrc = $(this).data("src");
            fileType = $(this).data("type");
            fileDescription = $(this).data("description");

            if (fileType == "image") {
                $("#show-file-modal img").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").addClass("d-none");
            } else if (fileType == "video") {
                $("#show-file-modal img").addClass("d-none");
                $("#show-file-modal video").attr("src", fileSrc).removeClass("d-none");
                $("#show-file-modal video").get(0).play();
            }

            $("#show-file-modal p").text(fileDescription);
        });

        $("#show-file-modal").on('hide.bs.modal', function() {
            $(this).find("video").get(0).pause();
        });
    </script>
@endpush
