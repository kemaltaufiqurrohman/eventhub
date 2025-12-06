<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Event
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Card event --}}
            <div class="bg-white shadow rounded p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $event->title }}</h1>
                        <p class="text-sm text-gray-600 mt-1">Oleh: {{ $event->organizer ? $event->organizer->name : '—' }}</p>
                        <p class="text-sm text-gray-600 mt-1">Lokasi: {{ $event->location }}</p>
                        <p class="text-sm text-gray-600 mt-1">Tanggal: {{ $event->date }}</p>
                    </div>

                    <div class="text-right">
                        {{-- Jika ada sertifikat yang bisa di-download dan user terdaftar --}}
                        @if($event->certificate && $alreadyRegistered)
                            <a href="{{ route('events.downloadCertificate', $event->id) }}"
                               class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                                Download Sertifikat
                            </a>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <h3 class="font-semibold mb-2">Deskripsi</h3>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($event->description ?? 'Tidak ada deskripsi.')) !!}
                </div>

                <div class="mt-6 flex items-center gap-3">
                    {{-- Tombol aksi: daftar / sudah terdaftar / event berakhir --}}
                    @if($expired)
                        <span class="px-3 py-1 bg-gray-400 text-white rounded">Event Berakhir</span>
                    @elseif($alreadyRegistered)
                        <span class="px-3 py-1 bg-green-600 text-white rounded">Anda Terdaftar</span>
                    @else
                        <form action="{{ route('events.register', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mendaftar event ini?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Daftar Sekarang
                            </button>
                        </form>
                    @endif

                    {{-- Kembali --}}
                    <a href="{{ url()->previous() }}" class="px-3 py-2 border rounded text-sm">Kembali</a>
                </div>
            </div>

            {{-- Daftar peserta (jika ada relasi registrations) --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold mb-3">Daftar Peserta ({{ $event->registrations->count() }})</h3>

                @if($event->registrations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-2 border">#</th>
                                    <th class="p-2 border">Nama</th>
                                    <th class="p-2 border">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->registrations as $i => $reg)
                                    <tr class="@if($i % 2 == 0) bg-white @else bg-gray-50 @endif">
                                        <td class="p-2 border">{{ $i+1 }}</td>
                                        <td class="p-2 border">{{ $reg->user->name ?? '—' }}</td>
                                        <td class="p-2 border">{{ $reg->user->email ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Belum ada peserta terdaftar.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
