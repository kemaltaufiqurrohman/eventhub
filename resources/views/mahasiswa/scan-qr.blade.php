@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h1 class="text-2xl font-semibold text-center mb-4">Scan QR Absensi</h1>

    <div id="reader" style="width: 100%;"></div>

    <div id="messageBox"
         class="hidden mt-4 p-3 rounded text-white text-center font-semibold transition-opacity duration-500"></div>

    <div id="loadingBox" class="hidden text-center mt-4 text-gray-500">
        Memproses...
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let scanner;

    function showMessage(text, type = 'success') {
        const box = document.getElementById('messageBox');
        box.textContent = text;

        box.classList.remove("hidden", "bg-red-600", "bg-green-600", "opacity-0");

        if (type === "error") {
            box.classList.add("bg-red-600");
        } else {
            box.classList.add("bg-green-600");
        }

        setTimeout(() => {
            box.classList.add("opacity-0");
            setTimeout(() => box.classList.add("hidden"), 500);
        }, 3000);
    }

    function showLoading(show = true) {
        document.getElementById('loadingBox').classList.toggle('hidden', !show);
    }

    function startScanner() {
        scanner = new Html5Qrcode("reader");

        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            qrCodeSuccess
        ).catch(err => {
            showMessage("Kamera gagal dimulai: " + err, "error");
        });
    }

    async function qrCodeSuccess(decodedText) {
        await scanner.stop().catch(() => {});
        showLoading(true);

        console.log("QR DECODED TEXT:", decodedText);

        try {
            const response = await fetch("{{ route('mahasiswa.qr.direct') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    json: decodedText
                })
            });

            const text = await response.text();
            console.log("RAW RESPONSE:", text);

            let data;
            try {
                data = JSON.parse(text);
            } catch (err) {
                showLoading(false);
                showMessage("Server mengirim data bukan JSON.", "error");
                return;
            }

            showLoading(false);

            if (data.status === "success") {
                showMessage(data.message, "success");
            } else if (data.status === "already") {
                showMessage(data.message, "error");
            } else {
                showMessage(data.message, "error");
            }

        } catch (err) {
            showLoading(false);
            showMessage("Gagal mengirim data ke server.", "error");
        }

        setTimeout(() => startScanner(), 1500);
    }

    document.addEventListener("DOMContentLoaded", startScanner);
</script>

@endsection
