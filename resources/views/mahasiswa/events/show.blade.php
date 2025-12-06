<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Event
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white shadow p-6 rounded-lg">

            {{-- Judul Event --}}
            <h1 class="text-3xl font-bold mb-3">{{ $event->title }}</h1>

            {{-- Deskripsi --}}
            <p class="text-gray-700 mb-5">
                {{ $event->description ?? 'Tidak ada deskripsi.' }}
            </p>

            @php
                // Registrasi user terhadap event ini
                $reg = $registration ?? null;

                // Tentukan status tampilannya
                if ($attendance) {
                    $statusText = 'Hadir';
                    $statusBadge = 'bg-green-600';
                } elseif ($reg) {
                    $statusText = 'Tidak Hadir';
                    $statusBadge = 'bg-red-600';
                } else {
                    $statusText = 'Belum Terdaftar';
                    $statusBadge = 'bg-gray-600';
                }
            @endphp

            {{-- Detail Event --}}
            <div class="text-gray-700 space-y-2 mt-4">
                <p><strong>Tanggal:</strong> {{ $event->date }}</p>
                <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                <p><strong>Kuota:</strong> {{ $event->quota }}</p>

                {{-- Status--}}
                <p class="mt-2">
                    <strong>Status:</strong>
                    <span class="px-2 py-1 rounded text-white {{ $statusBadge }}">
                        {{ $statusText }}
                    </span>
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex gap-3">

                <a href="{{ route('mahasiswa.events.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Kembali
                </a>

                {{-- Tombol Daftar --}}
                @if(!$reg)
                    <form action="{{ route('events.register', $event->id) }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Daftar
                        </button>
                    </form>
                @endif

                {{-- Tombol Sertifikat --}}
                @if($attendance)
                    <a href="{{ route('events.downloadCertificate', $event->id) }}" 
                       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Download Sertifikat
                    </a>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
