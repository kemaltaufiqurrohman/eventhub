<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Mahasiswa
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔔 Notifikasi --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    ✔ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                    ✖ {{ session('error') }}
                </div>
            @endif

            <h1 class="text-3xl font-bold mb-3">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 mb-6">Selamat datang di Dashboard Mahasiswa EventHub.</p>

            {{-- 📷 Tombol Scan QR Absensi --}}
            <div class="mb-8">
                <a href="{{ route('mahasiswa.qr.scan') }}"
                   class="px-5 py-3 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700">
                    📷 Scan QR Absensi
                </a>
            </div>

            {{-- 📌 Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <div class="bg-blue-100 p-4 rounded shadow">
                    <h3 class="font-bold text-lg">Total Event</h3>
                    <p class="text-3xl font-semibold">{{ $events->count() }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded shadow">
                    <h3 class="font-bold text-lg">Event Diikuti</h3>
                    <p class="text-3xl font-semibold">{{ $joinedEvents }}</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded shadow">
                    <h3 class="font-bold text-lg">Sertifikat Tersedia</h3>
                    <p class="text-3xl font-semibold">{{ $availableCertificates }}</p>
                </div>
            </div>

            {{-- 🎫 Daftar Event --}}
            <h2 class="text-2xl font-bold mb-4">Daftar Event</h2>

            <table class="w-full text-left border-collapse mt-3 shadow rounded overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-3 border">Judul</th>
                        <th class="py-2 px-3 border">Tanggal</th>
                        <th class="py-2 px-3 border">Lokasi</th>
                        <th class="py-2 px-3 border text-center">Status / Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($events as $event)
                        @php
                            $today = \Carbon\Carbon::today();
                            $eventDate = \Carbon\Carbon::parse($event->date);

                            // Status badge
                            $registered = \App\Models\Registration::where('event_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->exists();
                            $attendance = \App\Models\Registration::where('event_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->where('attendance_status', 'hadir')
                                ->first();


                            if ($eventDate->isPast()) {
                                $statusText = $registered
                                    ? ($attendance ? 'Selesai' : 'Tidak Hadir')
                                    : 'Event Berakhir';
                                $statusBadge = $registered
                                    ? ($attendance ? 'bg-green-600' : 'bg-red-600')
                                    : 'bg-gray-500';
                            } else {
                                $statusText = $registered ? 'Terdaftar' : 'Berlangsung';
                                $statusBadge = $registered ? 'bg-green-600' : 'bg-yellow-600';
                            }
                        @endphp

                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">{{ $event->title }}</td>
                            <td class="py-2 px-3">{{ $event->date }}</td>
                            <td class="py-2 px-3">{{ $event->location }}</td>
                            <td class="py-2 px-3 text-center">
                                <span class="text-white px-3 py-1 rounded {{ $statusBadge }}">
                                    {{ $statusText }}
                                </span>

                                {{-- Tombol Detail Event --}}
                                <a href="{{ route('mahasiswa.events.show', $event->id) }}"
                                   class="ml-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    Detail Event
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-3">
                                Belum ada event.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
