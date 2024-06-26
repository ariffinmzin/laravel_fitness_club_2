@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Pengguna Baru')
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
                    @if(old('role') =='member') checked @endif>
                    <label class="form-check-label" for="role-member">
                    Member
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role-admin" value="admin"
                    @if(old('role') == 'admin') checked @endif>
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
        
            <input type="submit" value="Submit" class="btn btn-primary" />
        </form>
    

    </div>


</div>


</div>
</div>
</div>


@endsection