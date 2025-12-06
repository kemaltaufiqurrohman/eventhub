<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Panitia
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('panitia.events.create') }}" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">+ Tambah Event</a>
                <a href="#" onclick="document.getElementById('event-list').scrollIntoView({behavior: 'smooth'})" class="px-4 py-1 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">List Event</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔔 Notifikasi --}}
            @if (auth()->user()->notification)
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    🔔 {{ auth()->user()->notification }}
                </div>
            @endif

            <h1 class="text-3xl font-bold mb-3">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 mb-6">Selamat datang di Dashboard Panitia EventHub.</p>

            {{-- ⭐ Menu Atas --}}
            <div class="flex gap-4 mb-8">
                <a href="{{ route('panitia.events.create') }}"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    + Tambah Event
                </a>

                <button onclick="document.getElementById('event-list').scrollIntoView({behavior: 'smooth'})"
                    class="px-5 py-2 bg-gray-800 text-white rounded-lg shadow hover:bg-gray-900">
                    📋 List Event
                </button>
            </div>

            {{-- 📊 Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-100 p-4 rounded text-gray-800 shadow">
                    <h3 class="text-lg font-bold">Total Event</h3>
                    <p class="text-3xl font-semibold">{{ $totalEvents ?? 0 }}</p>
                </div>

                <div class="bg-green-100 p-4 rounded text-gray-800 shadow">
                    <h3 class="text-lg font-bold">Total Peserta</h3>
                    <p class="text-3xl font-semibold">{{ $totalParticipants ?? 0 }}</p>
                </div>
            </div>

            {{-- 📋 Daftar Event Panitia --}}
            <div id="event-list" class="mt-14">
                <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                    📅 Daftar Event Anda
                </h3>

                @if (session('success'))
                    <div class="mb-3 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
    <div class="flex gap-2">
        <button onclick="filterEvents('all')" class="px-3 py-1 bg-gray-700 text-white rounded">Semua</button>
        <button onclick="filterEvents('Pending')" class="px-3 py-1 bg-yellow-500 text-white rounded">Pending</button>
        <button onclick="filterEvents('Disetujui')" class="px-3 py-1 bg-green-600 text-white rounded">Disetujui</button>
        <button onclick="filterEvents('Ditolak')" class="px-3 py-1 bg-red-600 text-white rounded">Ditolak</button>
    </div>
</div>

<table class="w-full text-left border-collapse mt-3 shadow rounded overflow-hidden" id="eventTable">
    <thead>
        <tr class="bg-gray-200 text-gray-700">
            <th class="py-2 px-3 border">Judul</th>
            <th class="py-2 px-3 border">Tanggal</th>
            <th class="py-2 px-3 border">Lokasi</th>
            <th class="py-2 px-3 border">Status</th>
            <th class="py-2 px-3 border text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($events as $event)
            <tr class="border-b hover:bg-gray-100 transition" data-status="{{ $event->status }}">
                <td class="py-2 px-3">{{ $event->title }}</td>
                <td class="py-2 px-3">{{ $event->date }}</td>
                <td class="py-2 px-3">{{ $event->location }}</td>
                <td class="py-2 px-3">
                    <span class="px-2 py-1 text-sm rounded text-white
                        @if($event->status == 'Pending') bg-yellow-500
                        @elseif($event->status == 'Disetujui') bg-green-600
                        @elseif($event->status == 'Ditolak') bg-red-600
                        @else bg-gray-600 @endif">
                        {{ $event->status }}
                    </span>
                </td>
                <td class="py-2 px-3 text-center flex items-center justify-center gap-2">

                    {{-- Sertifikat --}}
                    <a href="{{ route('panitia.events.manageTemplate', $event->id) }}"
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                        Sertifikat
                    </a>

                    {{-- Edit Event --}}
                    <a href="{{ route('panitia.events.edit', $event->id) }}"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        Edit Event
                    </a>

                    {{-- QR Absensi --}}
                    <a href="{{ route('panitia.events.qr', $event->id) }}"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                        QR Absensi
                    </a>

                    {{-- Peserta Event --}}
                    <a href="{{ route('panitia.events.participants', $event->id) }}"
                    class="px-3 py-1 bg-blue-600 text-white rounded">
                        Peserta
                    </a>


                    {{-- Hapus Event --}}
                    <form action="{{ route('panitia.events.destroy', $event->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-3">Belum ada event.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
function filterEvents(status) {
    let rows = document.querySelectorAll('#eventTable tbody tr');
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } el
            </div>

        </div>
    </div>

</x-app-layout>
