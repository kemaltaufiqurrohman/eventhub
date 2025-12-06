<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;

class PanitiaController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Ambil semua event yang dibuat oleh panitia ini
        $events = Event::where('organizer_id', $userId)->get();

        // Hitung statistik
        $totalEvents = $events->count();
        $totalParticipants = Registration::whereIn('event_id', $events->pluck('id'))->count();

        // Ambil event terbaru (untuk upload template sertifikat)
        $latestEvent = Event::where('organizer_id', $userId)->latest()->first();

        // Kirim semua data ke dashboard
        return view('panitia.dashboard', compact(
            'events',
            'totalEvents',
            'totalParticipants',
            'latestEvent'
        ));
    }
}
