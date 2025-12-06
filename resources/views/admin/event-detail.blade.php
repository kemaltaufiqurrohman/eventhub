<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Event
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Judul Event --}}
            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>

            {{-- Informasi Event --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-xl font-semibold mb-3">Informasi Event</h3>

                <p><strong>Tanggal:</strong> {{ $event->date }}</p>
                <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                <p><strong>Panitia:</strong> {{ $event->organizer->name }}</p>

                <p class="mt-2">
                    <strong>Status:</strong>
                    @if ($event->status === 'Pending')
                        <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded">Pending</span>
                    @elseif ($event->status === 'Disetujui')
                        <span class="px-2 py-1 bg-green-200 text-green-800 rounded">Disetujui</span>
                    @else
                        <span class="px-2 py-1 bg-red-200 text-red-800 rounded">Ditolak</span>
                    @endif
                </p>

                {{-- DESKRIPSI EVENT --}}
                <div class="mt-4">
                    <strong>Deskripsi Event:</strong>
                    <div class="mt-1 p-3 bg-gray-100 rounded border text-gray-700 leading-relaxed">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-100 p-4 rounded text-gray-800 shadow">
                    <h3 class="text-lg font-bold">Total Peserta Daftar</h3>
                    <p class="text-3xl font-semibold">{{ $event->participants_count }}</p>
                </div>

                <div class="bg-green-100 p-4 rounded text-gray-800 shadow">
                    <h3 class="text-lg font-bold">Total Hadir</h3>
                    <p class="text-3xl font-semibold">{{ $event->attendances_count ?? 0 }}</p>
                </div>
            </div>

            {{-- Tabel Peserta --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-3">Daftar Peserta</h3>

                <table class="w-full border-collapse rounded overflow-hidden shadow">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($event->participants as $reg)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2">{{ $reg->user->name }}</td>
                                <td class="p-2">{{ $reg->user->email }}</td>
                            </tr>
                        @endforeach

                        @if($event->participants->count() == 0)
                            <tr>
                                <td colspan="2" class="text-center p-3 text-gray-500">
                                    Tidak ada peserta.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>
