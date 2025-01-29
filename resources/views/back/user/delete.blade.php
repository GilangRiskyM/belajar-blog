@extends('back.layout')
@section('title', 'Hapus User')
@section('content')
    <div class="row g-0">
        <h1 class="text-center mb-3">Hapus User</h1>
        <div class="col-md-12 text-center">
            <div class="alert alert-danger" role="alert">
                <h2><i class='bx bxs-error' style='color:#ff2300'></i> Data yang dihapus tidak dapat dikembalikan!</h2>
            </div>
            <h2>Data User</h2>
            <table class="table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $data->email }}</td>
                </tr>
            </table>
            <form action="{{ route('users.destroy', ['user' => $data->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-danger" type="submit">Hapus</button>
            </form>
        </div>
    </div>
@endsection
