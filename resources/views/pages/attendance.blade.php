@extends('layouts.app')

@push('header')
    <div class="back-button"><a href="{{ route('home') }}">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                </path>
            </svg></a></div>
@endpush

@section('content')
    <div class="container">
        <!-- Section Heading-->
        <div class="section-heading d-flex align-items-center pt-3 justify-content-between">
            <h6>List Absensi Terakhir</h6>
            <a class="btn btn-success" href="{{ route('shift') }}"><i class="lni lni-plus"></i> Absen Sekarang</a>
        </div>


        <!-- Notifications Area-->
        <div class="notification-area pb-2">
            <div class="list-group">
                @php
                    \Carbon\Carbon::setLocale('id');
                @endphp
                @foreach ($attendances as $item)
                    <a class="list-group-item d-flex align-items-center" href="#">
                        <img src="{{ asset('webcam/' . $item->foto) }}" alt="User Image"
                            style="width:150px;margin-right:20px;">

                        <div class="noti-info">
                            <h6 class="mb-2">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                            </h6>
                            <h4>
                                @if ($item->status == 'on_time')
                                    <span class="text-success">TEPAT WAKTU
                                    @elseif ($item->status == 'late')
                                        <span class="text-danger">TERLAMBAT
                                        @else
                                            <span class="text-secondary">BELUM ABSEN
                                @endif
                                </span>
                            </h4>
                            <span><i class="lni lni-alarm-clock text-primary"></i> Jam :
                                {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} </span>
                            <span><i class="lni lni-paperclip text-primary"></i>
                                @if ($item->type == 'in')
                                    Absen Masuk {{ $item->shift->nama }}
                                @else
                                    Absen Keluar {{ $item->shift->nama }}
                                @endif
                            </span>
                        </div>
                    </a>
                @endforeach

            </div>
            <div class="pagination-container">
            </div>
        </div>
    </div>
@endsection
