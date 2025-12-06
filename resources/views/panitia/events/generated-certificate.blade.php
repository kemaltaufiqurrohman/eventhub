<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat - {{ $event->title }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            background: url('{{ $templatePath }}') no-repeat center center;
            background-size: cover;
            font-family: 'Times New Roman', serif;
        }
        .name {
            position: absolute;
            left: {{ $name_x }}px;
            top: {{ $name_y }}px;
            transform: translate(0, 0);
            font-size: {{ $name_font_size }}px;
            font-weight: bold;
            color: {{ $name_color }};
            text-align: center;
            white-space: nowrap;
        }
        /* Jika kamu ingin center relatif pada posisi (x adalah titik tengah), ganti posisi left dengan calc(x - 50%) dll */
    </style>
</head>
<body>
    <div class="container">
        <div class="name">{{ $name }}</div>
    </div>
</body>
</html>
