@extends('layouts.app')

@push('header')
    <div class="back-button"><a href="{{ route('attendance') }}">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                </path>
            </svg></a></div>
@endpush

@section('content')
    <div class="container">
        <div class="product-catagories-wrapper py-3">
            <div class="container">
                <div class="section-heading">
                    <h6>Pilih Shift</h6>
                </div>
                <div class="product-catagory-wrap">
                    <div class="row">
                        <!-- Single Catagory Card-->
                        @foreach ($shifts as $item)
                            <div class="col-md-6 pb-2">
                                <div class="card" style="width: auto;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama }}</h5>
                                        <p class="card-text">Maksimal Toleransi
                                            {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB</p>
                                        <div class="dropdown">
                                            <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Absen Sekarang
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item text-success"
                                                        href="{{ route('add-attendance', [$item->id_shift, 'in']) }}">Masuk</a>
                                                </li>
                                                <li><a class="dropdown-item text-warning"
                                                        href="{{ route('add-attendance', [$item->id_shift, 'out']) }}">Keluar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
