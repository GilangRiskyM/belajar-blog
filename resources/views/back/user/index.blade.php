@extends('back.layout')
@section('title', 'Data User')
@section('content')
    <div class="row g-0">
        <h1 class="text-center mb-3">Data User</h1>
        <div class="d-flex justify-content-between">
            @can('admin-user')
                <div class="col-3 col-md-3 mb-3">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
                </div>
            @endcan
            <div class="col-4 col-md-4 mb-3">
                <form action="" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="cari" id="" class="form-control">
                        <a href="" class="btn btn-primary"><i class='bx bx-search-alt-2'></i> Cari</a>
                        <a href="" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        @can('admin-user')
                            <th>No</th>
                        @endcan
                        <th>Nama</th>
                        <th>Waktu Daftar</th>
                        <th>Verifikasi Email</th>
                        @can('admin-user')
                            <th>Block</th>
                        @endcan
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datum)
                        <tr>
                            @can('admin-user')
                                <td>{{ $no++ }}</td>
                            @endcan
                            <td>{{ $datum->name }}
                                <div><small>{{ $datum->email }}</small></div>
                            </td>
                            <td>{{ $datum->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                            <td>
                                @if ($datum->email_verified_at != null)
                                    <h3><span class="badge bg-success">Terverifikasi</span></h3>
                                @else
                                    <h3><span class="badge bg-danger">Belum Terverifikasi</span></h3>
                                @endif
                            </td>
                            @can('admin-user')
                                <td>
                                    <a href="{{ route('users.toggle-block', ['user' => $datum->id]) }}">
                                        @if ($datum->blocked_at != null)
                                            <h3><span class="badge bg-danger">IYA</span></h3>
                                        @else
                                            <h3><span class="badge bg-success">TIDAK</span></h3>
                                        @endif
                                    </a>
                                </td>
                            @endcan
                            <td>
                                <a href="{{ route('users.edit', ['user' => $datum->id]) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('users.delete', ['user' => $datum->id]) }}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
