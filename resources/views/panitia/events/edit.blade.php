<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event & Sertifikat') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg">
            <form method="POST" action="{{ route('panitia.events.update', $event->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label>Judul</label>
                    <input type="text" name="title" value="{{ $event->title }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label>Tanggal</label>
                    <input type="date" name="date" value="{{ $event->date }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label>Lokasi</label>
                    <input type="text" name="location" value="{{ $event->location }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label>Kuota</label>
                    <input type="number" name="quota" value="{{ $event->quota }}" class="w-full border rounded p-2">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            </form>

            <hr class="my-6">

            <h3 class="font-semibold text-lg mb-2">Upload Sertifikat (.png)</h3>
            <form method="POST" action="{{ route('panitia.events.uploadTemplate', $event->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="certificate" accept="application/png" class="border p-2 w-full mb-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Upload Sertifikat</button>
            </form>

            @if($event->certificate)
                <p class="mt-3 text-green-600">Sertifikat sudah diunggah ✅</p>
            @endif
        </div>
    </div>
</x-app-layout>
