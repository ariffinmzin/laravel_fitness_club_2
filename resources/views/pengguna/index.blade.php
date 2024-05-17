@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Senarai Pengguna')
@section('page-title-actions')
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                Pengguna baru
            </a>
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary d-sm-none btn-icon">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            </a>
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
    <div class="card-body pb-0">
        {{ $users->links() }}

    </div>
   
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tarikh Daftar</th>
                <th>Action</th>
            </tr>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td><a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-primary">EDIT</a></td>
                </tr>
                @endforeach
    
    
            </tbody>
        </thead>
    </table>

    <!-- {!! $users->render() !!} -->
    <div class="card-body py-0">
        {{ $users->links() }}

    </div>


</div>


</div>
</div>
</div>


@endsection