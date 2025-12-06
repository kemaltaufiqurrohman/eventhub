<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Attendance;

class MahasiswaController extends Controller
{
    /**
     * Dashboard Mahasiswa
     */
    public function index()
    {
        $events = Event::where('status', 'Disetujui')->orderBy('date', 'asc')->get();

        $ongoing = Event::whereHas('registrations', fn($q) =>
            $q->where('user_id', auth()->id())
        )->where('status_event', 'Berlangsung')->get();

        $finished = Event::whereHas('registrations', fn($q) =>
            $q->where('user_id', auth()->id())
        )->where('status_event', 'Selesai')->get();

        return view('mahasiswa.dashboard', [
            'events' => $events,
            'ongoingEvents' => $ongoing,
            'finishedEvents' => $finished,
            'totalEvents' => $events->count(),
            'joinedEvents' => $ongoing->count() + $finished->count(),
            'availableCertificates' => $finished->count()
        ]);
    }

    /**
     * Halaman daftar event
     */
    public function events()
    {
        return view('mahasiswa.events.index', [
            'events' => Event::where('status', 'Disetujui')->orderBy('date')->get(),
            'ongoingEvents' => Event::where('status', 'Disetujui')->where('date', '>=', now())->get(),
            'finishedEvents' => Event::where('status', 'Disetujui')->where('date', '<', now())->get(),
        ]);
    }

    /**
     * Detail event mahasiswa
     * route: mahasiswa.events.show
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        // Ambil data registrasi mahasiswa untuk event ini
        $registration = Registration::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->first();

        // Jika sudah absen
        $attendance = null;
        if ($registration && $registration->attendance_status === 'hadir') {
            $attendance = true;
            $event->status_event = 'Selesai';
        }

        return view('mahasiswa.events.show', [
            'event' => $event,
            'attendance' => $attendance,
            'registration' => $registration
        ]);
    }

    /**
     * Alias agar route showEvent tidak error
     */
    public function showEvent($id)
    {
        $event = Event::findOrFail($id);

        $attendance = Attendance::where('event_id', $event->id)
                        ->where('user_id', auth()->id())
                        ->first();

        // jika sudah scan → status_event otomatis selesai
        if ($attendance) {
            $event->status_event = 'Selesai';
        }

        return view('mahasiswa.events.show', [
            'event' => $event,
            'attendance' => $attendance,
        ]);
    }


    /**
     * Halaman Scan QR
     */
    public function scanQr()
    {
        return view('mahasiswa.scan-qr');
    }

    /**
     * Submit hasil scan QR absensi
     */
    public function submitScan(Request $request)
    {
        $eventId = $request->event_id;

        Attendance::updateOrCreate(
            [
                'event_id' => $eventId,
                'user_id' => auth()->id(),
            ],
            [
                'status' => 'Hadir',
                'scan_time' => now(),
            ]
        );

        return redirect()->route('mahasiswa.events.show', $eventId)
                        ->with('success', 'Scan berhasil!');
    }

}

if (!function_exists('schema')) {
    function schema()
    {
        return app()->make(\Illuminate\Database\Schema\Builder::class) ?? \Illuminate\Support\Facades\Schema::class;
    }
}
