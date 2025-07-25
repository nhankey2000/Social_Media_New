<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Hệ Sinh Thái Ông Đề</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab, #667eea, #764ba2);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #1a1a1a;
            line-height: 1.6;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated gradient background */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating particles */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 60% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 90% 60%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: floatParticles 12s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes floatParticles {
            0%, 100% {
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.7;
            }
            33% {
                transform: translateY(-20px) rotate(120deg) scale(1.1);
                opacity: 1;
            }
            66% {
                transform: translateY(10px) rotate(240deg) scale(0.9);
                opacity: 0.8;
            }
        }

        /* Pulsing glow effect */
        body::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.03) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 4s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-50%, -50%) scale(2);
                opacity: 0.2;
            }
        }

        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 10;
        }

        .container p {
            color: white;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            margin-bottom: 48px;
            animation: fadeIn 1s ease-out 0.2s both;
        }

        .logo {
            width: 200px;
            height: 120px;
            margin: 0 auto 24px;
            border-radius: 24px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: translateY(-4px);
        }

        .logo img {
            width: 160px;
            height: 80px;
            border-radius: 16px;
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
            background: linear-gradient(-45deg, #ffffff, #ffdd59, #ffd700, #32cd32, #00ff00, #228b22, #ff8c00, #ffffff);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeIn 1s ease-out 0.4s both, gradientText 6s ease infinite;
        }

        @keyframes gradientText {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .subtitle {
            font-size: 1.25rem;
            color: white;
            margin-bottom: 48px;
            font-weight: 400;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .social-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 16px;
            padding: 32px 24px;
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out both;
        }

        .social-card:nth-child(1) { animation-delay: 0.8s; }
        .social-card:nth-child(2) { animation-delay: 1s; }
        .social-card:nth-child(3) { animation-delay: 1.2s; }
        .social-card:nth-child(4) { animation-delay: 1.4s; }

        .social-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #1a1a1a, #2d3748, #4a5568, transparent);
            transition: left 0.8s ease;
        }

        .social-card:hover::before {
            left: 100%;
        }

        .social-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.98);
        }

        .social-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(26, 26, 26, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
            pointer-events: none;
            z-index: -1;
        }

        .social-card:hover::after {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(45, 55, 72, 0.05) 0%, transparent 70%);
        }

        .social-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: transparent;
            position: relative;
        }

        .social-card:hover .social-icon {
            transform: scale(1.2) rotateY(360deg);
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.2));
        }

        .social-icon::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 16px;
            background: linear-gradient(45deg, #1a1a1a, #2d3748, #4a5568, #1a202c, #2a2a2a, #374151);
            background-size: 300% 300%;
            animation: rainbowRotate 3s linear infinite;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .social-card:hover .social-icon::before {
            opacity: 0.7;
        }

        @keyframes rainbowRotate {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .social-icon img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
        }

        .tiktok .social-icon,
        .facebook .social-icon,
        .website .social-icon,
        .zalo .social-icon {
            background: transparent;
        }

        .social-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .social-description {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
        }

        .footer {
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 1s ease-out 1.6s both;
        }

        .footer-text {
            font-size: 0.875rem;
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                justify-content: flex-start;
                padding: 40px 16px 20px;
            }

            .container {
                padding: 0;
                margin-top: 20px;
            }

            .main-title {
                font-size: 2.5rem;
                margin-bottom: 12px;
            }

            .subtitle {
                font-size: 1.125rem;
                margin-bottom: 32px;
            }

            .logo {
                width: 160px;
                height: 100px;
                margin-bottom: 20px;
            }

            .logo img {
                width: 120px;
                height: 64px;
            }

            .social-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-bottom: 32px;
            }

            .social-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 30px 10px 20px;
            }

            .main-title {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1rem;
            }

            .logo {
                width: 140px;
                height: 80px;
            }

            .logo img {
                width: 100px;
                height: 48px;
            }

            .social-card {
                padding: 20px 16px;
            }

            .social-icon {
                width: 40px;
                height: 40px;
            }

            .social-icon img {
                width: 40px;
                height: 40px;
            }
        }

        /* Touch devices optimization */
        @media (hover: none) and (pointer: coarse) {
            .social-card:hover {
                transform: none;
            }

            .social-card:active {
                transform: scale(0.98);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo-section">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Ông Đề">
        </div>
    </div>

    <h1 class="main-title">Hệ Sinh Thái Ông Đề</h1>
    <p class="subtitle">Kết nối và theo dõi Ông Đề trên tất cả các nền tảng</p>

    <div class="social-grid">
        <a href="https://www.tiktok.com/@ongde2022" target="_blank" class="social-card tiktok">
            <div class="social-icon">
                <img src="{{ asset('images/tiktok.png') }}" alt="TikTok">
            </div>
            <div class="social-title">TikTok</div>
            <div class="social-description">Video giải trí và thông tin</div>
        </a>

        <a href="https://www.facebook.com/langdulichongde" target="_blank" class="social-card facebook">
            <div class="social-icon">
                <img src="{{ asset('images/facebook.png') }}" alt="Facebook">
            </div>
            <div class="social-title">Facebook</div>
            <div class="social-description">Cộng đồng và tin tức</div>
        </a>

        <a href="https://ongde.vn" target="_blank" class="social-card website">
            <div class="social-icon">
                <img src="{{ asset('images/web.png') }}" alt="Website">
            </div>
            <div class="social-title">Website</div>
            <div class="social-description">Trang web chính thức</div>
        </a>

        <a href="https://zalo.me/0782918222" target="_blank" class="social-card zalo">
            <div class="social-icon">
                <img src="{{ asset('images/zalo.png') }}" alt="Zalo">
            </div>
            <div class="social-title">Zalo</div>
            <div class="social-description">Chat và liên hệ trực tiếp</div>
        </a>
    </div>

    <div class="footer">
        <p class="footer-text">© 2025 Làng Du Lịch Sinh Thái Ông Đề. Tất cả quyền được bảo lưu.</p>
        <p class="footer-text">CTY TNHH Làng Du Lịch Sinh Thái Ông Đề.</p>
        <p class="footer-text">Địa chỉ: 168 AB, Xuân Thuỷ, An Bình, Ninh Kiều, TPCT.</p>
    </div>
</div>
</body>
</html>
