<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Monitoring Event: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

            <h3 class="text-lg font-bold mb-4">Statistik Event</h3>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-blue-100 rounded text-center">
                    <p class="text-gray-600">Total Pendaftar</p>
                    <p class="text-3xl font-bold">{{ $event->participants_count }}</p>
                </div>
                <div class="p-4 bg-green-100 rounded text-center">
                    <p class="text-gray-600">Sudah Absen</p>
                    <p class="text-3xl font-bold">{{ $event->attendances_count }}</p>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded">
                Kembali
            </a>

        </div>
    </div>
</x-app-layout>
