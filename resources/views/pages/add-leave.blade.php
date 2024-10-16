@extends('layouts.app')

@push('header')
    <div class="back-button"><a href="{{ route('leave') }}">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                </path>
            </svg></a></div>
@endpush

@section('content')
    <div class="container">
        <div class="section-heading mt-3">
            <h5 class="mb-1">Buat Form Cuti</h5>
            <p class="mb-4">buat permintaan cuti dengan formulir di bawah ini dan kirimkan ke manajer.</p>
        </div>
        <!-- Contact Form-->
        <div class="contact-form mt-3 pb-3">
            <form action="{{ route('post-leave') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h6 class="mb-2">Dari Tanggal :</h6>
                    <input class="form-control mb-3" name="from_date" type="date" value="" required="">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Sampai Tanggal :</h6>
                    <input class="form-control mb-3" name="to_date" type="date" value="" required="">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Nama Karyawan :</h6>
                    <input class="form-control mb-3" name="nama" type="text" readonly value="{{ Auth::user()->member->nama . ' (' . Auth::user()->member->id_member . ')' }}">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Jabatan dan Divisi :</h6>
                    <input class="form-control mb-3" name="jabatans" type="text" readonly value="{{ Auth::user()->jabatan->nama . ' (' . Auth::user()->divisi->nama . ')' }}">
                </div>

                <div class="form-group">
                    <h6 class="mb-2">Kategori :</h6>
                    <select class="mb-3 form-control form-select" name="leave_category_id" required="">
                        <option value="">Pilih Kategori ...</option>
                        <option value="1">Cuti Tahunan</option>
                        <option value="2">Cuti Potong Gaji</option>
                        <option value="3">gugur kandungan (sesuai Rekomendasi dokter)</option>
                        <option value="4">Saudara / anggota keluarga dalam 1 rumah meninggal</option>
                        <option value="5">Pernikahan Anak</option>
                        <option value="6">Istri Melahirkan</option>
                        <option value="7">Istri / suami,anak,orang tua / mertua meninggal</option>
                        <option value="8">Menikah</option>
                        <option value="9">Melahirkan</option>
                        <option value="10">Anak khitan / Babtis</option>
                        <option value="11">Lain-Lain</option>
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
