<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Absensi - {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto bg-white p-6 shadow rounded text-center">

            <h3 class="text-xl font-bold mb-4">QR Code Absensi</h3>
            <p class="text-gray-600 mb-4">
                Mahasiswa cukup scan QR ini untuk melakukan absensi.
            </p>

            {{-- Tampilan QR PNG --}}
            <img src="{{ asset('storage/' . $qrPath) }}" 
                 alt="QR Absensi"
                 class="mx-auto mb-6 shadow rounded-lg" 
                 style="width: 300px">

            {{-- Tombol Download --}}
            <a href="{{ asset('storage/' . $qrPath) }}" 
               download="QR-Absensi-Event-{{ $event->id }}.png"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Download QR PNG
            </a>

            <div class="mt-4">
                <a href="{{ route('panitia.dashboard') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
