<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Template Sertifikat
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">📄 Template Sertifikat untuk Event: {{ $event->title }}</h3>

                {{-- ✅ Notifikasi sukses --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ✅ Form upload template baru --}}
                <form action="{{ route('panitia.events.uploadTemplate', $event->id) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti Template Sertifikat
                    </label>
                    <input type="file" name="certificate_template" accept="image/*"
                           class="border border-gray-300 rounded-lg w-full mb-3 p-2">

                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Upload Template Baru
                    </button>
                </form>

                {{-- ✅ Preview Template --}}
                @if ($event->certificate_template)
                    <div class="mt-8">
                        <h4 class="text-md font-semibold mb-3">🖼️ Preview Template Saat Ini</h4>
                        <img src="{{ asset('storage/' . $event->certificate_template) }}" 
                             alt="Preview Sertifikat"
                             class="border rounded-lg shadow-md w-full max-h-[500px] object-contain">
                    </div>
                @else
                    <div class="mt-6 text-gray-600 italic">
                        Belum ada template sertifikat yang diupload untuk event ini.
                    </div>
                @endif

                <a href="{{ route('panitia.events.previewCertificate', $event->id) }}"
                    class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        🔧 Edit & Generate Sertifikat
                </a>


                {{-- Tombol kembali ke dashboard --}}
                <div class="mt-8">
                    <a href="{{ route('panitia.dashboard') }}"
                       class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        ⬅️ Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
