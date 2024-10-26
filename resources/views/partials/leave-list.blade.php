@forelse ($leaves as $item)
    <div class="list-group-item d-flex py-4 mb-2" style="border: 2px solid rgb(76, 75, 75); border-radius:8px;">
        <!-- Icon Notifikasi -->
        <span class="noti-icon me-3 p-3">
            <img src="{{ asset('assets/img/icon-notif.png') }}" alt="Icon Nofif" width="80" height="auto">
        </span>
        <!-- Informasi -->
        <div class="noti-info d-flex justify-content-between align-items-center w-100">
            <div class="text-info">
                <h6 class="mb-1 text-secondary text-capitalize fw-bold fs-5">
                    {{ ucwords(strtoupper(preg_split('/[\s_]+/', $item->user->member->nama)[0])) }}
                    {{ ' (' . $item->user->member->id_member . ')' }}
                </h6>
                <p class="mb-1">
                    <span>
                        <i class="bi bi-people-fill me-2 text-secondary" style="font-size: 10px;"></i>
                        Divisi : ITS
                    </span>
                    <span>
                        <i class="bi bi-briefcase-fill me-2 text-warning" style="font-size: 10px;"></i>
                        Jabatan : Staff IT
                    </span>
                    <span>
                        <i class="bi bi-calendar-date-fill me-2 text-success" style="font-size: 10px;"></i>
                        {{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d M Y') }} s/d
                        {{ \Carbon\Carbon::parse($item->end_date)->translatedFormat('d M Y') }}
                    </span>
                </p>
                <p class="pt-3">
                    <span>
                        Dibuat pada:{{ \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') }}
                    </span>
                </p>
            </div>
            @if ($item->status == 'approved')
                <a class="btn btn-sm btn-success text-white text-capitalize" style="margin-left: auto;"
                    data-bs-toggle="modal" data-bs-target="#reasonModal" data-reason="{{ $item->reason }}">
                    {{ $item->status }}
                </a>
            @elseif($item->status == 'rejected')
                <a class="btn btn-sm btn-danger text-white text-capitalize" style="margin-left: auto;"
                    data-bs-toggle="modal" data-bs-target="#reasonModal" data-reason="{{ $item->reason }}">
                    {{ $item->status }}
                </a>
            @else
                <a class="btn btn-sm btn-warning text-white text-capitalize" style="margin-left: auto;"
                    data-bs-toggle="modal" data-bs-target="#reasonModal" data-reason="{{ $item->reason }}">
                    {{ $item->status }}
                </a>
            @endif
        </div>
    </div>
@empty
    <div class="d-flex justify-content-center align-items-center" style="min-height: 400px; flex-direction: column;">
        <img src="{{ asset('assets/img/no-data.png') }}" alt="No Data Illustration" class="img-fluid mb-4"
            style="max-width: 500px; height:auto;">
    </div>
@endforelse
