@extends('layouts.dashboard')

@section('page-pretitle', 'Admin')
@section('page-title', 'Edit Pengguna')
@section('page-title-actions')
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list"></div>
    </div>
@endsection

@section('content')
    <div class="container-xl">
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('pengguna.update', $user->id) }}"
                            method="post"
                        >
                            @csrf
                            @method('PUT')

                            <h3>Maklumat Ahli</h3>

                            <x-form.input
                                name="name"
                                label="Nama"
                                type="text"
                                id="name"
                                :value="old('name',$user->name)"
                                :error="$errors->first('name')"
                            />

                            <x-form.input
                                name="email"
                                label="Email"
                                type="email"
                                id="email"
                                :value="old('email',$user->email)"
                                :error="$errors->first('email')"
                            />

                            <x-form.input
                                name="password"
                                label="Password"
                                type="password"
                                id="password"
                                :value="old('password')"
                                :error="$errors->first('password')"
                            />

                            <x-form.radiobutton
                                name="role"
                                label="Role"
                                id="role"
                                :options="$role_options"
                                :value="old('role', $user->role)"
                                :error="$errors->first('role')"
                                inline="true"
                            />

                            <!-- @error('role')












































                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror









































 -->

                            <h3>Alamat</h3>

                            <x-form.input
                                name="address_1"
                                label=""
                                type="text"
                                id="address_1"
                                :value="old('address_1',$user->address_1)"
                                :error="$errors->first('address_1')"
                            />

                            <x-form.input
                                name="address_2"
                                label=""
                                type="text"
                                id="address_2"
                                :value="old('address_2',$user->address_2)"
                                :error="$errors->first('address_2')"
                            />

                            <x-form.input
                                name="city"
                                label="Bandar"
                                type="text"
                                id="city"
                                :value="old('city',$user->city)"
                                :error="$errors->first('city')"
                            />

                            <x-form.input
                                name="state"
                                label="Negeri"
                                type="text"
                                id="state"
                                :value="old('state',$user->state)"
                                :error="$errors->first('state')"
                            />

                            <x-form.input
                                name="postcode"
                                label="Poskod"
                                type="text"
                                id="postcode"
                                :value="old('postcode',$user->postcode)"
                                :error="$errors->first('postcode')"
                            />

                            <x-form.input
                                name="country_id"
                                label="Negara"
                                type="text"
                                id="country_id"
                                :value="old('country_id',$user->country_id)"
                                :error="$errors->first('country_id')"
                            />

                            <button class="btn btn-primary" type="submit">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>Maklumat Keahlian</h3>
                        <form
                            action="{{ route('pengguna.update', $user->id) }}"
                            method="post"
                        >
                            @csrf
                            @method('put')
                            <input
                                type="hidden"
                                name="action"
                                value="update_membership"
                            />
                            <div class="row">
                                <div class="col-7">
                                    <x-form.select
                                        :options="$plan_options"
                                        label="Current Plan"
                                        name="plan_id"
                                        id="plan_id"
                                        :value="false"
                                    />
                                </div>
                                <div class="col-5">
                                    <x-form.input
                                        id="expire_on"
                                        name="expire_on"
                                        type="date"
                                        value="false"
                                        label="Tarikh Luput"
                                    />
                                </div>

                                <div class="col-12">
                                    <x-form.radiobutton
                                        id="status"
                                        name="status"
                                        label="Status"
                                        :options="$membership_options"
                                        value="false"
                                        inline="true"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3>Maklumat Bayaran</h3>
                        <div class="row">
                            <div class="col-7">
                                <x-form.select
                                    :options="$plan_options"
                                    label="Pilih Pelan"
                                    name="plan_id"
                                    id="plan_id"
                                    :value="false"
                                />
                            </div>
                            <div class="col-5">
                                <x-form.select
                                    :options="$plan_options"
                                    label="Kaedah Bayaran"
                                    name="plan_id"
                                    id="plan_id"
                                    :value="false"
                                />
                            </div>
                            <div class="col-7">
                                <x-form.input
                                    id="amount"
                                    name="amount"
                                    type="number"
                                    value="false"
                                    label="Jumlah"
                                />
                            </div>
                            <div class="col-5">
                                <x-form.input
                                    id="expire_on"
                                    name="expire_on"
                                    type="date"
                                    value="false"
                                    label="Tarikh Luput"
                                />
                            </div>
                            <div class="col-12">
                                <x-form.input
                                    id="expire_on"
                                    name="expire_on"
                                    type="text"
                                    value="false"
                                    label="Nota"
                                />
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
