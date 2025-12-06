<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Peserta Event: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">

        {{-- Statistik --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-600">Total Peserta</p>
                <p class="text-2xl font-bold">{{ $participants->count() }}</p>
            </div>

            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-600">Sudah Absen</p>
                <p class="text-2xl font-bold text-green-600">
                    {{ $participants->where('attendance_status', 'hadir')->count() }}
                </p>
            </div>

            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-600">Belum Absen</p>
                <p class="text-2xl font-bold text-red-600">
                    {{ $participants->where('attendance_status', 'belum')->count() }}
                </p>
            </div>
        </div>

        {{-- Tabel Peserta --}}
        <div class="bg-white p-6 shadow rounded">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 text-left">Nama</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Status Absen</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($participants as $p)
                        <tr class="border-b">
                            <td class="py-2">{{ $p->user->name }}</td>
                            <td>{{ $p->user->email }}</td>

                            <td>
                                @if ($p->attendance_status == 'hadir')
                                    <span class="px-2 py-1 rounded bg-green-200 text-green-800">
                                        Hadir
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-200 text-red-800">
                                        Belum Hadir
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">
                                Belum ada peserta terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('panitia.events.index') }}" class="text-blue-600">
                ← Kembali ke Daftar Event
            </a>
        </div>
    </div>
</x-app-layout>
