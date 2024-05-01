@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Senarai Pelan')
@section('page-title-actions')
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="{{ route('plan.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                Pelan baru
            </a>
            <a href="{{ route('plan.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Code</th>
                <th>Harga</th>
                <th>Tempoh</th>
                <th>Action</th>
            </tr>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->code }}</td>
                    <td>{{ $plan->price }}</td>
                    <td>{{ $plan->duration }}</td>
                    <td><a href="{{ route('plan.edit', $plan->id) }}" class="btn btn-sm btn-primary">EDIT</a></td>
                </tr>

                @empty
                <tr>
                    <td colspan="6">Tiada pelan dalam sistem</td>
                </tr>
                @endforelse
    
    
            </tbody>
        </thead>
    </table>


</div>


</div>
</div>
</div>


@endsection