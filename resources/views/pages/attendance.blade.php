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

@push('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #foto {
            transform: scaleX(-1);
        }

        #map {
            width: 100%;
            height: 300px;
        }
    </style>
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
                @forelse ($attendances as $item)
                    <div class="list-group-item d-flex flex-column flex-md-row align-items-center p-3 mb-3 rounded">
                        <img src="{{ asset('webcam/' . $item->foto) }}" alt="Foto Karyawan" class="rounded mb-3 mb-md-0"
                            style="width: 200px; height: auto; object-fit: cover; margin-right: 15px; background-repeat: no-repeat;"
                            id="foto">
                        <div class="noti-info flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 fw-bold">
                                    {{ ucwords(strtoupper(preg_split('/[\s_]+/', $item->user->member->nama)[0])) }}
                                    {{ ' (' . $item->user->member->id_member . ')' }}
                                </h5>
                                <span class="mb-2 text-secondary" style="font-size: 12px;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            <h4 class="mb-3">
                                @if ($item->status == 'on_time')
                                    <span class="text-success text-capitalize fw-bold" style="font-size: 15px;">
                                        <i class="lni lni-calendar-alt"></i>
                                        Tepat Waktu
                                    </span>
                                @else
                                    <span class="text-danger text-capitalize fw-bold" style="font-size: 15px;">
                                        <i class="lni lni-calendar-alt"></i>
                                        Terlambat
                                    </span>
                                @endif
                            </h4>
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                <div class="col">
                                    <p class="mb-0 responsive-text">
                                        <span class="mb-2">
                                            <i class="lni lni-alarm-clock text-primary me-1"></i>
                                            Absen
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('H:i A') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="mb-0 responsive-text">
                                        <span class="mb-2 text-capitalize">
                                            <i class="lni lni-paperclip text-warning" style="font-size: 14px;"></i>
                                            @if ($item->type == 'in')
                                                Absen Masuk {{ $item->shift->nama }}
                                            @else
                                                Absen Keluar {{ $item->shift->nama }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="mb-0 responsive-text">
                                        <a href="#" class="icn" id="mdl" data-bs-toggle="modal"
                                            data-bs-target="#locationModal" data-lat="{{ $item->latitude }}"
                                            data-lon="{{ $item->longitude }}">
                                            <span class="mb-2 text-secondary">
                                                <i class="bi bi-geo-alt text-danger me-1"></i>Lihat Lokasi
                                            </span>
                                        </a>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="mb-0 responsive-text">
                                        <a href="#" class="icn-ic" data-bs-toggle="modal"
                                            data-bs-target="#pictureModal" data-src-img="{{ $item->foto }}">
                                            <span class="mb-2 text-secondary">
                                                <i class="bi bi-person-workspace me-1" style="color:#00b894"></i>Lihat Foto
                                            </span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center align-items-center"
                        style="min-height: 400px; flex-direction: column;">
                        <img src="{{ asset('assets/img/no-data.png') }}" alt="No Data Illustration" class="img-fluid mb-4"
                            style="max-width: 500px; height:auto;">
                    </div>
                @endforelse

            </div>
            <div class="pagination-container">
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Modal untuk foto -->
    <div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Foto Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Image inside the modal body -->
                    <img alt="Foto Karyawan" class="img-fluid rounded w-full h-full" id="img-karyawan"
                        style="transform: scaleX(-1);">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk lokasi -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lokasi Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Menampilkan modal lokasi dari leaflet -->
                    <div id="map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let map = null;
            const locationModal = document.getElementById('locationModal');
            const btnPicture = document.getElementById('pictureModal');
            document.getElementById('img-karyawan').style.display = 'none';

            locationModal.addEventListener('show.bs.modal', function(event) {
                // Ambil button yang memicu modal
                const button = event.relatedTarget;
                // Ambil data-lat dan data-lon dari button
                const lat = parseFloat(button.getAttribute('data-lat')); // Ambil lat dan konversi ke float
                const lon = parseFloat(button.getAttribute('data-lon')); // Ambil lon dan konversi ke float

                // Panggil fungsi untuk menampilkan peta
                showMap(lat, lon);
            });

            btnPicture.addEventListener('show.bs.modal', function(event) {
                const buttonShowImage = event.relatedTarget;
                const srcImage = buttonShowImage.getAttribute('data-src-img');

                // Jalankan function untuk menampilkan gambar
                showImage(srcImage);
            });

            // Hapus peta ketika modal ditutup
            locationModal.addEventListener('hide.bs.modal', function() {
                if (map !== null) {
                    map.remove(); // Hapus peta saat modal ditutup
                    map = null; // Reset variabel map
                }
            });

            function showMap(lat, lon) {
                const mapDiv = document.getElementById("map");
                mapDiv.style.display = 'block';
                mapDiv.style.borderRadius = '10px';

                // Inisialisasi peta
                map = L.map(mapDiv).setView([lat, lon], 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                const popupOptions = {
                    offset: L.point(-30, 0) // Geser ke kiri dengan nilai negatif pada sumbu X
                };

                // Tambahkan marker pada lokasi karyawan
                const marker = L.marker([lat, lon]).addTo(map)
                    .bindPopup('Lokasi Anda', popupOptions).openPopup();

                // Perbarui ukuran peta setelah modal sepenuhnya terbuka
                setTimeout(function() {
                    map.invalidateSize();
                }, 500); // Memberi sedikit delay agar layout modal benar-benar siap
            }

            function showImage(src) {
                // Cari elemen gambar berdasarkan id
                const imgKaryawan = document.getElementById('img-karyawan');

                // Set nilai atribut src dari elemen gambar dengan nilai dari srcImage yang di tangkap src

                imgKaryawan.setAttribute('src', `webcam/${src}`);
                imgKaryawan.style.borderRadius = '10px';
                imgKaryawan.style.display = 'block';
            }
        });
    </script>
@endpush
