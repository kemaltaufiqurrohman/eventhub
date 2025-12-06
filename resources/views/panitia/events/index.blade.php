<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Event Saya
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-900 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <table class="w-full border text-left">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-2">Judul Event</th>
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Lokasi</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($events as $event)
                        <tr class="border-b">
                            <td class="p-2">{{ $event->title }}</td>
                            <td class="p-2">{{ $event->date }}</td>
                            <td class="p-2">{{ $event->location }}</td>

                            <td class="p-2 flex space-x-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('panitia.events.show', $event->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded">
                                    Detail
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('panitia.events.edit', $event->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded">
                                    Edit
                                </a>

                                {{-- PESERTA --}}
                                <a href="{{ route('panitia.events.participants', $event->id) }}"
                                   class="px-3 py-1 bg-green-600 text-white rounded">
                                    Peserta
                                </a>

                                {{-- QR ABSENSI --}}
                                <a href="{{ route('panitia.events.qr', $event->id) }}"
                                   class="px-3 py-1 bg-purple-600 text-white rounded">
                                    QR Absensi
                                </a>

                                {{-- TEMPLATE SERTIFIKAT --}}
                                <a href="{{ route('panitia.events.manageTemplate', $event->id) }}"
                                   class="px-3 py-1 bg-indigo-600 text-white rounded">
                                    Template
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('panitia.events.destroy', $event->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-500 text-white rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">
                                Belum ada event.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
