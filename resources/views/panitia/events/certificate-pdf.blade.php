<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            position: relative;
            width: 100%;
        }

        .certificate-img {
            width: 100%;
        }

        .text-name {
            position: absolute;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="certificate-container">

    {{-- Template Sertifikat --}}
    <img class="certificate-img" src="{{ public_path('storage/' . $event->certificate_template) }}" alt="Template">

    {{-- Nama Peserta --}}
    <div class="text-name"
         style="
            left: {{ $settings['x'] ?? 100 }}px;
            top: {{ $settings['y'] ?? 100 }}px;
            font-size: {{ $settings['font_size'] ?? 32 }}px;
            color: {{ $settings['color'] ?? '#000000' }};
         ">
        {{ $name }}
    </div>

</div>

</body>
</html>
