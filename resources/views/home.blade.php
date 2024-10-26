@extends('layouts.app')

@push('header')
    <div class="logo-wrapper"><a href="https://sixghakreasi.com/demos/attd_mobile/"><img src="assets/img/tms.png"
                alt="" width="40" height="40"></a></div>
@endpush

@section('content')
    <div class="container">
        <div class="pt-3">
            <!-- Hero Slides-->
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/img/slide-1.jpeg') }}" class="d-block w-full h-full" alt="..."
                            height="300" style="border-radius:10px;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/slide-2.png') }}" class="d-block w-full h-full" alt="..."
                            height="300" style="border-radius:10px;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/slide-3.jpeg') }}" class="d-block w-full h-full" alt="..."
                            height="300" style="border-radius:10px;">
                    </div>
                </div>
                <button class="carousel-control-prev"
                    style="background: transparent; outline: none; border:none; color:red;" type="button"
                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next"
                    style="background: transparent; outline: none; border:none; color:red;" type="button"
                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Product Catagories-->
    <div class="product-catagories-wrapper py-3">
        <div class="container">
            <div class="section-heading">
                <h6>Menu</h6>
            </div>
            <div class="product-catagory-wrap">
                <div class="row g-3">
                    <!-- Single Catagory Card-->
                    <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a class="text-danger" href="{{ route('attendance') }}"><i
                                        class="lni lni-map-marker"></i><span>Absensi</span></a></div>
                        </div>
                    </div>
                    <!-- Single Catagory Card-->
                    <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a href="{{ route('leave') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="28" height="28" fill="currentColor" class="bi bi-cup mb-2"
                                        viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1 2a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v1h.5A1.5 1.5 0 0 1 16 4.5v7a1.5 1.5 0 0 1-1.5 1.5h-.55a2.5 2.5 0 0 1-2.45 2h-8A2.5 2.5 0 0 1 1 12.5V2zm13 10h.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5H14v8zM13 2H2v10.5A1.5 1.5 0 0 0 3.5 14h8a1.5 1.5 0 0 0 1.5-1.5V2z">
                                        </path>
                                    </svg><span>Cuti</span></a></div>
                        </div>
                    </div>
                    <!-- Single Catagory Card-->
                    <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a class="text-warning"
                                    href="{{ route('permit') }}"><i
                                        class="lni lni-information"></i><span>Izin</span></a></div>
                        </div>
                    </div>
                    <!-- Single Catagory Card-->
                    {{-- <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a class="text-success"
                                    href="https://sixghakreasi.com/demos/attd_mobile/overtime"><i
                                        class="lni lni-mouse"></i><span>Lembur</span></a></div>
                        </div>
                    </div>
                    <!-- Single Catagory Card-->
                    <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a class="text-danger"
                                    href="https://sixghakreasi.com/demos/attd_mobile/dlk"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                        class="bi bi-earbuds mb-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6.825 4.138c.596 2.141-.36 3.593-2.389 4.117a4.432 4.432 0 0 1-2.018.054c-.048-.01.9 2.778 1.522 4.61l.41 1.205a.52.52 0 0 1-.346.659l-.593.19a.548.548 0 0 1-.69-.34L.184 6.99c-.696-2.137.662-4.309 2.564-4.8 2.029-.523 3.402 0 4.076 1.948zm-.868 2.221c.43-.112.561-.993.292-1.969-.269-.975-.836-1.675-1.266-1.563-.43.112-.561.994-.292 1.969.269.975.836 1.675 1.266 1.563zm3.218-2.221c-.596 2.141.36 3.593 2.389 4.117a4.434 4.434 0 0 0 2.018.054c.048-.01-.9 2.778-1.522 4.61l-.41 1.205a.52.52 0 0 0 .346.659l.593.19c.289.092.6-.06.69-.34l2.536-7.643c.696-2.137-.662-4.309-2.564-4.8-2.029-.523-3.402 0-4.076 1.948zm.868 2.221c-.43-.112-.561-.993-.292-1.969.269-.975.836-1.675 1.266-1.563.43.112.561.994.292 1.969-.269.975-.836 1.675-1.266 1.563z">
                                        </path>
                                    </svg><span>Dinas Luar Kota</span></a></div>
                        </div>
                    </div>
                    <!-- Single Catagory Card-->
                    <div class="col-4">
                        <div class="card catagory-card">
                            <div class="card-body"><a class="text-info"
                                    href="https://sixghakreasi.com/demos/attd_mobile/ddk"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                        class="bi bi-brightness-high mb-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                        </path>
                                    </svg><span>Dinas Dalam Kota</span></a></div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
