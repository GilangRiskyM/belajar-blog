@extends('front.layout')
@section('title', 'Berita')
@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('{{ asset('thumbnail/' . $dataTerakhir->thumbnail) }}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <a href="{{ url('/berita/' . $dataTerakhir->slug) }}" class="text-white">
                            <h1>{{ $dataTerakhir->title }}</h1>
                        </a>
                        <span class="subheading">{{ $dataTerakhir->description }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <!-- Post preview-->
                @foreach ($data as $item)
                    <div class="post-preview">
                        <a href="{{ url('/berita/' . $item->slug) }}">
                            <h2 class="post-title">{{ $item->title }}</h2>
                            <h3 class="post-subtitle">{{ $item->description }}</h3>
                        </a>
                        <p class="post-meta">
                            Diposting oleh
                            <a href="#!">{{ $item->user->name }}</a>
                            pada {{ $item->created_at->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                    <!-- Divider-->
                    <hr class="my-4" />
                @endforeach
                <!-- Pager-->
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        @if (!$data->onFirstPage())
                            <a href="{{ $data->previousPageUrl() }}" class="btn btn-primary text-uppercase">
                                &larr; Berita Terbaru
                            </a>
                        @endif
                    </div>
                    <div>
                        @if ($data->hasMorePages())
                            <a href="{{ $data->nextPageUrl() }}" class="btn btn-primary text-uppercase">
                                Berita Terlama &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
