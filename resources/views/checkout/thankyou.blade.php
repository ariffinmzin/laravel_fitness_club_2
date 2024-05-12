@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Terima Kasih</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success">
                                <p>
                                    <strong>Terima Kasih</strong>
                                    Kami akan meneliti bayaran yang telah
                                    dibuat, dan ia akan diproses secepat mungkin
                                </p>
                                <p>
                                    <a
                                        class="btn btn-primary"
                                        href="{{ route('dashboard') }}"
                                    >
                                        Kembali ke halaman utama
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
