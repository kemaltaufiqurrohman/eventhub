<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Template Sertifikat') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                    Upload / Ganti Template Sertifikat
                </h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('events.uploadCertificateTemplate', $event->id) }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Pilih File Template</label>
                        <input type="file" name="certificate_template" accept="image/*"
                               class="border-gray-300 rounded-md w-full focus:ring focus:ring-blue-200">
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Simpan Template
                    </button>
                </form>

                @if ($event->certificate_template)
                    <div class="mt-6">
                        <p class="font-medium text-gray-800 dark:text-gray-200 mb-2">Template Saat Ini:</p>
                        <img src="{{ asset('storage/' . $event->certificate_template) }}" 
                             alt="Template Sertifikat" 
                             class="rounded shadow max-w-lg border">
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
