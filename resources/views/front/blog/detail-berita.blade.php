@extends('front.layout')
@section('title', $data->title)
@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('{{ asset('thumbnail/' . $data->thumbnail) }}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading text-center">
                        <h1>{{ $data->title }}</h1>
                        <h2 class="subheading">{{ $data->description }}</h2>
                        <span class="meta">
                            Diposting oleh
                            <a href="#!">{{ $data->user->name }}</a>
                            pada {{ $data->created_at->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Post Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    {!! $data->content !!}
                </div>
                {{-- Pager  --}}
                <div class="d-flex justify-content-between my-3">
                    <div>
                        @if ($pagination['sebelum'])
                            <a href="{{ url('/berita/' . $pagination['sebelum']->slug) }}" class="btn btn-primary">
                                &larr; {{ $pagination['sebelum']->title }}
                            </a>
                        @else
                            <span></span>
                        @endif
                    </div>
                    <div>
                        @if ($pagination['sesudah'])
                            <a href="{{ url('/berita/' . $pagination['sesudah']->slug) }}" class="btn btn-primary">
                                {{ $pagination['sesudah']->title }} &rarr;
                            </a>
                        @else
                            <span></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
