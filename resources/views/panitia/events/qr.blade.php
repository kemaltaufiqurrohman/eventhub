@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-10">
    <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-lg text-center">

        {{-- JUDUL --}}
        <h1 class="text-2xl font-bold mb-2">QR Code Absensi</h1>
        <p class="text-gray-600 mb-5">Event: {{ $event->title }}</p>

        {{-- QR CODE --}}
        <div id="qr-wrapper" class="flex justify-center">
            {!! QrCode::size(260)->generate($qrContent) !!}
        </div>

        {{-- CATATAN --}}
        <p class="mt-4 text-gray-500 text-sm">
            Scan QR ini menggunakan kamera di halaman Mahasiswa untuk absensi.
        </p>

        {{-- TOMBOL DOWNLOAD QR --}}
        <button onclick="downloadQR()" 
            class="mt-6 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">
            Download QR
        </button>

    </div>
</div>

{{-- SCRIPT DOWNLOAD QR --}}
<script>
function downloadQR() {
    // Cari elemen SVG dari QR Code
    let svg = document.querySelector('#qr-wrapper svg');
    
    if (!svg) {
        alert('QR tidak ditemukan!');
        return;
    }

    // Convert SVG ke teks
    let svgData = new XMLSerializer().serializeToString(svg);

    // Buat blob file
    let blob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });

    // Buat URL
    let url = URL.createObjectURL(blob);

    // Buat link download
    let link = document.createElement("a");
    link.href = url;
    link.download = "qr-event-{{ $event->id }}.svg";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

@endsection
