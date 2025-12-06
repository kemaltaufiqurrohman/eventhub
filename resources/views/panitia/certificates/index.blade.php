<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Template Sertifikat') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Pilih Event</label>
                    <select name="event_id" class="w-full border-gray-300 rounded">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Upload Template Sertifikat</label>
                    <input type="file" name="certificate_template" accept="image/*" class="w-full border-gray-300 rounded">
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan Template
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
