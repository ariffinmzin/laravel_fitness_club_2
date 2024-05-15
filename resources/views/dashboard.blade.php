@extends('layouts.dashboard')

@section('page-pretitle', 'Overview')
@section('page-title', 'Dashboard')
@section('page-title-actions')
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <span class="d-none d-sm-inline">
                <a href="#" class="btn btn-white">New view</a>
            </span>
            <a
                href="#"
                class="btn btn-primary d-none d-sm-inline-block"
                data-bs-toggle="modal"
                data-bs-target="#modal-report"
            >
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Create new report
            </a>
            <a
                href="#"
                class="btn btn-primary d-sm-none btn-icon"
                data-bs-toggle="modal"
                data-bs-target="#modal-report"
                aria-label="Create new report"
            >
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>Maklumat Keahlian</h3>

                        @php
                            use Carbon\Carbon;
                            $membership = auth()
                                ->user()
                                ->memberships()
                                ->first();
                        @endphp

                        @if ($membership)
                            @php
                                $today = now();
                                $expiryDate = Carbon::createFromFormat('Y-m-d', $membership->expire_on);
                                $daysLeft = $today->diffInDays($expiryDate, false);
                            @endphp

                            <p>
                                <strong>Pelan</strong>
                                <br />
                                {{ $membership->plan->name }}
                            </p>
                            <p>
                                <strong>Status</strong>
                                <br />
                                {{ $membership->status }}
                            </p>
                            <p>
                                <strong>Tarikh Luput</strong>
                                <br />
                                {{ $membership->expire_on }} -

                                @if ($daysLeft > 0)
                                    {{ ceil($daysLeft) }} baki hari
                                @elseif ($daysLeft == 0)
                                    hari ini
                                @else
                                    {{ ceil(abs($daysLeft)) }} hari yang lalu
                                @endif
                            </p>
                        @else
                            <p>Anda tiada keahlian. Sila buat bayaran.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                @if (session('status'))
                    <div>{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h3>Bayar Yuran Keahlian</h3>
                        @foreach ($plans as $plan)
                            <div class="card mb-3">
                                <div
                                    class="card-body d-flex justify-content-between"
                                >
                                    <div>
                                        <h4>{{ $plan->name }}</h4>
                                        RM{{ $plan->price }}
                                    </div>
                                    <div>
                                        <a
                                            href="{{
                                                route('checkout.go', [
                                                    'plan' => $plan->code,
                                                    'payment_method' => 'stripe',
                                                ])
                                            }}"
                                            class="btn btn-primary d-block w-100 mb-2"
                                        >
                                            Bayar dengan Stripe
                                        </a>

                                        <a
                                            href="{{
                                                route('checkout.go', [
                                                    'plan' => $plan->code,
                                                    'payment_method' => 'securepay',
                                                ])
                                            }}"
                                            class="btn btn-primary d-block w-100"
                                        >
                                            Bayar dengan Securepay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-xl -->
@endsection
