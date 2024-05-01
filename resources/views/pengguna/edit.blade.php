@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Edit Pengguna')
@section('page-title-actions')
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
           
        </div>
    </div>
@endsection

@section('content')
<div class="container-xl">
    <div class="row justify-content-center">
        <div class="col"></div>


@if(session('success'))

<div class="alert alert-success mt-3">

    <p>{{ session('success') }}</p>

</div>

@endif
<div class="card">
    
    <div class="card-body">

        <form action="{{ route('pengguna.update',$user->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name',$user->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email',$user->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 @error('role') is-invalid @enderror">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Role</label>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role-member" value="member"
                    @if($user->role =='member') checked @endif>
                    <label class="form-check-label" for="role-member">
                    Member
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role-admin" value="admin"
                    @if($user->role =='admin') checked @endif>
                    <label class="form-check-label" for="role-admin">
                    Admin
                    </label>
                </div>
            </div>
            @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        <button class="btn btn-primary" type="submit">Simpan</button>
        </form>
    </div>

</div>


</div>
</div>
</div>


@endsection