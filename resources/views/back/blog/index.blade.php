@extends('back.layout')
@section('title', 'Data Berita')
@section('content')
    <div class="row g-0">
        <h1 class="text-center mb-3">Daftar Berita</h1>
        <div class="d-flex justify-content-between">
            <div class="col-3 col-md-3 mb-3">
                <a href="{{ route('blog.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="col-4 col-md-4 mb-3">
                <form action="{{ route('blog.index') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="cari" id="" class="form-control"
                            value="{{ request('cari') }}" placeholder="Masukan kata kunci">
                        <button type="submit" class="btn btn-primary"><i class='bx bx-search-alt-2'></i> Cari</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr class="text-center">
                            <td>{{ $data->firstItem() + $key }}</td>
                            <td>{{ $value->title }}
                                <div class="small">Penulis : {{ $value->user->name }}</div>
                            </td>
                            <td>{{ $value->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                            <td>
                                @if ($value->status == 'publish')
                                    <span class="badge bg-success">Publish</span>
                                @else
                                    <span class="badge bg-danger">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/berita/' . $value->slug) }}" class="btn btn-info my-2 mx-1">
                                    Lihat Berita
                                </a>
                                <a href="{{ route('blog.edit', ['blog' => $value->id]) }}"
                                    class="btn btn-warning my-2 mx-1">
                                    Edit
                                </a>
                                <a href="{{ route('blog.delete', ['blog' => $value->id]) }}"
                                    class="btn btn-danger my-2 mx-1">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-5">
            {{ $data->links() }}
        </div>
    </div>
@endsection
