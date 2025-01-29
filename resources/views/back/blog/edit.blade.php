@extends('back.layout')
@section('title', 'Edit Berita')
@section('content')
    <div class="row g-0">
        <h1 class="text-center mb-3">Edit Berita</h1>
        @if ($errors->any())
            <div class="alert alert-danger mx-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-mb-12 mb-3">
            <form action="{{ route('blog.update', ['blog' => $data->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $data->title) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="text" name="description" id="description" class="form-control"
                        value="{{ old('description', $data->description) }}">
                </div>

                @isset($data->thumbnail)
                    <img src="{{ asset('thumbnail/' . $data->thumbnail) }}" alt="thumbnail" class="img-thumbnail"
                        width="15%">
                @endisset
                <div class="mb-3">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                        value="{{ old('thumbnail') }}">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea name="content" id="content" class="form-control">{{ old('content', $data->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="from-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="publish" {{ old('status', $data->status) == 'publish' ? 'selected' : '' }}>
                            Publish
                        </option>
                        <option value="draft" {{ old('status', $data->status) == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <center>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary mx-3">Kembali</a>
                        <button type="submit" class="btn btn-primary mx-3">Simpan</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
@endsection
