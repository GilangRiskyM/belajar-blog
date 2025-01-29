@extends('back.layout')
@section('title', 'Tambah User Baru')
@section('content')
    <div class="row g-0">
        <h1 class="text-center mb-3">
            Tambah User Baru
        </h1>
        @if ($errors->any())
            <div class="alert alert-danger mx-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-md-12 mb-3">
            <div class="mb-3">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ old('name') }}" id="name"
                            name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email"
                            id="email">
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" name="email_verified_at" id="email_verified_at" class="form-check-input"
                            {{ old('email_verified_at') == null ? '' : 'checked' }}>
                        <label for="email_verified_at" class="form-label">Verifikasi Email</label>
                    </div>
                    <header>
                        <h4>Password</h4>
                        <p>
                            Silakan isi password baru.
                        </p>
                    </header>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" value="" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    @can('admin-user')
                        <header>
                            <h4>Permission</h4>
                            <p>
                                Tentukan Permission yang akan diberikan kepada user, biarkan tetap kosong jika user hanya
                                sebagai
                                pengguna biasa.
                            </p>
                        </header>
                        @foreach ($permissions as $key => $value)
                            <div class="mb-3">
                                <input type="checkbox" name="permission[]" id="{{ $value->name }}" class="form-check-input"
                                    value="{{ $value->name }}"
                                    {{ old('permission') && in_array($value->name, old('permission')) ? 'checked' : '' }}>
                                <label for="{{ $value->name }}" class="form-label">{{ $value->name }}</label>
                            </div>
                        @endforeach
                    @endcan
                    <div class="mb-3 text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
