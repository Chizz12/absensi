@extends('layouts.app')

@push('header')
    <div class="back-button"><a href="{{ route('permit') }}">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                </path>
            </svg></a></div>
@endpush

@section('content')
    <div class="container py-5">
        <div class="mx-auto max-w-2xl text-center">
            <div class="d-flex justify-content-center align-items-center">
                <h2 class="h2 fw-bold text-gray-900">Form Pengajuan Izin Karyawan</h2>
            </div>
            <p class="mt-2 fs-6 text-gray-600">Silakan isi form di bawah ini untuk izin karyawan.</p>
        </div>
        <!-- Contact Form-->
        <div class="contact-form mt-3 pb-3">
            <form action="{{ route('post-permit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h6 class="mb-2">Nama Karyawan :</h6>
                    <input class="form-control mb-3" name="nama" type="text" readonly
                        value="{{ Auth::user()->member->nama . ' (' . Auth::user()->member->id_member . ')' }}">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Jabatan dan Divisi :</h6>
                    <input class="form-control mb-3" name="jabatans" type="text" readonly
                        value="{{ Auth::user()->jabatan->nama . ' (' . Auth::user()->divisi->nama . ')' }}">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Dari Tanggal :</h6>
                    <input class="form-control mb-3" name="from_date" type="date" value="" required="">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Sampai Tanggal :</h6>
                    <input class="form-control mb-3" name="to_date" type="date" value="" required="">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Jam Pulang Awal :</h6>
                    <input class="form-control mb-3" name="time" type="time" value="" required="">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Jenis Izin :</h6>
                    <select class="mb-3 form-control form-select" name="category" required="">
                        <option value="">Jenis Izin ...</option>
                        <option value="Izin datang terlambat">Izin datang terlambat</option>
                        <option value="Izin Pulang lebih awal">Izin Pulang lebih awal</option>
                        <option value="Izin Tidak Masuk Kerja">Izin Tidak Masuk Kerja</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Alasan/Kepentingan :</h6>
                    <textarea class="form-control mb-3" name="description" cols="30" rows="10" placeholder="tulis disini..."
                        required=""></textarea>
                </div>

                <button class="btn btn-success btn-lg w-100" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
