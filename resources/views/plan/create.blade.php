@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Pelan Baru')
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

        <form action="{{ route('plan.store') }}" method="post">
            @csrf

            <x-input 
                label="Name"
                type="text"
                name="name"
                id="name"
                :value="old('name')"
                :error="$errors->first('name')"
            />

            <x-input 
                label="Code"
                type="text"
                name="code"
                id="code"
                :value="old('code')"
                :error="$errors->first('code')"
            />

            <x-input 
                label="Price"
                type="number"
                name="price"
                id="price"
                :value="old('price')"
                :error="$errors->first('price')"
            />

            <div class="mb-3">
                <label for="duration" class="form-label">Tempoh</label>

                <select name="duration" id="duration" class="form-select">
                    <option value="1 day">1 day</option>
                    <option value="1 week">1 week</option>
                    <option value="1 month">1 month</option>
                    <option value="3 months">3 months</option>
                    <option value="6 months">6 months</option>
                    <option value="1 year">1 year</option>
                </select>
            </div>

                <div class="mb-3">
                    <label for="active" class="form-label">Active</label>
                    <label for="radio-1" class="form-check">
                        <input id="radio-1" type="radio" class="form-check-input" name="active" value="1">
                        <span class="form-check-label">Active</span>
                    </label>
                    <label for="radio-0" class="form-check">
                        <input id="radio-0" type="radio" class="form-check-input" name="active" value="0">
                        <span class="form-check-label">Inactive</span>
                    </label>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>

           



          


        </form>




    </div>
</div>




@endsection