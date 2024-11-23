<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Leave;
use App\Models\Shift;
use App\Models\Member;
use App\Models\Permit;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function attendance()
    {
        $attendances = Absen::where('user_id', auth()->user()->id_user)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.attendance', compact('attendances'));
    }

    public function shift()
    {
        $shifts = Shift::all();

        return view('pages.shift', compact('shifts'));
    }

    public function addAttendance($idShift, $type)
    {
        $shift = Shift::find($idShift);

        // Mencari data absen hari ini dengan user_id
        $absenToday = Absen::where('user_id', auth()->user()->id_user)
            ->whereDate('created_at', now())
            ->first();

        // Jika sudah ada absen hari ini dengan shift yang berbeda
        if ($absenToday && $absenToday->shift_id != $idShift) {
            return redirect()->route('shift')->with('info', 'Anda tidak boleh absen di shift yang berbeda pada hari yang sama.');
        }

        // Mencari data absen dengan type dan user_id
        $isAbsen = Absen::where('type', $type)
            ->where('user_id', auth()->user()->id_user)
            ->whereDate('created_at', now())
            ->first();

        // Menentukan pesan berdasarkan tipe absen
        $message = $type == 'in' ? 'Masuk' : 'Pulang';

        // Jika sudah ada absen untuk tipe tersebut (in/out)
        if ($isAbsen) {
            return redirect()->route('shift')->with('info', 'Anda sudah absen ' . $message . ' hari ini.');
        }

        return view('pages.add-attendance', compact('shift', 'type'));
    }


    public function postAttendance(Request $request)
    {
        $member = Member::find(auth()->user()->member->id_member);
        // Proses data dari canvas (base64 ke file)
        if ($request->has('webcam')) {
            $imageData = $request->input('webcam');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);  // Menghapus header base64
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'webcam_' . $member->id_member . '-' . $request->type . '-' . now()->format('d-M-Y') . '.png';
            File::put(public_path('webcam/') . $imageName, base64_decode($imageData)); // Menyimpan file gambar

        }

        $shift = Shift::find($request->shift);

        $status = 'on_time'; // Default status

        if ($request->type == 'in') {

            // Mendapatkan waktu absen saat ini
            $currentTime = now(); // Menggunakan waktu saat ini

            // Mendapatkan waktu shift dan membandingkan menitnya
            $shiftTime = Carbon::parse($shift->waktu); // Mengubah waktu shift ke Carbon untuk manipulasi
            $currentMinute = $currentTime->format('H:i'); // Ambil jam dan menit waktu sekarang
            $shiftMinute = $shiftTime->format('H:i'); // Ambil jam dan menit dari waktu shift

            // Logika untuk menentukan status
            if ($currentMinute > $shiftMinute) {
                $status = 'late'; // Jika waktu absen lebih dari waktu shift (menit berbeda)
            } else {
                $status = 'on_time'; // Jika menit sama atau lebih awal
            }
        }


        $absen = new Absen();
        $absen->user_id = auth()->user()->id_user;
        $absen->shift_id = $request->shift;
        $absen->type = $request->type;
        $absen->foto = isset($imageName) ? $imageName : null;  // Menyimpan nama file gambar
        $absen->latitude = $request->latitude;
        $absen->longitude = $request->longitude;
        $absen->status = $status;
        $absen->save();

        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil.',
            'redirect_url' => route('attendance') // Mengirim URL untuk redirect
        ]);
    }

    public function leave(Request $request)
    {
        if ($request->ajax()) {
            $query = Leave::where('user_id', auth()->user()->id_user)
                ->with(['user.member', 'user.jabatan', 'user.divisi', 'kadiv.member', 'manager.member']);

            // Filter berdasarkan tanggal mulai
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($request->from_date)->format('Y-m-d'));
            }

            // Filter berdasarkan tanggal akhir
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($request->to_date)->format('Y-m-d 23:59:59'));
            }

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Ambil data leaves sesuai filter yang diterapkan
            $leaves = $query->orderBy('created_at', 'desc')->take(10)->get();

            // Kembalikan data sebagai JSON
            return response()->json($leaves);
        }

        return view('pages.leave');
    }

    public function addLeave()
    {
        $jumlahCuti = Leave::where('user_id', auth()->user()->id_user)
            ->whereYear('created_at', now()->format('Y'))
            ->where('status', 'approved')
            ->sum('day');
        
        $sisaCuti = 12 - $jumlahCuti;

        return view('pages.add-leave', compact('sisaCuti'));
    }

    public function postLeave(Request $request)
    {
        $jumlahCuti = Leave::where('user_id', auth()->user()->id_user)
            ->whereYear('created_at', now()->format('Y'))
            ->where('status', 'approved')
            ->sum('day');
        
        $day = Carbon::parse($request->from_date)->startOfDay()->diffInDays(Carbon::parse($request->to_date)->startOfDay()) + 1;

        $jumlahCuti += $day;

        if ($jumlahCuti > 12) {
            return redirect()->route('leave')->with('info', 'Sisa cuti Anda sudah habis.');
        }

        $leave = new Leave();
        $leave->user_id = auth()->user()->id_user;
        $leave->start_date = $request->from_date;
        $leave->end_date = $request->to_date;
        $leave->day = $day;
        $leave->reason = $request->description;
        if (auth()->user()->jabatan_id >= 2 && auth()->user()->jabatan_id <= 9) {
            $leave->approved_by_kadiv = auth()->user()->id_user;
            $leave->approved_by_manager = auth()->user()->id_user;
            $leave->status = 'approved';
        }
        $leave->save();

        return redirect()->route('leave')->with('info', 'Pengajuan cuti berhasil.');
    }

    public function permit(Request $request)
    {
        if ($request->ajax()) {
            $query = Permit::where('user_id', auth()->user()->id_user)
                ->with(['user.member', 'user.jabatan', 'user.divisi', 'kadiv.member', 'manager.member']);

            // Filter berdasarkan tanggal mulai
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($request->from_date)->format('Y-m-d'));
            }

            // Filter berdasarkan tanggal akhir
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($request->to_date)->format('Y-m-d 23:59:59'));
            }

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Ambil data leaves sesuai filter yang diterapkan
            $permits = $query->orderBy('created_at', 'desc')->take(10)->get();

            // Kembalikan data sebagai JSON
            return response()->json($permits);
        }

        return view('pages.permits');
    }

    public function addPermit()
    {
        return view('pages.add-permit');
    }

    public function postPermit(Request $request)
    {
        $permit = new Permit();
        $permit->user_id = auth()->user()->id_user;
        $permit->category = $request->category;
        $permit->start_date = $request->from_date;
        $permit->end_date = $request->to_date;
        $permit->time_in = $request->time_in;
        $permit->time_out = $request->time_out;
        $permit->reason = $request->description;

        // Kondisi untuk menentukan level berdasarkan jabatan_id
        if (auth()->user()->jabatan_id >= 2 && auth()->user()->jabatan_id <= 18) {
            if (auth()->user()->jabatan_id >= 2 && auth()->user()->jabatan_id <= 9) {
                $permit->approved_by_kadiv = auth()->user()->id_user;
                $permit->approved_by_manager = auth()->user()->id_user;
                $permit->status = 'approved';
            }
            $permit->level = 'kadiv';
        } else {
            $permit->level = 'staff';
        }

        $permit->save();

        return redirect()->route('permit')->with('info', 'Pengajuan izin berhasil.');
    }
}
