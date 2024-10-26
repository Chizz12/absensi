@extends('layouts.app')

@push('header')
    <div class="back-button"><a href="{{ route('shift') }}">
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
        #canvas {
            width: 100%;
            height: auto;
            transform: scaleX(-1);
        }

        #selfieVideo {

            transform: scaleX(-1);
        }

        #map {
            width: 300;
            height: 300px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna hitam dengan transparansi */
            z-index: 1000;
            /* Pastikan overlay berada di atas semua elemen */
            display: none;
            /* Tersembunyi secara default */
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="checkout-wrapper-area py-3">

            <div class="shipping-method-choose mb-3">
                <div class="card shipping-method-choose-title-card bg-white mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-center align-items-center gap-3">
                        <button type="button" id="openCam" class="btn btn-warning w-100 w-md-50 open-cam"><i
                                class="bi bi-camera-fill me-2 fs-5 text-dark"></i>Buka Kamera</button>

                    </div>
                </div>
                <div class="card shipping-method-choose-card">
                    <div class="card-body text-center">
                        <div class="mb-1" id="photoholder"><img src="{{ asset('assets/img/camera.png') }}"
                                alt="Take a Picture" class="img-fluid" style="max-width: 50%; height: auto;"
                                id="img-ilustrator"></div>
                        <canvas class="d-block mb-4" id="canvas" style="display: none;"></canvas>
                    </div>
                </div>
            </div>

            <div class="billing-information-card mb-3">
                <div class="card billing-information-title-card bg-danger">
                    <div class="card-body">
                        <h6 class="text-center mb-0 text-white">Informasi Lokasi</h6>
                    </div>
                </div>
                <div class="card user-data-card">
                    <div class="card-body">
                        <div id="map" style="display: none;"></div>
                    </div>
                </div>
            </div>



            <form action="{{ route('post-attendance') }}" method="POST" id="absenForm">
                @csrf
                <div class="mb-3 d-none">
                    <label for="Latitude">Latitude</label>
                    <input class="form-control" type="text" id="latitude" name="latitude">
                </div>

                <div class="mb-3 d-none">
                    <label for="Longitude">Longitude</label>
                    <input class="form-control" type="text" id="longitude" name="longitude">
                </div>

                <div class="mb-3 d-none">
                    <label for="shift">Shift</label>
                    <input class="form-control" type="text" id="shift" name="shift" value="{{ $shift->id_shift }}">
                </div>

                <div class="mb-3 d-none">
                    <label for="type">Type</label>
                    <input class="form-control" type="text" id="type" name="type" value="{{ $type }}">
                </div>

                <button type="button" class="btn btn-success btn-lg w-100" id="submitBtn"><i
                        class="bi bi-send-fill fs-5 mr-2"></i> ABSEN</button>
            </form>
        </div>
    </div>
    <div class="modal show" id="selfieModal" tabindex="-1" aria-labelledby="selfieModalLabel" data-bs-backdrop="static"
        aria-modal="true" role="dialog" style="padding-right: 17px; display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selfieModalLabel">Take a Selfie</h5>
                </div>
                <div class="modal-body text-center">
                    <video id="selfieVideo" width="100%" height="auto" autoplay="" class="video"></video>
                    <br><br><br>
                    <button id="captureButton" class="btn btn-lg btn-success mt-3 mb-3">Jepret</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const video = document.querySelector("#selfieVideo");
        const inputLatitude = document.querySelector("#latitude");
        const inputLongitude = document.querySelector("#longitude");
        const btnCapture = document.querySelector("#captureButton");
        const canvas = document.getElementById('canvas');
        const modal = document.getElementById('selfieModal');
        const photoHolder = document.getElementById('photoholder');
        // const ktp = document.getElementById('ktp');
        // const btnRepeat = document.getElementById("btnRepeat");
        const coverMap = document.getElementById("map");

        function initializeWebcam() {
            const constraints = {
                audio: false,
                video: {
                    facingMode: "user"
                }
            };

            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(function(mediaStream) {
                        window.stream = mediaStream;
                        video.srcObject = mediaStream;
                        video.onloadedmetadata = function(e) {
                            video.play();
                        };
                    })
                    .catch(function(err0r) {
                        console.log("Webcam Tidak terbaca");
                    });
            }
        }

        function captureImage() {
            // hide modal
            modal.style.display = 'none';

            // hide photo holder
            photoHolder.style.display = 'none';

            // show canvas
            canvas.style.display = 'block';

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.style.display = 'block';
            document.querySelector('.video').style.display = 'none';

            stop();
        }

        function stop() {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;
            }
        }

        // Event listener untuk membuka popup
        $('.open-cam').on('click', function() {
            initializeWebcam();
            // open modal
            modal.style.display = 'block';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    inputLatitude.value = latitude;
                    inputLongitude.value = longitude;
                    showMap(latitude, longitude);
                }, function(error) {
                    console.log("Lokasi tidak bisa diakses: ", error);
                });
            } else {
                console.log("Geolocation tidak didukung oleh browser ini.");
            }
        });

        // Event listener untuk capture gambar
        btnCapture.addEventListener('click', captureImage);

        // Fungsi untuk menampilkan peta dengan Leaflet
        function showMap(lat, lon) {
            // hide cover map
            coverMap.style.display = 'block';

            // Inisialisasi peta
            const map = L.map('map').setView([lat, lon], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Tambahkan marker pada koordinat pengguna
            const marker = L.marker([lat, lon]).addTo(map)
                .bindPopup('Lokasi Anda').openPopup();
        }

        $(document).ready(function() {
            $('#submitBtn').click(function(event) {
                $('.overlay').show();

                var lat = $('#latitude').val();
                var lon = $('#longitude').val();
                var shift = $('#shift').val();
                var type = $('#type').val();
                // Ambil nilai lainnya sesuai kebutuhan

                // Jika validasi sukses, siapkan FormData untuk submit
                var formData = new FormData();

                formData.append('latitude', lat);
                formData.append('longitude', lon);
                formData.append('shift', shift);
                formData.append('type', type);
                // Tambahkan token CSRF
                formData.append('_token', '{{ csrf_token() }}');

                // Ambil gambar dari canvas sebagai bukti selfie
                if (canvas) {
                    var webcamDataURL = canvas.toDataURL(
                        'image/png'); // Mengonversi gambar dari canvas ke format data URL (base64)
                    formData.append('webcam', webcamDataURL); // Tambahkan ke FormData

                    // Fungsi untuk submit form menggunakan AJAX
                    $.ajax({
                        url: $('#absenForm').attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false, // Agar tidak memproses data secara otomatis
                        contentType: false, // Agar tidak mengubah tipe konten
                        success: function(response) {
                            if (response.success) {
                                $('.overlay').hide();

                                // Tampilkan alert custom
                                const alertHtml = `
                                    <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true"
                                        data-bs-delay="5000" data-bs-autohide="true">
                                        <div class="toast-body">
                                            <div class="content d-flex align-items-center mb-2">
                                                <img src="/assets/img/tms.png" alt="">
                                                <h6 class="mb-0">INFO</h6>
                                                <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <span class="mb-0 d-block">${response.message}</span>
                                        </div>
                                    </div>
                                `;

                                // Masukkan alert ke dalam halaman
                                $('body').append(alertHtml);

                                // Memperlihatkan toast Bootstrap
                                var toastEl = document.querySelector('.toast');
                                var toast = new bootstrap.Toast(toastEl);
                                toast.show();
                                $('.overlay').show();

                                // Redirect setelah alert muncul
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 2000); // Redirect setelah 2 detik (sesuai delay toast)
                            }
                        },
                        error: function(xhr) {
                            $('.overlay').hide();


                            // Cek apakah respons memiliki pesan kesalahan
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                console.log(xhr.responseJSON.message);
                            } else {
                                console.log('Terjadi kesalahan saat mengirim data.');
                            }
                        }
                    });
                } else {
                    console.log('Canvas tidak ditemukan');
                }

            });

        });
    </script>
@endpush
