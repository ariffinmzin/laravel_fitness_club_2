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
        @if (session('success'))
            <div class="row">
                <div class="col">
                    <div class="alert alert-success mt-3">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

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

                            <x-form.select
                                :options="$countries"
                                label="Negara"
                                name="country_id"
                                id="country_id"
                                :value="old('country_id', $user->country_id)"
                                :error="$errors->first('country_id')"
                            />

                            <!-- <x-form.input name="country_id" label="Negara" type="text" id="country_id" :value="old('country_id',$user->country_id)" :error="$errors->first('country_id')"  /> -->

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
                            action="{{ route('pengguna.update_keahlian', $user->id) }}"
                            method="post"
                        >
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="col-7">
                                    <x-form.select
                                        :options="$plan_options"
                                        label="Current Plan"
                                        name="plan_id"
                                        id="plan_id"
                                        :value="(!$membership_is_empty) ? $user->memberships[0]->plan_id : ''"
                                        :error="$errors->first('plan_id')"
                                    />
                                </div>
                                <div class="col-5">
                                    <x-form.input
                                        id="expire_on"
                                        name="expire_on"
                                        type="date"
                                        value="(!$membership_is_empty) ? $user->memberships[0]->expire_on : ''"
                                        label="Tarikh Luput"
                                        :error="$errors->first('expire_on')"
                                    />
                                </div>

                                <div class="col-12">
                                    <x-form.radiobutton
                                        id="status"
                                        name="status"
                                        label="Status"
                                        :options="$membership_options"
                                        value="(!$membership_is_empty) ? $user->memberships[0]->status : ''"
                                        inline="true"
                                        :error="$errors->first('status')"
                                    />
                                </div>

                                <div class="col-12">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3>Maklumat Bayaran</h3>

                        <form
                            action="{{ route('pengguna.tambah_bayaran', $user->id) }}"
                            method="post"
                        >
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-7">
                                    <x-form.select
                                        :options="$plan_options"
                                        label="Pilih Pelan"
                                        name="plan_id"
                                        id="payment_plan_id"
                                        :value="null"
                                        :error="$errors->first('$plan_id')"
                                    />
                                </div>
                                <div class="col-5">
                                    <x-form.select
                                        :options="$payment_methods"
                                        label="Kaedah Bayaran"
                                        name="payment_method"
                                        id="payment_method"
                                        :value="null"
                                        :error="$errors->first('$payment_method')"
                                    />
                                </div>
                                <div class="col-7">
                                    <x-form.input
                                        id="amount"
                                        name="amount"
                                        type="number"
                                        :value="null"
                                        label="Jumlah"
                                        readonly
                                    />
                                </div>
                                <div class="col-5">
                                    <x-form.input
                                        id="new_expiry"
                                        name="new_expiry"
                                        type="date"
                                        :value="null"
                                        label="Tarikh Luput"
                                        readonly
                                    />
                                </div>
                                <div class="col-12">
                                    <x-form.input
                                        id="remarks"
                                        name="remarks"
                                        type="text"
                                        :value="null"
                                        label="Nota"
                                    />
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                Simpan
                            </button>
                        </form>
                        <h3 class="mt-4">Bayaran Lepas</h3>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarikh</th>
                                <th>Jumlah</th>
                                <th>Kaedah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (! $user->memberships->isEmpty())
                                @if (! $user->memberships[0]->payments->isEmpty())
                                    @foreach ($user->memberships[0]->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at }}</td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>
                                                {{ $payment->payment_method }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var js_plans = {!! $js_plans !!};
    </script>

    <script src="/js/user-payment.js"></script>
@endpush
