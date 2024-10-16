<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Leave;
use App\Models\Shift;
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
        // Proses data dari canvas (base64 ke file)
        if ($request->has('webcam')) {
            $imageData = $request->input('webcam');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);  // Menghapus header base64
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'webcam_' . time() . '.png';  // Membuat nama file
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

        return response()->json(['success' => 'Absen berhasil.']);
    }

    public function leave()
    {
        $leaves = Leave::where('user_id', auth()->user()->id_user)
            ->orderBy('created_at', 'desc')
            ->whereNotIn('status', ['pending'])
            ->take(10)
            ->get();

        $pendingLeaves = Leave::where('user_id', auth()->user()->id_user)
            ->where('status', 'pending')
            ->take(10)
            ->get();

        return view('pages.leave', compact('leaves', 'pendingLeaves'));
    }

    public function addLeave()
    {
        return view('pages.add-leave');
    }

    public function postLeave(Request $request)
    {
        $leave = new Leave();
        $leave->user_id = auth()->user()->id_user;
        $leave->start_date = $request->from_date;
        $leave->end_date = $request->to_date;
        $leave->reason = $request->description;
        $leave->save();

        return redirect()->route('leave')->with('success', 'Pengajuan cuti berhasil.');
    }
}
