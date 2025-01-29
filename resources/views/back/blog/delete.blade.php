@extends('back.layout')
@section('title', 'Hapus Berita')
@section('content')
    <div class="row g-0">
        <h1 class="text-center">Hapus Berita</h1>
        <div class="alert alert-danger  mb-3" role="alert">
            <h2 class="text-center">
                <i class='bx bx-error' style='color:#ff0000'></i> Apakah anda yakin ingin menghapus data siswa ini?
                <br>
                Data yang dihapus tidak dapat dikembalikan!
            </h2>
        </div>
        <table class="table">
            <tr>
                <td>Judul</td>
                <td>:</td>
                <td>
                    {{ $data->title }}
                    <div class="small">Penulis : {{ $data->user->name }}</div>
                </td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>{{ $data->description }}</td>
            </tr>
            <tr>
                <td>Thumbnail</td>
                <td>:</td>
                <td>
                    <img class="img-thumbnail" src="{{ asset('thumbnail/' . $data->thumbnail) }}" alt=""
                        width="15%">
                </td>
            </tr>
            <tr>
                <td>Konten</td>
                <td>:</td>
                <td>{!! $data->content !!}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>{{ $data->status }}</td>
            </tr>
        </table>
        <div class="my-3">
            <center>
                <form action="{{ route('blog.destroy', ['blog' => $data->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="{{ route('blog.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </center>
        </div>
    </div>
@endsection
