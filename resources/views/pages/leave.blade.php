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
            <h6>List Cuti yang masih diProses</h6>
            <a class="btn btn-success" href="{{ route('add-leave') }}"><i class="lni lni-plus"></i> Buat Baru</a>
        </div>
        <!-- Notifications Area-->
        <div class="notification-area pb-2">
            <div class="list-group">
                @forelse ($pendingLeaves as $item)
                    <a class="list-group-item d-flex align-items-center" href="#">
                        <span class="noti-icon"><i class="lni lni-alarm"></i></span>
                        <div class="noti-info"
                            style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div>
                                <h6 class="mb-0">{{ ucwords($item->reason) }}</h6>
                                <span class="text-primary">{{ $item->user->member->nama }} /
                                    {{ $item->user->divisi->nama }}</span>
                                <span>{{ $item->start_date }} - {{ $item->end_date }}</span>
                                <span style="font-size: 12px;" class="text-warning">dibuat pada
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-y') }}</span>
                            </div>
                            @if ($item->status == 'approved')
                                <span class="btn btn-sm btn-success text-white" style="margin-left: auto;">DISETUJUI</span>
                            @elseif ($item->status == 'rejected')
                                <span class="btn btn-sm btn-danger text-white" style="margin-left: auto;">DITOLAK</span>
                            @else
                                <span class="btn btn-sm btn-warning text-white" style="margin-left: auto;">PENDING</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <a class="list-group-item d-flex align-items-center" href="#">
                        <span class="noti-icon"><i class="lni lni-alarm"></i></span>
                        <div class="noti-info"
                            style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div>
                                <h6 class="mb-0">Tidak ada cuti yang masih diproses</h6>
                            </div>
                        </div>
                    </a>
                @endforelse
            </div>
            <div class="pagination-container">
            </div>
        </div>

        <div class="section-heading d-flex align-items-center pt-3 justify-content-between">
            <h6>List Cuti Terakhir</h6>
        </div>

        <!-- Notifications Area-->
        <div class="notification-area pb-2">
            <div class="list-group">
                @forelse ($leaves as $item)
                    <a class="list-group-item d-flex align-items-center" href="#">
                        <span class="noti-icon"><i class="lni lni-alarm"></i></span>
                        <div class="noti-info"
                            style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div>
                                <h6 class="mb-0">{{ ucwords($item->reason) }}</h6>
                                <span class="text-primary">{{ $item->user->member->nama }} /
                                    {{ $item->user->divisi->nama }}</span>
                                <span>{{ $item->start_date }} - {{ $item->end_date }}</span>
                                <span style="font-size: 12px;" class="text-warning">dibuat pada
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-y') }}</span>
                            </div>
                            @if ($item->status == 'approved')
                                <span class="btn btn-sm btn-success text-white" style="margin-left: auto;">DISETUJUI</span>
                            @elseif ($item->status == 'rejected')
                                <span class="btn btn-sm btn-danger text-white" style="margin-left: auto;">DITOLAK</span>
                            @else
                                <span class="btn btn-sm btn-warning text-white" style="margin-left: auto;">PENDING</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <a class="list-group-item d-flex align-items-center" href="#">
                        <span class="noti-icon"><i class="lni lni-alarm"></i></span>
                        <div class="noti-info"
                            style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div>
                                <h6 class="mb-0">Tidak ada data cuti anda</h6>
                            </div>
                        </div>
                    </a>
                @endforelse
            </div>
            <div class="pagination-container">
            </div>
        </div>


    </div>
@endsection
