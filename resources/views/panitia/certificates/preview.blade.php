<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview Template Sertifikat') }}
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg mb-4">{{ $event->title }}</h3>

            <img src="{{ $url }}" alt="Template Sertifikat" class="max-w-full rounded shadow">

            <div class="mt-4 text-center">
                <a href="{{ route('panitia.dashboard') }}" 
                   class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
