<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Attendance;


class AdminController extends Controller
{
    public function index()
    {
        $events = Event::withCount(['participants', 'attendances'])->get();

        $stats = [
            'total_events' => $events->count(),
            'approved_events' => $events->where('status', 'Disetujui')->count(),
            'pending_events' => $events->where('status', 'Pending')->count(),
        ];

        return view('admin.dashboard', compact('events', 'stats'));
    }

    public function updateStatus(Request $request, Event $event)
    {
        $event->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status event berhasil diperbarui!');
    }

    public function monitor(Event $event)
    {
        $event->loadCount(['participants', 'attendances']);

        return view('admin.monitor', [
            'event' => $event
        ]);
    }

    public function setStatus(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        // Hanya bisa ubah kalau status masih pending
        if ($event->status !== 'Pending') {
            return back()->with('error', 'Status tidak dapat diubah lagi.');
        }

        $event->status = $request->status;
        $event->save();

        return back()->with('success', 'Status event berhasil diubah.');
    }

    public function detail($id)
    {
        $event = Event::with(['organizer', 'participants', 'attendances'])
                        ->findOrFail($id);

        return view('admin.detail-event', compact('event'));
    }


}
