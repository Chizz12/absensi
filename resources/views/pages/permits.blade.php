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
    <style>
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
        <!-- Section Heading-->
        <div class="section-heading d-flex align-items-center pt-3 justify-content-between">
            <h6>Daftar pengajuan izin karyawan</h6>
            <a class="btn btn-success" href="{{ route('add-permit') }}"><i class="lni lni-plus"></i> Buat Baru</a>
        </div>
        <!-- Notifications Area-->
        <div class="notification-area pb-2">
            <div class="list-group" id="leave-list">

            </div>
            <div class="pagination-container">
            </div>
            <div class="mt-5">
                <div class="card">
                    <a class="card-header" data-bs-toggle="collapse" href="#collapseFilter" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </a>
                    <div class="card-body collapse" id="collapseFilter">
                        <div class="row">
                            <!-- Filter by Status -->
                            <div class="col-md-6 mb-3">
                                <label for="filterStatus" class="form-label">Status</label>
                                <select class="form-select" id="filterStatus" name="status">
                                    <option value="pending" class="text-capitalize" selected>Pending</option>
                                    <option value="approved" class="text-capitalize">Disetujui</option>
                                    <option value="rejected" class="text-capitalize">Ditolak</option>
                                </select>
                            </div>
                            <!-- Filter by Date Range -->
                            <div class="col-md-6 mb-3">
                                <label for="filterDateRange" class="form-label">Rentang tanggal</label>
                                <div class="d-flex align-items-center">
                                    <input type="date" class="form-control" id="startDate" name="from_date">
                                    <span class="mx-3 text-secondary fw-bold">-</span>
                                    <input type="date" class="form-control" id="endDate" name="to_date">
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="d-grid gap-2 d-md-block text-end">
                            <button type="button" class="btn btn-success text-white outline-none border-none"
                                id="submitBtn">Terapkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alasan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Image inside the modal body -->
                    <p id="reasonText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Pastikan jQuery disertakan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Event listener for when the modal is shown
        document.addEventListener('DOMContentLoaded', function() {
            var reasonModal = document.getElementById('reasonModal');

            reasonModal.addEventListener('show.bs.modal', function(event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;

                // Get the reason from the data-reason attribute
                var reason = button.getAttribute('data-reason');

                // Find the reasonText element and set its text content
                var reasonText = document.getElementById('reasonText');
                reasonText.textContent = reason;
            });
        });

        $(document).ready(function() {
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            // Mengatur tanggal 1 di bulan ini
            const firstDayOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            $('#startDate').val(firstDayOfMonth);
            $('#endDate').val(today);
            $('#filterStatus').val('pending'); // Set default status to "Pending"

            // Function to fetch data based on filters
            function fetchLeaves() {
                const status = $('#filterStatus').val();
                const from_date = $('#startDate').val();
                const to_date = $('#endDate').val();

                $('.overlay').show();

                $.ajax({
                    url: '{{ route('permit') }}',
                    method: 'GET',
                    data: {
                        status: status,
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(response) {
                        // Clear the existing leaves
                        $('.list-group').empty();

                        $('.overlay').hide();

                        // Check if there are any leaves
                        if (response.length === 0) {
                            // Show no data message
                            $('.list-group').append(`
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px; flex-direction: column;">
                            <img src="{{ asset('assets/img/no-data.png') }}" alt="No Data Illustration" class="img-fluid mb-4" style="max-width: 400px; height:auto;">
                        </div>
                    `);
                        } else {
                            // Append the new leaves to the list
                            $.each(response, function(index, item) {
                                let disetujuiOleh = '';

                                // Menggunakan if untuk memeriksa status dan type
                                if (item.status === 'approved' && item.level === 'staff') {
                                    disetujuiOleh =
                                        `<p class="pt-3"><span class="text-success"><i class="bi bi-check2-circle"></i> Disetujui Oleh: ${item.kadiv.member.nama} (${item.kadiv.member.id_member})</span></p>`;
                                } else if (item.status === 'approved' && item.level === 'kadiv') {
                                    disetujuiOleh =
                                        `<p class="pt-3"><span class="text-success"><i class="bi bi-check2-circle"></i> Disetujui Oleh: ${item.manager.member.nama} (${item.manager.member.id_member})</span></p>`;
                                } 


                                $('.list-group').append(`
                            <div class="list-group-item d-flex py-4 mb-2" style="border: 2px solid rgb(76, 75, 75); border-radius:8px;">
                                <span class="noti-icon me-3 p-3">
                                    <img src="{{ asset('assets/img/icon-notif.png') }}" alt="Icon Nofif" width="80" height="auto">
                                </span>
                                <div class="noti-info d-flex justify-content-between align-items-center w-100">
                                    <div class="text-info">
                                        <h6 class="mb-1 text-secondary text-capitalize fw-bold fs-5">
                                            ${item.user.member.nama.split(/[\s_]+/)[0].toUpperCase()} (${item.user.member.id_member})
                                        </h6>
                                        <p class="mb-1">
                                            <span><i class="bi bi-people-fill me-2 text-secondary" style="font-size: 10px;"></i> Divisi: ${item.user.divisi.nama}</span>
                                            <span><i class="bi bi-briefcase-fill me-2 text-warning" style="font-size: 10px;"></i> Jabatan: ${item.user.jabatan.nama}</span>
                                            <span><i class="bi bi-calendar-date-fill me-2 text-success" style="font-size: 10px;"></i>
                                                ${moment(item.start_date).format('D MMM YYYY')} s/d ${moment(item.end_date).format('D MMM YYYY')}
                                            </span>
                                            <span><i class="bi bi-bookmark-fill me-2 text-info" style="font-size: 10px;"></i>
                                                ${item.category}
                                            </span>
                                            <span><i class="bi bi-alarm-fill me-2 text-danger" style="font-size: 10px;"></i>
                                                ${item.time}
                                        </p>
                                        <p class="pt-3"><span>Dibuat pada: ${moment(item.created_at).format('D MMMM YYYY')}</span></p>
                                        ${disetujuiOleh}
                                    </div>
                                    <a class="btn btn-sm btn-${item.status == 'approved' ? 'success' : item.status == 'rejected' ? 'danger' : 'warning'} text-white text-capitalize" style="margin-left: auto;" data-bs-toggle="modal" data-bs-target="#reasonModal" data-reason="${item.reason}">
                                        ${item.status}
                                    </a>
                                </div>
                            </div>
                        `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('An error occurred. Please try again.');
                        $('.overlay').hide();
                    }
                });
            }

            // Call the function to fetch data initially
            fetchLeaves();

            $('#submitBtn').on('click', function(e) {
                e.preventDefault();
                fetchLeaves(); // Call the same function when the button is clicked
            });
        });
    </script>
@endpush
