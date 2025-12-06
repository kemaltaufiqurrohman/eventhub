<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * 📋 Menampilkan halaman daftar / kelola template sertifikat
     */
    public function index()
    {
        // Ambil semua event yang sudah dibuat oleh panitia
        $events = Event::where('organizer_id', auth()->id())->get();

        return view('panitia.certificates.index', compact('events'));
    }

    /**
     * 🧾 Menyimpan template sertifikat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'certificate_template' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Simpan file ke storage
        $path = $request->file('certificate_template')->store('certificates/templates', 'public');

        // Update data event dengan template baru
        $event->update([
            'certificate_template' => $path,
        ]);

        return back()->with('success', 'Template sertifikat berhasil disimpan dan diperbarui.');
    }

    /**
     * 🖼️ Preview template sertifikat (ditampilkan di tab baru)
     */
    public function preview($eventId)
    {
        $event = Event::findOrFail($eventId);

        if (!$event->certificate_template) {
            return redirect()->back()->with('error', 'Belum ada template sertifikat yang diunggah.');
        }

        // Ambil URL file dari storage/public
        $url = Storage::url($event->certificate_template);

        // Tampilkan view preview
        return view('panitia.certificates.preview', compact('event', 'url'));
    }
}
