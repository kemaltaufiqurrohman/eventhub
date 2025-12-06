<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Attendance;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    // ===============================
    // PANITIA SECTION
    // ===============================

    public function index()
    {
        $events = Event::where('organizer_id', auth()->id())->get();
        return view('panitia.events.index', compact('events'));
    }

    public function create()
    {
        return view('panitia.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'quota' => 'required|integer|min:1',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'quota' => $request->quota,
            'organizer_id' => auth()->id(),
            'status' => 'Pending',
            'status_event' => 'Berlangsung',
        ]);

        return redirect()->route('panitia.events.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);
        return view('panitia.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'quota' => 'required|integer|min:1',
        ]);

        $event->update($request->only(['title','description','date','location','quota']));

        return redirect()->route('panitia.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);
        $event->delete();
        return redirect()->route('panitia.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }


    // ===============================
    // QR CODE
    // ===============================

    public function qrPage(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $payload = json_encode([
            'type' => 'attendance',
            'event_id' => $event->id,
        ]);

        $file = "qr_codes/event_{$event->id}.svg";
        Storage::disk('public')->put(
            $file,
            QrCode::format('svg')->size(300)->generate($payload)
        );

        return view('panitia.qr-page', [
            'event' => $event,
            'qrPath' => $file,
        ]);
    }


    // ===============================
    // TEMPLATE SERTIFIKAT
    // ===============================

    public function uploadCertificateTemplate(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $request->validate([
            'certificate_template' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('certificate_template')
            ->store('certificates/templates', 'public');

        $event->update(['certificate_template' => $path]);

        return redirect()
            ->route('panitia.events.previewCertificate', $event->id)
            ->with('success', 'Template sertifikat berhasil diupload!');
    }

    public function previewCertificate(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $size = null;

        if ($event->certificate_template) {
            $path = storage_path('app/public/' . $event->certificate_template);
            if (file_exists($path)) {
                $size = getimagesize($path);
            }
        }

        return view('panitia.events.certificate-preview', [
            'event' => $event,
            'imgWidth' => $size[0] ?? null,
            'imgHeight' => $size[1] ?? null,
        ]);
    }

    public function manageTemplate(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);
        return view('panitia.events.manage-template', compact('event'));
    }


    public function saveTemplateSettings(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $request->validate([
            'name_x' => 'required|integer|min:0',
            'name_y' => 'required|integer|min:0',
            'name_font_size' => 'required|integer|min:8|max:120',
            'name_color' => 'required|string',
        ]);

        $event->update($request->only(['name_x','name_y','name_font_size','name_color']));

        return back()->with('success', 'Pengaturan template disimpan.');
    }

    public function saveTextSettings(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $request->validate([
            'x' => 'required|integer',
            'y' => 'required|integer',
            'text_size' => 'required|integer|min:10|max:200',
            'text_color' => 'required|string',
        ]);

        $event->update([
            'text_x' => $request->x,
            'text_y' => $request->y,
            'text_size' => $request->text_size,
            'text_color' => $request->text_color,
        ]);

        return back()->with('success', 'Pengaturan teks disimpan!');
    }


    public function generateCertificates($id)
    {
        $event = Event::findOrFail($id);
        if ($event->organizer_id !== auth()->id()) abort(403);

        $regs = Registration::where('event_id', $id)->with('user')->get();

        $generated = [];

        foreach ($regs as $reg) {
            $pdf = Pdf::loadView('panitia.events.certificate-pdf', [
                'event' => $event,
                'name' => $reg->user->name,
                'settings' => [
                    'x' => $event->text_x,
                    'y' => $event->text_y,
                    'font_size' => $event->text_size,
                    'color' => $event->text_color,
                ]
            ]);

            $saveFolder = public_path("certificates/generated/{$event->id}");
            if (!is_dir($saveFolder)) mkdir($saveFolder, 0777, true);

            $file = 'sertifikat_' . str_replace(' ', '_', $reg->user->name) . '.pdf';
            $path = $saveFolder . '/' . $file;

            $pdf->setPaper('a4', 'landscape')->save($path);

            $generated[] = "certificates/generated/{$event->id}/{$file}";
        }

        return back()->with('success', 'Sertifikat berhasil digenerate!')
                     ->with('generated_files', $generated);
    }


    // ===============================
    // PESERTA
    // ===============================

    public function participants(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) abort(403);

        $participants = Registration::where('event_id', $event->id)
            ->with('user')
            ->get();

        return view('panitia.participants', compact('event', 'participants'));
    }

    public function markAttendance(Registration $reg)
    {
        if ($reg->event->organizer_id !== auth()->id()) abort(403);

        $reg->update(['status_absen' => 'Hadir']);

        return back()->with('success', 'Peserta ditandai hadir.');
    }


    // ===============================
    // ADMIN SECTION
    // ===============================

    public function adminIndex()
    {
        $events = Event::with('organizer')->get();
        return view('admin.events.index', compact('events'));
    }

    public function updateStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak',
        ]);

        $event->update(['status' => $request->status]);

        return back()->with('success', 'Status event berhasil diperbarui!');
    }


    public function adminShow(Event $event)
    {
        $event->load(['organizer','participants.user']);
        return view('admin.event-detail', compact('event'));
    }


    // ===============================
    // MAHASISWA SECTION
    // ===============================

    public function register(Request $request, Event $event)
    {
        if (now()->isAfter(Carbon::parse($event->date))) {
            return back()->with('error', 'Event sudah berakhir.');
        }

        $count = Registration::where('event_id', $event->id)->count();
        if ($count >= $event->quota) {
            return back()->with('error', 'Kuota penuh.');
        }

        $exists = Registration::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah terdaftar.');
        }

        Registration::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('mahasiswa.events.show', $event->id)
            ->with('success', 'Berhasil mendaftar!');
    }


    public function show(Event $event)
    {
        $event->load(['organizer', 'registrations.user']);

        $already = Registration::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->exists();

        $expired = now()->isAfter(Carbon::parse($event->date));

        return view('mahasiswa.events.show', compact('event','already','expired'));
    }


    public function downloadCertificate($id)
    {
        $event = Event::findOrFail($id);

        // cek absen
        $att = Attendance::where('event_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$att) abort(403, 'Anda belum absen.');

        // lokasi sesuai generate
        $folder = public_path("certificates/generated/{$event->id}");

        $file = glob($folder.'/*.pdf');
        if (!$file) abort(404, 'Sertifikat tidak ditemukan.');

        return response()->download($file[0]);
    }

}
