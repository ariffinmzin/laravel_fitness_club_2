@extends('layouts.main') @section('content')

<h1>Daftar Pengguna Baru</h1>

<form action="/pengguna" method="post">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
        />
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
        />
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            value="{{ old('password') }}"
        />
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <input type="submit" value="Submit" class="btn btn-primary" />
</form>

@endsection
