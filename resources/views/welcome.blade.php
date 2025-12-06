<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f8f9fc;
            color: #333;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .logo {
            font-size: 26px;
            font-weight: 700;
            color: #4a4cff;
        }
        nav a {
            margin-left: 30px;
            text-decoration: none;
            font-weight: 500;
            color: #333;
        }
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 100px 60px;
        }
        .hero-text {
            max-width: 500px;
        }
        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        .hero-text p {
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 30px;
        }
        .btn-primary {
            display: inline-block;
            padding: 14px 28px;
            background: #4a4cff;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
        }
        .hero img {
            width: 480px;
        }
        .features {
            padding: 80px 60px;
            text-align: center;
        }
        .features h2 {
            font-size: 36px;
            margin-bottom: 40px;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            text-align: left;
        }
        .card h3 {
            margin-bottom: 15px;
        }
        footer {
            margin-top: 80px;
            background: #4a4cff;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">EventHub</div>
        <nav>
            <a href="/login" class="btn-primary">Login</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Kelola Event Kampus Dengan Lebih Mudah</h1>
            <p>EventHub membantu pengelolaan event kampus secara modern dan terintegrasi.</p>
            <a href="/login" class="btn-primary">Login</a>
        </div>
        <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Event Illustration" style="width:480px;">
    </section>

    

    <footer>
        © 2025 EventHub. All rights reserved.
    </footer>
</body>
</html>
