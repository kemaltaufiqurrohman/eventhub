<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('panitia.events.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Judul Event</label>
                        <input type="text" name="title" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full border rounded p-2" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal</label>
                        <input type="date" name="date" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Lokasi</label>
                        <input type="text" name="location" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kuota Peserta</label>
                        <input type="number" name="quota" min="1" class="w-full border rounded p-2" required>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
                        Simpan Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
