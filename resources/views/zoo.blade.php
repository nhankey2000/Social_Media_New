{{--<!DOCTYPE html>--}}
{{--<html lang="vi">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">--}}
{{--    <title>Hệ Sinh Thái Ông Đề</title>--}}
{{--    <style>--}}
{{--        * {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        body {--}}
{{--            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;--}}
{{--            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab, #667eea, #764ba2);--}}
{{--            background-size: 400% 400%;--}}
{{--            animation: gradientShift 8s ease infinite;--}}
{{--            min-height: 100vh;--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--            justify-content: center;--}}
{{--            align-items: center;--}}
{{--            padding: 20px;--}}
{{--            color: #1a1a1a;--}}
{{--            line-height: 1.6;--}}
{{--            position: relative;--}}
{{--            overflow-x: hidden;--}}
{{--        }--}}

{{--        @keyframes gradientShift {--}}
{{--            0% { background-position: 0% 50%; }--}}
{{--            50% { background-position: 100% 50%; }--}}
{{--            100% { background-position: 0% 50%; }--}}
{{--        }--}}

{{--        body::before {--}}
{{--            content: '';--}}
{{--            position: absolute;--}}
{{--            top: 0;--}}
{{--            left: 0;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            background-image:--}}
{{--                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),--}}
{{--                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),--}}
{{--                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.06) 0%, transparent 50%),--}}
{{--                radial-gradient(circle at 60% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 50%),--}}
{{--                radial-gradient(circle at 90% 60%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);--}}
{{--            animation: floatParticles 12s ease-in-out infinite;--}}
{{--            pointer-events: none;--}}
{{--        }--}}

{{--        @keyframes floatParticles {--}}
{{--            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.7; }--}}
{{--            33% { transform: translateY(-20px) rotate(120deg) scale(1.1); opacity: 1; }--}}
{{--            66% { transform: translateY(10px) rotate(240deg) scale(0.9); opacity: 0.8; }--}}
{{--        }--}}

{{--        body::after {--}}
{{--            content: '';--}}
{{--            position: absolute;--}}
{{--            top: 50%;--}}
{{--            left: 50%;--}}
{{--            width: 200px;--}}
{{--            height: 200px;--}}
{{--            background: radial-gradient(circle, rgba(255, 255, 255, 0.03) 0%, transparent 70%);--}}
{{--            border-radius: 50%;--}}
{{--            transform: translate(-50%, -50%);--}}
{{--            animation: pulse 4s ease-in-out infinite;--}}
{{--            pointer-events: none;--}}
{{--        }--}}

{{--        @keyframes pulse {--}}
{{--            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }--}}
{{--            50% { transform: translate(-50%, -50%) scale(2); opacity: 0.2; }--}}
{{--        }--}}

{{--        .container {--}}
{{--            max-width: 800px;--}}
{{--            width: 100%;--}}
{{--            text-align: center;--}}
{{--            animation: fadeInUp 0.8s ease-out;--}}
{{--            position: relative;--}}
{{--            z-index: 10;--}}
{{--        }--}}

{{--        .container p {--}}
{{--            color: white;--}}
{{--        }--}}

{{--        .header-title {--}}
{{--            font-size: 2.5rem;--}}
{{--            font-weight: 800;--}}
{{--            margin-bottom: 32px;--}}
{{--            letter-spacing: -0.02em;--}}
{{--            background: linear-gradient(-45deg, #ffffff, #ffdd59, #ffd700, #32cd32, #00ff00, #228b22, #ff8c00, #ffffff);--}}
{{--            background-size: 400% 400%;--}}
{{--            -webkit-background-clip: text;--}}
{{--            -webkit-text-fill-color: transparent;--}}
{{--            background-clip: text;--}}
{{--            animation: fadeIn 1s ease-out 0.3s both, gradientText 6s ease infinite;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        .menu-section {--}}
{{--            margin-bottom: 40px;--}}
{{--            animation: fadeIn 1s ease-out 0.4s both;--}}
{{--        }--}}

{{--        .tab-menu {--}}
{{--            display: flex;--}}
{{--            justify-content: center;--}}
{{--            flex-wrap: wrap;--}}
{{--            gap: 8px;--}}
{{--            background: rgba(255, 255, 255, 0.1);--}}
{{--            backdrop-filter: blur(20px);--}}
{{--            border-radius: 20px;--}}
{{--            padding: 8px;--}}
{{--            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);--}}
{{--            border: 1px solid rgba(255, 255, 255, 0.2);--}}
{{--            max-width: 100%;--}}
{{--            overflow-x: auto;--}}
{{--        }--}}

{{--        .tab-item {--}}
{{--            padding: 12px 20px;--}}
{{--            border-radius: 16px;--}}
{{--            background: transparent;--}}
{{--            border: none;--}}
{{--            color: rgba(255, 255, 255, 0.8);--}}
{{--            font-weight: 500;--}}
{{--            font-size: 0.9rem;--}}
{{--            cursor: pointer;--}}
{{--            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);--}}
{{--            position: relative;--}}
{{--            white-space: nowrap;--}}
{{--            min-width: fit-content;--}}
{{--        }--}}

{{--        .tab-item:hover {--}}
{{--            color: white;--}}
{{--            transform: translateY(-2px);--}}
{{--        }--}}

{{--        .tab-item.active {--}}
{{--            background: rgba(255, 255, 255, 0.95);--}}
{{--            color: #1f2937;--}}
{{--            font-weight: 600;--}}
{{--            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);--}}
{{--            transform: translateY(-2px);--}}
{{--        }--}}

{{--        .tab-item.active::before {--}}
{{--            content: '';--}}
{{--            position: absolute;--}}
{{--            top: -2px;--}}
{{--            left: -2px;--}}
{{--            right: -2px;--}}
{{--            bottom: -2px;--}}
{{--            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);--}}
{{--            border-radius: 18px;--}}
{{--            z-index: -1;--}}
{{--            opacity: 0.7;--}}
{{--            animation: borderGlow 2s linear infinite;--}}
{{--        }--}}

{{--        @keyframes borderGlow {--}}
{{--            0% { background-position: 0% 50%; }--}}
{{--            50% { background-position: 100% 50%; }--}}
{{--            100% { background-position: 0% 50%; }--}}
{{--        }--}}

{{--        @keyframes fadeInUp {--}}
{{--            from { opacity: 0; transform: translateY(40px); }--}}
{{--            to { opacity: 1; transform: translateY(0); }--}}
{{--        }--}}

{{--        .logo-section {--}}
{{--            margin-bottom: 24px;--}}
{{--            animation: fadeIn 1s ease-out 0.2s both;--}}
{{--        }--}}

{{--        .logo {--}}
{{--            width: 200px;--}}
{{--            height: 120px;--}}
{{--            margin: 0 auto 24px;--}}
{{--            border-radius: 24px;--}}
{{--            background: #ffffff;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);--}}
{{--            transition: transform 0.3s ease;--}}
{{--        }--}}

{{--        .logo:hover {--}}
{{--            transform: translateY(-4px);--}}
{{--        }--}}

{{--        .logo img {--}}
{{--            width: 160px;--}}
{{--            height: 80px;--}}
{{--            border-radius: 16px;--}}
{{--        }--}}

{{--        .main-title {--}}
{{--            font-size: 3.5rem;--}}
{{--            font-weight: 800;--}}
{{--            margin-bottom: 16px;--}}
{{--            letter-spacing: -0.02em;--}}
{{--            background: linear-gradient(-45deg, #ffffff, #ffdd59, #ffd700, #32cd32, #00ff00, #228b22, #ff8c00, #ffffff);--}}
{{--            background-size: 400% 400%;--}}
{{--            -webkit-background-clip: text;--}}
{{--            -webkit-text-fill-color: transparent;--}}
{{--            background-clip: text;--}}
{{--            animation: fadeIn 1s ease-out 0.4s both, gradientText 6s ease infinite;--}}
{{--            transition: all 0.5s ease;--}}
{{--        }--}}

{{--        @keyframes gradientText {--}}
{{--            0% { background-position: 0% 50%; }--}}
{{--            50% { background-position: 100% 50%; }--}}
{{--            100% { background-position: 0% 50%; }--}}
{{--        }--}}

{{--        .subtitle {--}}
{{--            font-size: 1.25rem;--}}
{{--            color: white;--}}
{{--            margin-bottom: 48px;--}}
{{--            font-weight: 400;--}}
{{--            animation: fadeIn 1s ease-out 0.5s both;--}}
{{--        }--}}

{{--        @keyframes fadeIn {--}}
{{--            from { opacity: 0; }--}}
{{--            to { opacity: 1; }--}}
{{--        }--}}

{{--        .social-grid {--}}
{{--            display: grid;--}}
{{--            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));--}}
{{--            gap: 24px;--}}
{{--            margin-bottom: 48px;--}}
{{--        }--}}

{{--        .social-card {--}}
{{--            background: rgba(255, 255, 255, 0.95);--}}
{{--            backdrop-filter: blur(10px);--}}
{{--            border: none;--}}
{{--            border-radius: 16px;--}}
{{--            padding: 0;--}}
{{--            text-decoration: none;--}}
{{--            color: inherit;--}}
{{--            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);--}}
{{--            position: relative;--}}
{{--            overflow: hidden;--}}
{{--            animation: fadeInUp 0.8s ease-out both;--}}
{{--            cursor: pointer;--}}
{{--        }--}}

{{--        .social-card:nth-child(1) { animation-delay: 0.8s; }--}}
{{--        .social-card:nth-child(2) { animation-delay: 1s; }--}}
{{--        .social-card:nth-child(3) { animation-delay: 1.2s; }--}}
{{--        .social-card:nth-child(4) { animation-delay: 1.4s; }--}}
{{--        .social-card:nth-child(5) { animation-delay: 1.6s; }--}}
{{--        .social-card:nth-child(6) { animation-delay: 1.8s; }--}}

{{--        .social-card::before {--}}
{{--            content: '';--}}
{{--            position: absolute;--}}
{{--            top: 0;--}}
{{--            left: -100%;--}}
{{--            width: 100%;--}}
{{--            height: 2px;--}}
{{--            background: linear-gradient(90deg, transparent, #1a1a1a, #2d3748, #4a5568, transparent);--}}
{{--            transition: left 0.8s ease;--}}
{{--        }--}}

{{--        .social-card:hover::before {--}}
{{--            left: 100%;--}}
{{--        }--}}

{{--        .social-card:hover {--}}
{{--            transform: translateY(-12px) scale(1.02);--}}
{{--            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);--}}
{{--            background: rgba(255, 255, 255, 0.98);--}}
{{--        }--}}

{{--        .social-card::after {--}}
{{--            content: '';--}}
{{--            position: absolute;--}}
{{--            top: 50%;--}}
{{--            left: 50%;--}}
{{--            width: 0;--}}
{{--            height: 0;--}}
{{--            background: radial-gradient(circle, rgba(26, 26, 26, 0.1) 0%, transparent 70%);--}}
{{--            border-radius: 50%;--}}
{{--            transform: translate(-50%, -50%);--}}
{{--            transition: all 0.6s ease;--}}
{{--            pointer-events: none;--}}
{{--            z-index: -1;--}}
{{--        }--}}

{{--        .social-card:hover::after {--}}
{{--            width: 200px;--}}
{{--            height: 200px;--}}
{{--            background: radial-gradient(circle, rgba(45, 55, 72, 0.05) 0%, transparent 70%);--}}
{{--        }--}}

{{--        .card-header {--}}
{{--            width: 100%;--}}
{{--            height: 120px;--}}
{{--            overflow: hidden;--}}
{{--            border-radius: 16px 16px 0 0;--}}
{{--            position: relative;--}}
{{--        }--}}

{{--        .card-header img {--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            object-fit: cover;--}}
{{--            transition: transform 0.4s ease;--}}
{{--        }--}}

{{--        .social-card:hover .card-header img {--}}
{{--            transform: scale(1.1);--}}
{{--        }--}}

{{--        .card-content {--}}
{{--            padding: 20px;--}}
{{--            text-align: left;--}}
{{--        }--}}

{{--        .social-title {--}}
{{--            font-size: 1.125rem;--}}
{{--            font-weight: 600;--}}
{{--            color: #1f2937;--}}
{{--            margin-bottom: 8px;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        .social-description {--}}
{{--            font-size: 0.875rem;--}}
{{--            color: #6b7280;--}}
{{--            font-weight: 400;--}}
{{--            line-height: 1.5;--}}
{{--        }--}}

{{--        .expandable-content {--}}
{{--            max-height: 0;--}}
{{--            overflow: hidden;--}}
{{--            transition: max-height 0.4s ease-out;--}}
{{--            background: rgba(249, 250, 251, 0.8);--}}
{{--            margin: 12px -20px 0 -20px;--}}
{{--            border-radius: 0 0 16px 16px;--}}
{{--        }--}}

{{--        .expandable-content.expanded {--}}
{{--            max-height: 400px;--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .expandable-content p {--}}
{{--            color: #374151;--}}
{{--            font-size: 0.875rem;--}}
{{--            line-height: 1.6;--}}
{{--            margin: 0;--}}
{{--            text-align: justify;--}}
{{--        }--}}

{{--        .expand-icon {--}}
{{--            position: absolute;--}}
{{--            bottom: 15px;--}}
{{--            right: 15px;--}}
{{--            width: 24px;--}}
{{--            height: 24px;--}}
{{--            background: rgba(107, 114, 128, 0.8);--}}
{{--            border-radius: 50%;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            color: white;--}}
{{--            font-size: 12px;--}}
{{--            transition: all 0.3s ease;--}}
{{--            z-index: 5;--}}
{{--        }--}}

{{--        .expand-icon::before {--}}
{{--            content: '+';--}}
{{--            transition: transform 0.3s ease;--}}
{{--        }--}}

{{--        .social-card.expanded .expand-icon::before {--}}
{{--            content: '−';--}}
{{--            transform: rotate(180deg);--}}
{{--        }--}}

{{--        .social-card.expanded .expand-icon {--}}
{{--            background: rgba(107, 114, 128, 1);--}}
{{--        }--}}

{{--        .footer {--}}
{{--            margin-top: 48px;--}}
{{--            padding-top: 32px;--}}
{{--            border-top: 1px solid rgba(255, 255, 255, 0.2);--}}
{{--            animation: fadeIn 1s ease-out 1.6s both;--}}
{{--        }--}}

{{--        .footer-text {--}}
{{--            font-size: 0.875rem;--}}
{{--            color: white;--}}
{{--        }--}}

{{--        @media (max-width: 768px) {--}}
{{--            body {--}}
{{--                justify-content: flex-start;--}}
{{--                padding: 40px 16px 20px;--}}
{{--            }--}}

{{--            .container {--}}
{{--                padding: 0;--}}
{{--                margin-top: 20px;--}}
{{--            }--}}

{{--            .tab-menu {--}}
{{--                gap: 6px;--}}
{{--                padding: 6px;--}}
{{--                overflow-x: auto;--}}
{{--                scrollbar-width: none;--}}
{{--                -ms-overflow-style: none;--}}
{{--            }--}}

{{--            .tab-menu::-webkit-scrollbar {--}}
{{--                display: none;--}}
{{--            }--}}

{{--            .tab-item {--}}
{{--                padding: 10px 16px;--}}
{{--                font-size: 0.85rem;--}}
{{--                min-width: 120px;--}}
{{--                text-align: center;--}}
{{--            }--}}

{{--            .header-title {--}}
{{--                font-size: 2rem;--}}
{{--                margin-bottom: 24px;--}}
{{--            }--}}

{{--            .main-title {--}}
{{--                font-size: 2.5rem;--}}
{{--                margin-bottom: 12px;--}}
{{--            }--}}

{{--            .subtitle {--}}
{{--                font-size: 1.125rem;--}}
{{--                margin-bottom: 32px;--}}
{{--            }--}}

{{--            .logo {--}}
{{--                width: 160px;--}}
{{--                height: 100px;--}}
{{--                margin-bottom: 20px;--}}
{{--            }--}}

{{--            .logo img {--}}
{{--                width: 120px;--}}
{{--                height: 64px;--}}
{{--            }--}}

{{--            .social-grid {--}}
{{--                grid-template-columns: 1fr;--}}
{{--                gap: 16px;--}}
{{--                margin-bottom: 32px;--}}
{{--            }--}}

{{--            .card-header {--}}
{{--                height: 100px;--}}
{{--            }--}}

{{--            .card-content {--}}
{{--                padding: 16px;--}}
{{--            }--}}
{{--        }--}}

{{--        @media (max-width: 480px) {--}}
{{--            body {--}}
{{--                padding: 30px 10px 20px;--}}
{{--            }--}}

{{--            .tab-menu {--}}
{{--                gap: 4px;--}}
{{--                padding: 4px;--}}
{{--            }--}}

{{--            .tab-item {--}}
{{--                padding: 8px 12px;--}}
{{--                font-size: 0.8rem;--}}
{{--                min-width: 100px;--}}
{{--            }--}}

{{--            .header-title {--}}
{{--                font-size: 1.7rem;--}}
{{--                margin-bottom: 20px;--}}
{{--            }--}}

{{--            .main-title {--}}
{{--                font-size: 2rem;--}}
{{--            }--}}

{{--            .subtitle {--}}
{{--                font-size: 1rem;--}}
{{--            }--}}

{{--            .logo {--}}
{{--                width: 140px;--}}
{{--                height: 80px;--}}
{{--            }--}}

{{--            .logo img {--}}
{{--                width: 100px;--}}
{{--                height: 48px;--}}
{{--            }--}}

{{--            .card-header {--}}
{{--                height: 80px;--}}
{{--            }--}}

{{--            .card-content {--}}
{{--                padding: 12px;--}}
{{--            }--}}
{{--        }--}}

{{--        @media (hover: none) and (pointer: coarse) {--}}
{{--            .social-card:hover {--}}
{{--                transform: none;--}}
{{--            }--}}

{{--            .social-card:active {--}}
{{--                transform: scale(0.98);--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container">--}}
{{--    <div class="logo-section">--}}
{{--        <div class="logo">--}}
{{--            <img src="{{ asset('images/logo.png') }}" alt="Logo Ông Đề">--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <h1 class="header-title" id="headerTitle">Hướng Dẫn Chăm Sóc Thú Vườn Thú</h1>--}}

{{--    <div class="menu-section">--}}
{{--        <div class="tab-menu">--}}
{{--            <button class="tab-item active" onclick="selectAnimal('cuu', this)">Cừu</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('nai', this)">Nai</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('tho', this)">Thỏ</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('casau', this)">Cá Sấu</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('dadieu', this)">Đà Điều</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('cong', this)">Công</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('chim', this)">Chim</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('ga', this)">Gà</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('de', this)">Dê</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('bo', this)">Bò</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('trau', this)">Trâu</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('huou', this)">Hươu</button>--}}
{{--            <button class="tab-item" onclick="selectAnimal('heotoc', this)">Heo Tộc</button>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <h2 class="main-title" id="mainTitle">Hướng Dẫn Chăm Sóc Cừu</h2>--}}
{{--    <p class="subtitle" id="subtitle">Tất cả thông tin cần thiết để chăm sóc cừu hiệu quả</p>--}}

{{--    <div class="social-grid" id="socialGrid">--}}
{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/chamcuu.png') }}" alt="Chăm Sóc">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Chăm Sóc</div>--}}
{{--                <div class="social-description">Quy trình chăm sóc hàng ngày cho cừu</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Cừu mẹ: chu kỳ động dục 16-17 ngày, mang thai 146-150 ngày. Cừu con: bú sữa đầu 10 ngày, 11-20 ngày bú 3 lần/ngày, 80-90 ngày cai sữa. Dấu hiệu sắp đẻ: bầu vú căng, xuống sữa, âm hộ sưng to. Sau khi đẻ, pha nước đường 1% + muối 0,5% cho cừu mẹ uống để phục hồi sức khỏe.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}

{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/tiemvaccin.png') }}" alt="Tiêm Vacxin">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Tiêm Vacxin</div>--}}
{{--                <div class="social-description">Lịch tiêm phòng bảo vệ cừu</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Tiêm vacxin phòng bệnh than (Anthrax) và tụ huyết trùng (Pasteurellosis) vào tháng 3 và tháng 9 hàng năm. Tiêm vacxin dại khi có dịch bệnh hoặc khi nhập giống mới. Sử dụng vacxin chất lượng cao, tiêm đúng liều lượng theo hướng dẫn bác sĩ thú y.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}

{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/giongcuu.png') }}" alt="Bệnh Thường Gặp">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Bệnh Thường Gặp</div>--}}
{{--                <div class="social-description">Các bệnh phổ biến ở cừu</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Bệnh than (Anthrax): triệu chứng sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh theo chỉ định bác sĩ, kết hợp vệ sinh chuồng trại.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}

{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/ddcuu.png') }}" alt="Dinh Dưỡng">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Dinh Dưỡng</div>--}}
{{--                <div class="social-description">Chế độ ăn và bổ sung dinh dưỡng</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Ăn cỏ tươi, rơm, củ quả như cà rốt và khoai lang. Bổ sung 0,1-0,3kg thức ăn tinh/ngày. Cần 5,5-9g canxi, 2,9-5g phốt pho, 3.500-11.000 UI Vitamin D hàng ngày. Tránh nước tù đọng, bổ sung Vitamin A, D vào mùa đông.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}

{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/sinhsancuu.png') }}" alt="Sinh Sản">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Sinh Sản</div>--}}
{{--                <div class="social-description">Quy trình sinh sản và chăm sóc cừu con</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Cừu cái mang thai 146-150 ngày, đẻ 1-2 con/lứa. Tỷ lệ đực/cái 1/25, đực giống 8-9 tháng tuổi mới phối. Sau đẻ, giữ cừu mẹ và con trong khu vực ấm áp, cung cấp thức ăn giàu đạm.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}

{{--        <div class="social-card" onclick="toggleCard(this)">--}}
{{--            <div class="card-header">--}}
{{--                <img src="{{ asset('images/lich.png') }}" alt="Lịch Theo Dõi">--}}
{{--            </div>--}}
{{--            <div class="card-content">--}}
{{--                <div class="social-title">Lịch Theo Dõi</div>--}}
{{--                <div class="social-description">Lịch trình chăm sóc định kỳ</div>--}}
{{--                <div class="expandable-content">--}}
{{--                    <p>Tháng 1: kiểm tra sức khỏe tổng quát. Tháng 3, 9: tiêm vacxin. Hàng tuần: vệ sinh chuồng, kiểm tra nước uống. Hàng tháng: tẩy giun, bổ sung khoáng chất.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="expand-icon"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="footer">--}}
{{--        <p class="footer-text">© 2025 Làng Du Lịch Sinh Thái Ông Đề. Tất cả quyền được bảo lưu.</p>--}}
{{--        <p class="footer-text">Công Ty TNHH Làng Du Lịch Sinh Thái Ông Đề.</p>--}}
{{--        <p class="footer-text">Địa chỉ: Số 168-AB1, Đường Xuân Thuỷ, Khu Dân Cư Hồng Phát, Phường An Bình, Thành Phố Cần Thơ, Việt Nam.</p>--}}
{{--        <p class="footer-text">Mã Số Thuế: 1801218923.</p>--}}
{{--        <p class="footer-text">Hotline: 0931 852 113.</p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script>--}}
{{--    function toggleCard(cardElement) {--}}
{{--        const expandableContent = cardElement.querySelector('.expandable-content');--}}
{{--        const isExpanded = cardElement.classList.contains('expanded');--}}

{{--        document.querySelectorAll('.social-card.expanded').forEach(card => {--}}
{{--            if (card !== cardElement) {--}}
{{--                card.classList.remove('expanded');--}}
{{--                card.querySelector('.expandable-content').classList.remove('expanded');--}}
{{--            }--}}
{{--        });--}}

{{--        if (isExpanded) {--}}
{{--            cardElement.classList.remove('expanded');--}}
{{--            expandableContent.classList.remove('expanded');--}}
{{--        } else {--}}
{{--            cardElement.classList.add('expanded');--}}
{{--            expandableContent.classList.add('expanded');--}}
{{--        }--}}
{{--    }--}}

{{--    const animalData = {--}}
{{--        cuu: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Cừu",--}}
{{--            subtitle: "Tất cả thông tin cần thiết để chăm sóc cừu hiệu quả",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamcuu.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho cừu",--}}
{{--                    fullDesc: "Cừu mẹ: chu kỳ động dục 16-17 ngày, mang thai 146-150 ngày. Cừu con: bú sữa đầu 10 ngày, 11-20 ngày bú 3 lần/ngày, 80-90 ngày cai sữa. Dấu hiệu sắp đẻ: bầu vú căng, xuống sữa, âm hộ sưng to. Sau khi đẻ, pha nước đường 1% + muối 0,5% cho cừu mẹ uống để phục hồi sức khỏe."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ cừu",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh than (Anthrax) và tụ huyết trùng (Pasteurellosis) vào tháng 3 và tháng 9 hàng năm. Tiêm vacxin dại khi có dịch bệnh hoặc khi nhập giống mới. Sử dụng vacxin chất lượng cao, tiêm đúng liều lượng theo hướng dẫn bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "giongcuu.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở cừu",--}}
{{--                    fullDesc: "Bệnh than (Anthrax): triệu chứng sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh theo chỉ định bác sĩ, kết hợp vệ sinh chuồng trại."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "ddcuu.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",--}}
{{--                    fullDesc: "Ăn cỏ tươi, rơm, củ quả như cà rốt và khoai lang. Bổ sung 0,1-0,3kg thức ăn tinh/ngày. Cần 5,5-9g canxi, 2,9-5g phốt pho, 3.500-11.000 UI Vitamin D hàng ngày. Tránh nước tù đọng, bổ sung Vitamin A, D vào mùa đông."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsancuu.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc cừu con",--}}
{{--                    fullDesc: "Cừu cái mang thai 146-150 ngày, đẻ 1-2 con/lứa. Tỷ lệ đực/cái 1/25, đực giống 8-9 tháng tuổi mới phối. Sau đẻ, giữ cừu mẹ và con trong khu vực ấm áp, cung cấp thức ăn giàu đạm."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 1: kiểm tra sức khỏe tổng quát. Tháng 3, 9: tiêm vacxin. Hàng tuần: vệ sinh chuồng, kiểm tra nước uống. Hàng tháng: tẩy giun, bổ sung khoáng chất."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        // nai: {--}}
{{--        //     title: "Hướng Dẫn Chăm Sóc Nai",--}}
{{--        //     subtitle: "Kiến thức chăm sóc nai trong vườn thú",--}}
{{--        //     guides: [--}}
{{--        //         {--}}
{{--        //             icon: "chamnai.png",--}}
{{--        //             title: "Chăm Sóc",--}}
{{--        //             shortDesc: "Quy trình chăm sóc hàng ngày cho nai",--}}
{{--        //             fullDesc: "Tránh tiếng ồn, chuyển động đột ngột. Kiểm tra sức khỏe thường xuyên. Vệ sinh chuồng hàng ngày, thay nước sạch. Quan sát hành vi để phát hiện sớm bệnh tật."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "vaccin.png",--}}
{{--        //             title: "Tiêm Vacxin",--}}
{{--        //             shortDesc: "Lịch tiêm phòng bảo vệ nai",--}}
{{--        //             fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và viêm phổi vào đầu và cuối mùa mưa. Tiêm vacxin dại khi có dịch. Tham khảo ý kiến bác sĩ thú y để đảm bảo liều lượng."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "benhthuonggapnai.png",--}}
{{--        //             title: "Bệnh Thường Gặp",--}}
{{--        //             shortDesc: "Các bệnh phổ biến ở nai",--}}
{{--        //             fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Viêm phổi: ho, khó thở. Ký sinh trùng: gầy yếu, rụng lông. Điều trị bằng thuốc theo chỉ định và vệ sinh môi trường."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "thucanai.png",--}}
{{--        //             title: "Dinh Dưỡng",--}}
{{--        //             shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",--}}
{{--        //             fullDesc: "Ăn cỏ, lá cây, rau củ, trái cây như táo. Bổ sung thức ăn viên chuyên dụng. Cần nước sạch liên tục, chia nhỏ bữa ăn trong ngày để tránh đầy hơi."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "sinhsannai.png",--}}
{{--        //             title: "Sinh Sản",--}}
{{--        //             shortDesc: "Quy trình sinh sản và chăm sóc nai con",--}}
{{--        //             fullDesc: "Nai cái mang thai 240-250 ngày, đẻ 1 con/lứa. Nai đực phối giống từ 2 tuổi. Sau đẻ, giữ nai mẹ và con trong khu vực yên tĩnh, cung cấp thức ăn giàu năng lượng."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "lich.png",--}}
{{--        //             title: "Lịch Theo Dõi",--}}
{{--        //             shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--        //             fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra chân và móng. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa khô: tăng cường nước uống."--}}
{{--        //         }--}}
{{--        //     ]--}}
{{--        // },--}}
{{--        tho: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Thỏ",--}}
{{--            subtitle: "Chăm sóc thỏ cảnh và thỏ giống hiệu quả",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamtho.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho thỏ",--}}
{{--                    fullDesc: "Vệ sinh chuồng hàng ngày, tắm rửa định kỳ khi cần. Cắt móng thường xuyên, chải lông để tránh rụng lông quá nhiều. Kiểm tra sức khỏe đều đặn, đặc biệt sau sinh."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ thỏ",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh dại và myxomatosis từ 6-8 tuần tuổi, nhắc lại mỗi 6 tháng. Sử dụng vacxin phù hợp với giống thỏ, tiêm bởi bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tho.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở thỏ",--}}
{{--                    fullDesc: "Myxomatosis: sưng mắt, tai. Tiêu chảy: do thức ăn không sạch. Rụng lông: stress hoặc ký sinh trùng. Điều trị sớm với thuốc chuyên dụng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "ddtho.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",--}}
{{--                    fullDesc: "Cỏ khô, rau xanh như xà lách, cà rốt. Tránh rau có độ ẩm cao như cải xanh. Nước sạch luôn có sẵn, bổ sung thức ăn viên chuyên dụng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsantho.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc thỏ con",--}}
{{--                    fullDesc: "Thỏ cái mang thai 30-32 ngày, đẻ 4-8 con/lứa. Thỏ đực phối từ 5-6 tháng tuổi. Sau đẻ, giữ khu vực sạch sẽ, cung cấp thức ăn giàu canxi."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra răng và móng. Hàng tháng: tẩy giun, bổ sung vitamin C. Mùa hè: tăng cường nước mát."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        // casau: {--}}
{{--        //     title: "Hướng Dẫn Chăm Sóc Cá Sấu",--}}
{{--        //     subtitle: "An toàn và hiệu quả trong chăm sóc cá sấu",--}}
{{--        //     guides: [--}}
{{--        //         {--}}
{{--        //             icon: "chamcasau.png",--}}
{{--        //             title: "Chăm Sóc",--}}
{{--        //             shortDesc: "Quy trình chăm sóc an toàn cho cá sấu",--}}
{{--        //             fullDesc: "Kiểm tra sức khỏe từ xa, quan sát hành vi hàng ngày. Vệ sinh môi trường nước thường xuyên, thay nước định kỳ. Theo dõi nhiệt độ và chất lượng nước để đảm bảo ổn định."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "vaccin.png",--}}
{{--        //             title: "Tiêm Vacxin",--}}
{{--        //             shortDesc: "Lịch tiêm phòng bảo vệ cá sấu",--}}
{{--        //             fullDesc: "Tiêm vacxin phòng bệnh viêm da và nhiễm trùng da vào đầu mùa xuân. Tiêm nhắc lại hàng năm, ưu tiên cá sấu non. Tham khảo chuyên gia thủy sản."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "benhthuonggapcasau.png",--}}
{{--        //             title: "Bệnh Thường Gặp",--}}
{{--        //             shortDesc: "Các bệnh phổ biến ở cá sấu",--}}
{{--        //             fullDesc: "Viêm da: da sần sùi, đỏ. Nhiễm trùng nước: lơ lửng, yếu. Ký sinh trùng: gầy yếu, chậm lớn. Điều trị bằng thuốc chuyên dụng và cải thiện môi trường nước."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "thucancasau.png",--}}
{{--        //             title: "Dinh Dưỡng",--}}
{{--        //             shortDesc: "Chế độ dinh dưỡng cho cá sấu",--}}
{{--        //             fullDesc: "Cá tươi, thịt gia cầm, thịt bò. Cho ăn 2-3 lần/tuần, lượng 5-10% trọng lượng cơ thể. Tránh thức ăn ôi thiu, sử dụng que dài khi cho ăn."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "sinhsancasau.png",--}}
{{--        //             title: "Sinh Sản",--}}
{{--        //             shortDesc: "Quy trình sinh sản và chăm sóc cá sấu con",--}}
{{--        //             fullDesc: "Cá sấu cái đẻ 20-60 trứng sau 30-40 ngày, ấp 60-90 ngày. Sau nở, giữ cá con trong nước ấm 28-30°C, cung cấp thức ăn nhỏ như cá con."--}}
{{--        //         },--}}
{{--        //         {--}}
{{--        //             icon: "lich.png",--}}
{{--        //             title: "Lịch Theo Dõi",--}}
{{--        //             shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--        //             fullDesc: "Tháng 3, 9: kiểm tra sức khỏe. Hàng tuần: vệ sinh hồ nước. Hàng tháng: đo nhiệt độ, bổ sung khoáng. Mùa mưa: kiểm tra hệ thống thoát nước."--}}
{{--        //         }--}}
{{--        //     ]--}}
{{--        // },--}}
{{--        dadieu: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Đà Điều",--}}
{{--            subtitle: "Chăm sóc đà điều trong môi trường nuôi nhốt",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamdadieu.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho đà điều",--}}
{{--                    fullDesc: "Tránh stress, tiếng ồn lớn. Kiểm tra chân thường xuyên vì dễ bị thương. Vệ sinh khu vực sống hàng ngày. Quan sát hành vi sinh sản để hỗ trợ kịp thời."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ đà điều",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và cúm gia cầm vào đầu và cuối mùa khô. Tiêm nhắc lại mỗi năm, ưu tiên chim non. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapdadieu.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở đà điều",--}}
{{--                    fullDesc: "Cúm gia cầm: sốt, tiêu chảy. Chân bị thương: sưng, khó đi. Ký sinh trùng: rụng lông, gầy yếu. Điều trị bằng thuốc và cải thiện môi trường."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucandadieu.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng đà điều",--}}
{{--                    fullDesc: "Thức ăn viên chuyên dụng, rau xanh, trái cây như chuối. Tránh thức ăn cứng, sắc nhọn. Nước sạch luôn có sẵn, bổ sung protein vào mùa sinh sản."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsandadieu.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc đà điều con",--}}
{{--                    fullDesc: "Đà điều đẻ 8-15 trứng/lứa, ấp 40-50 ngày. Sau nở, giữ khu vực ấm áp, cung cấp thức ăn mềm như cám trộn rau. Tách chim con khỏi chim lớn."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 4, 10: tiêm vacxin. Hàng tuần: kiểm tra chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa hè: tăng bóng mát."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        cong: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Công",--}}
{{--            subtitle: "Chăm sóc công trong vườn thú và trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamcong.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho công",--}}
{{--                    fullDesc: "Vệ sinh chuồng hàng ngày, thay cát lót. Kiểm tra sức khỏe thường xuyên. Tạo môi trường yên tĩnh cho sinh sản. Cắt móng định kỳ để tránh nhiễm trùng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ công",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và đậu gà vào tháng 2 và tháng 8. Tiêm nhắc lại mỗi 6 tháng, ưu tiên công con. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapcong.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở công",--}}
{{--                    fullDesc: "Newcastle: khó thở, tiêu chảy. Đậu gà: mụn nước trên da. Ký sinh trùng: rụng lông. Điều trị bằng vacxin và vệ sinh chuồng trại."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucancong.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho công",--}}
{{--                    fullDesc: "Thóc, ngô, rau xanh, côn trùng nhỏ. Bổ sung protein trong mùa sinh sản. Nước sạch thường xuyên, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsancong.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc công con",--}}
{{--                    fullDesc: "Công mái đẻ 4-8 trứng/lứa, ấp 28-30 ngày. Sau nở, giữ công con trong khu vực ấm áp, cung cấp thức ăn mềm như cám trộn ngô."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 3, 9: tiêm vacxin. Hàng tuần: kiểm tra lông và móng. Hàng tháng: tẩy giun, bổ sung canxi. Mùa đông: tăng nhiệt độ chuồng."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        chim: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Chim",--}}
{{--            subtitle: "Chăm sóc các loài chim cảnh và chim nuôi",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamchim.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho chim",--}}
{{--                    fullDesc: "Vệ sinh lồng hàng ngày, thay nước sạch. Cung cấp cành cây để chim đậu. Tránh tiếng ồn lớn và ánh sáng mạnh. Kiểm tra sức khỏe định kỳ, đặc biệt là lông và mắt."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ chim",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và cúm gia cầm vào tháng 3 và 9. Tiêm nhắc lại mỗi 6 tháng, ưu tiên chim non. Tham khảo bác sĩ thú y để đảm bảo liều lượng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapchim.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở chim",--}}
{{--                    fullDesc: "Cúm gia cầm: sốt, lông xù. Ký sinh trùng: rụng lông, gầy yếu. Nhiễm trùng hô hấp: hắt hơi, khó thở. Điều trị bằng thuốc và cải thiện môi trường sống."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucanchim.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho chim",--}}
{{--                    fullDesc: "Hạt ngũ cốc, trái cây, rau xanh. Bổ sung cát sỏi để hỗ trợ tiêu hóa. Nước sạch luôn có sẵn, tránh thức ăn mốc. Cho ăn 2-3 lần/ngày."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsanchim.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc chim con",--}}
{{--                    fullDesc: "Chim mái đẻ 3-6 trứng/lứa, ấp 14-21 ngày. Sau nở, giữ khu vực ấm áp, cung cấp thức ăn mềm như cám trộn. Tách chim con khi đủ lông."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra lông và mắt. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa đông: tăng nhiệt độ lồng."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        ga: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Gà",--}}
{{--            subtitle: "Chăm sóc gà hiệu quả trong trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamga.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho gà",--}}
{{--                    fullDesc: "Vệ sinh chuồng trại hàng ngày, thay nước sạch. Cung cấp không gian đủ rộng để gà di chuyển. Kiểm tra sức khỏe định kỳ, đặc biệt là mào và chân."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ gà",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle, Gumboro và cúm gia cầm từ 1-2 tuần tuổi, nhắc lại mỗi 6 tháng. Sử dụng vacxin chất lượng cao, theo chỉ dẫn bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapga.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở gà",--}}
{{--                    fullDesc: "Newcastle: khó thở, tiêu chảy. Gumboro: suy giảm miễn dịch. Cúm gia cầm: sốt, giảm đẻ. Điều trị bằng thuốc và vệ sinh chuồng trại kỹ lưỡng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucanga.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho gà",--}}
{{--                    fullDesc: "Cám gà, ngô, thóc, rau xanh. Bổ sung canxi và protein trong giai đoạn đẻ trứng. Nước sạch liên tục, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsanga.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc gà con",--}}
{{--                    fullDesc: "Gà mái đẻ 10-20 trứng/lứa, ấp 21 ngày. Sau nở, giữ gà con trong khu vực ấm 32-35°C, cung cấp cám khởi đầu giàu protein."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra chuồng và sức khỏe. Hàng tháng: tẩy giun, bổ sung khoáng chất. Mùa mưa: kiểm tra độ ẩm chuồng."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        de: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Dê",--}}
{{--            subtitle: "Chăm sóc dê hiệu quả trong môi trường trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamde.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho dê",--}}
{{--                    fullDesc: "Vệ sinh chuồng hàng ngày, đảm bảo thông thoáng. Kiểm tra sức khỏe định kỳ, đặc biệt là móng và răng. Cung cấp nước sạch và tránh stress cho dê."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ dê",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh than và tụ huyết trùng vào tháng 3 và 9. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y để đảm bảo liều lượng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapde.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở dê",--}}
{{--                    fullDesc: "Bệnh than: sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: tiêu chảy, giảm cân. Điều trị bằng kháng sinh và vệ sinh chuồng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucande.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho dê",--}}
{{--                    fullDesc: "Cỏ tươi, lá cây, thức ăn tinh 0,2-0,4kg/ngày. Bổ sung canxi, phốt pho và vitamin A, D. Nước sạch liên tục, tránh thức ăn mốc hoặc ôi thiu."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsande.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc dê con",--}}
{{--                    fullDesc: "Dê cái mang thai 145-155 ngày, đẻ 1-3 con/lứa. Dê đực phối giống từ 8 tháng tuổi. Sau đẻ, giữ khu vực ấm áp, cung cấp thức ăn giàu dinh dưỡng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra móng và răng. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa khô: tăng cường nước uống."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        bo: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Bò",--}}
{{--            subtitle: "Chăm sóc bò hiệu quả trong trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chambo.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho bò",--}}
{{--                    fullDesc: "Vệ sinh chuồng trại hàng ngày, đảm bảo khô ráo. Kiểm tra sức khỏe định kỳ, đặc biệt là chân và dạ dày. Cung cấp không gian rộng để bò di chuyển."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ bò",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và tụ huyết trùng vào tháng 3 và 9. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapbo.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở bò",--}}
{{--                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Tụ huyết trùng: khó thở, sưng cổ. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh và vệ sinh chuồng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucanbo.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho bò",--}}
{{--                    fullDesc: "Cỏ tươi, rơm, thức ăn tinh 1-2kg/ngày. Bổ sung canxi, phốt pho, vitamin A, D. Nước sạch liên tục, chia nhỏ bữa ăn để tránh đầy hơi."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsanbo.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc bò con",--}}
{{--                    fullDesc: "Bò cái mang thai 280-290 ngày, đẻ 1 con/lứa. Bò đực phối giống từ 18 tháng tuổi. Sau đẻ, giữ khu vực sạch sẽ, cung cấp thức ăn giàu protein."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra chân và dạ dày. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa mưa: kiểm tra độ ẩm chuồng."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        trau: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Trâu",--}}
{{--            subtitle: "Chăm sóc trâu hiệu quả trong trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamtrau.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho trâu",--}}
{{--                    fullDesc: "Vệ sinh chuồng trại hàng ngày, cung cấp bãi tắm nước. Kiểm tra sức khỏe định kỳ, đặc biệt là móng và da. Tránh stress và tiếng ồn lớn."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ trâu",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và tụ huyết trùng vào tháng 2 và 8. Tiêm vacxin dại khi cần. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggaptrau.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở trâu",--}}
{{--                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Tụ huyết trùng: khó thở, sưng cổ. Giun sán: gầy yếu, tiêu chảy. Điều trị bằng thuốc và vệ sinh chuồng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucantrau.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho trâu",--}}
{{--                    fullDesc: "Cỏ tươi, rơm, lá cây. Bổ sung thức ăn tinh 1-1,5kg/ngày. Cần nước sạch liên tục, bổ sung muối và khoáng chất. Tránh thức ăn ôi thiu."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsantrau.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc trâu con",--}}
{{--                    fullDesc: "Trâu cái mang thai 300-330 ngày, đẻ 1 con/lứa. Trâu đực phối giống từ 2 tuổi. Sau đẻ, giữ khu vực khô ráo, cung cấp thức ăn giàu năng lượng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 3, 9: tiêm vacxin. Hàng tuần: kiểm tra móng và da. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa khô: tăng cường nước uống."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        huou: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Hươu",--}}
{{--            subtitle: "Chăm sóc hươu trong môi trường vườn thú",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamhuou.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho hươu",--}}
{{--                    fullDesc: "Tránh tiếng ồn và chuyển động đột ngột. Kiểm tra sừng và chân định kỳ. Vệ sinh chuồng hàng ngày, cung cấp không gian rộng để hươu di chuyển."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ hươu",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và viêm phổi vào tháng 2 và 8. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggaphuou.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở hươu",--}}
{{--                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Viêm phổi: ho, khó thở. Ký sinh trùng: rụng lông, gầy yếu. Điều trị bằng thuốc và vệ sinh môi trường."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucanhuou.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho hươu",--}}
{{--                    fullDesc: "Cỏ tươi, lá cây, rau củ như cà rốt. Bổ sung thức ăn viên chuyên dụng. Nước sạch liên tục, chia nhỏ bữa ăn để tránh đầy hơi."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsanhuou.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc hươu con",--}}
{{--                    fullDesc: "Hươu cái mang thai 230-240 ngày, đẻ 1 con/lứa. Hươu đực phối giống từ 2 tuổi. Sau đẻ, giữ khu vực yên tĩnh, cung cấp thức ăn giàu năng lượng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra sừng và chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa khô: tăng cường nước uống."--}}
{{--                }--}}
{{--            ]--}}
{{--        },--}}
{{--        heotoc: {--}}
{{--            title: "Hướng Dẫn Chăm Sóc Heo Tộc",--}}
{{--            subtitle: "Chăm sóc heo tộc trong môi trường trang trại",--}}
{{--            guides: [--}}
{{--                {--}}
{{--                    icon: "chamheotoc.png",--}}
{{--                    title: "Chăm Sóc",--}}
{{--                    shortDesc: "Quy trình chăm sóc hàng ngày cho heo tộc",--}}
{{--                    fullDesc: "Vệ sinh chuồng hàng ngày, đảm bảo khô ráo. Kiểm tra sức khỏe định kỳ, đặc biệt là da và chân. Cung cấp không gian để heo vận động tự nhiên."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "tiemvaccin.png",--}}
{{--                    title: "Tiêm Vacxin",--}}
{{--                    shortDesc: "Lịch tiêm phòng bảo vệ heo tộc",--}}
{{--                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và dịch tả lợn vào tháng 3 và 9. Tiêm nhắc lại mỗi 6 tháng. Tham khảo bác sĩ thú y."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "benhthuonggapheotoc.png",--}}
{{--                    title: "Bệnh Thường Gặp",--}}
{{--                    shortDesc: "Các bệnh phổ biến ở heo tộc",--}}
{{--                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Dịch tả lợn: sốt cao, tiêu chảy. Giun sán: gầy yếu, chậm lớn. Điều trị bằng thuốc và vệ sinh chuồng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "thucanheotoc.png",--}}
{{--                    title: "Dinh Dưỡng",--}}
{{--                    shortDesc: "Chế độ dinh dưỡng cho heo tộc",--}}
{{--                    fullDesc: "Cám, rau xanh, củ quả như khoai lang, bí đỏ. Bổ sung protein và khoáng chất. Nước sạch liên tục, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "sinhsanheotoc.png",--}}
{{--                    title: "Sinh Sản",--}}
{{--                    shortDesc: "Quy trình sinh sản và chăm sóc heo con",--}}
{{--                    fullDesc: "Heo cái mang thai 110-120 ngày, đẻ 6-12 con/lứa. Heo đực phối giống từ 8 tháng tuổi. Sau đẻ, giữ khu vực ấm áp, cung cấp thức ăn giàu dinh dưỡng."--}}
{{--                },--}}
{{--                {--}}
{{--                    icon: "lich.png",--}}
{{--                    title: "Lịch Theo Dõi",--}}
{{--                    shortDesc: "Lịch trình chăm sóc định kỳ",--}}
{{--                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra da và chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa mưa: kiểm tra độ ẩm chuồng."--}}
{{--                }--}}
{{--            ]--}}
{{--        }--}}
{{--    };--}}

{{--    function selectAnimal(animalKey, tabElement) {--}}
{{--        const data = animalData[animalKey];--}}

{{--        document.querySelectorAll('.tab-item').forEach(item => item.classList.remove('active'));--}}
{{--        tabElement.classList.add('active');--}}

{{--        document.getElementById('mainTitle').textContent = data.title;--}}
{{--        document.getElementById('subtitle').textContent = data.subtitle;--}}

{{--        document.querySelectorAll('.social-card.expanded').forEach(card => {--}}
{{--            card.classList.remove('expanded');--}}
{{--            card.querySelector('.expandable-content').classList.remove('expanded');--}}
{{--        });--}}

{{--        const socialGrid = document.getElementById('socialGrid');--}}
{{--        socialGrid.innerHTML = data.guides.map(guide => `--}}
{{--            <div class="social-card" onclick="toggleCard(this)">--}}
{{--                <div class="card-header">--}}
{{--                    <img src="{{ asset('images/${guide.icon}') }}" alt="${guide.title}">--}}
{{--                </div>--}}
{{--                <div class="card-content">--}}
{{--                    <div class="social-title">${guide.title}</div>--}}
{{--                    <div class="social-description">${guide.shortDesc}</div>--}}
{{--                    <div class="expandable-content">--}}
{{--                        <p>${guide.fullDesc}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="expand-icon"></div>--}}
{{--            </div>--}}
{{--        `).join('');--}}
{{--    }--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
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

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

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
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.7; }
            33% { transform: translateY(-20px) rotate(120deg) scale(1.1); opacity: 1; }
            66% { transform: translateY(10px) rotate(240deg) scale(0.9); opacity: 0.8; }
        }

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
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            50% { transform: translate(-50%, -50%) scale(2); opacity: 0.2; }
        }

        .container {
            max-width: 1000px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 10;
        }

        .container p {
            color: white;
        }
        .card-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .social-card:hover .card-header img {
            transform: scale(1.1);
        }
        .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 32px;
            letter-spacing: -0.02em;
            background: linear-gradient(-45deg, #ffffff, #ffdd59, #ffd700, #32cd32, #00ff00, #228b22, #ff8c00, #ffffff);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeIn 1s ease-out 0.3s both, gradientText 6s ease infinite;
            text-align: center;
        }

        .menu-section {
            margin-bottom: 40px;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        .tab-menu {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 100%;
            overflow-x: auto;
            position: relative;
        }

        .tab-item {
            padding: 12px 20px;
            border-radius: 16px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            white-space: nowrap;
            min-width: fit-content;
        }

        .tab-item:hover {
            color: white;
            transform: translateY(-2px);
        }

        .tab-item.active {
            background: rgba(255, 255, 255, 0.95);
            color: #1f2937;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .tab-item.active::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            border-radius: 18px;
            z-index: -1;
            opacity: 0.7;
            animation: borderGlow 2s linear infinite;
        }

        .more-menu-section {
            margin: 20px 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .more-item {
            padding: 12px 20px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            white-space: nowrap;
        }

        .more-item:hover {
            color: white;
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
        }

        .more-item.active {
            background: rgba(255, 255, 255, 0.95);
            color: #1f2937;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        @keyframes borderGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section {
            margin-bottom: 24px;
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
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
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
            transition: all 0.5s ease;
        }

        @keyframes gradientText {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .subtitle {
            font-size: 1.25rem;
            color: white;
            margin-bottom: 48px;
            font-weight: 400;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .social-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 16px;
            padding: 0;
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out both;
            cursor: pointer;
        }

        .social-card:nth-child(1) { animation-delay: 0.8s; }
        .social-card:nth-child(2) { animation-delay: 1s; }
        .social-card:nth-child(3) { animation-delay: 1.2s; }
        .social-card:nth-child(4) { animation-delay: 1.4s; }
        .social-card:nth-child(5) { animation-delay: 1.6s; }
        .social-card:nth-child(6) { animation-delay: 1.8s; }

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

        .card-header {
            width: 100%;
            height: 120px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-header .icon {
            font-size: 3rem;
            color: white;
            opacity: 0.8;
        }

        .card-content {
            padding: 20px;
            text-align: left;
        }

        .social-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            text-align: center;
        }

        .social-description {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
            line-height: 1.5;
        }

        .expandable-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
            background: rgba(249, 250, 251, 0.8);
            margin: 12px -20px 0 -20px;
            border-radius: 0 0 16px 16px;
        }

        .expandable-content.expanded {
            max-height: 800px;
            padding: 20px;
        }

        .expandable-content p {
            color: #374151;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0 0 12px 0;
            text-align: justify;
        }

        .expandable-content ul {
            margin: 8px 0;
            padding-left: 20px;
        }

        .expandable-content li {
            color: #374151;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 4px 0;
        }

        .expand-icon {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 24px;
            height: 24px;
            background: rgba(107, 114, 128, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            transition: all 0.3s ease;
            z-index: 5;
        }

        .expand-icon::before {
            content: '+';
            transition: transform 0.3s ease;
        }

        .social-card.expanded .expand-icon::before {
            content: '−';
            transform: rotate(180deg);
        }

        .social-card.expanded .expand-icon {
            background: rgba(107, 114, 128, 1);
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

        @media (max-width: 768px) {
            body {
                justify-content: flex-start;
                padding: 40px 16px 20px;
            }

            .container {
                padding: 0;
                margin-top: 20px;
            }

            .tab-menu {
                gap: 6px;
                padding: 6px;
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .tab-menu::-webkit-scrollbar {
                display: none;
            }

            .tab-item, .more-item {
                padding: 10px 16px;
                font-size: 0.85rem;
                min-width: 120px;
                text-align: center;
            }

            .header-title {
                font-size: 2rem;
                margin-bottom: 24px;
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

            .social-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-bottom: 32px;
            }

            .card-header {
                height: 100px;
            }

            .card-content {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 30px 10px 20px;
            }

            .tab-menu, .more-menu-section {
                gap: 4px;
                padding: 4px;
            }

            .tab-item, .more-item {
                padding: 8px 12px;
                font-size: 0.8rem;
                min-width: 100px;
            }

            .header-title {
                font-size: 1.7rem;
                margin-bottom: 20px;
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

            .card-header {
                height: 80px;
            }

            .card-content {
                padding: 12px;
            }
        }

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

    <h1 class="header-title" id="headerTitle">Sổ Tay Chăn Nuôi</h1>

    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Ông Đề">
            </div>
        </div>

        <h1 class="header-title" id="headerTitle">Sổ Tay Chăn Nuôi</h1>

        <div class="menu-section">
            <div class="tab-menu">
                <button class="tab-item active" onclick="selectAnimal('cuu', this)">Cừu</button>
                <button class="tab-item" onclick="selectAnimal('huousao', this)">Hươu Sao</button>
                <button class="tab-item" onclick="selectAnimal('de', this)">Dê</button>
                <button class="tab-item" onclick="selectAnimal('tho', this)">Thỏ</button>
                <button class="tab-item" onclick="selectAnimal('chimcong', this)">Chim Công</button>
                <button class="tab-item" onclick="selectAnimal('lele', this)">Le Le</button>
                <button class="tab-item" onclick="selectAnimal('vittroi', this)">Vịt Trời</button>
                <button class="tab-item" onclick="selectAnimal('chonhuong', this)">Chồn Hương</button>
                <button class="tab-item" onclick="selectAnimal('chimtri', this)">Chim Trĩ</button>
                <button class="tab-item" onclick="selectAnimal('galoi', this)">Gà Lôi</button>
            </div>
        </div>

        <!-- Thêm nút "Xem thêm" -->
        <button class="view-more-btn" onclick="toggleMoreMenu()">Xem thêm </button>

        <!-- Container cho menu "more" -->
        <div class="more-menu-container">
            <div class="more-menu-section">
                <button class="more-item" onclick="selectAnimal('dadieu', this)">Đà Điều</button>
                <button class="more-item" onclick="selectAnimal('cho', this)">Chó</button>
                <button class="more-item" onclick="selectAnimal('meo', this)">Mèo</button>
                <button class="more-item" onclick="selectAnimal('rongnammy', this)">Rồng Nam Mỹ</button>
                <button class="more-item" onclick="selectAnimal('dui', this)">Dúi</button>
                <button class="more-item" onclick="selectAnimal('cuadinh', this)">Cua Đình</button>
                <button class="more-item" onclick="selectAnimal('ruacan', this)">Rùa Cạn</button>
                <button class="more-item" onclick="selectAnimal('gaden', this)">Gà Đen</button>
                <button class="more-item" onclick="selectAnimal('cotrang', this)">Cò Trắng</button>
                <button class="more-item" onclick="selectAnimal('trang', this)">Trăng (Cá Betta)</button>
                <button class="more-item" onclick="selectAnimal('khi', this)">Khỉ</button>
                <button class="more-item" onclick="selectAnimal('kyda', this)">Kỳ Đà</button>
                <button class="more-item" onclick="selectAnimal('chimnhong', this)">Chim Nhồng</button>
                <button class="more-item" onclick="selectAnimal('heomoi', this)">Heo Mọi</button>
                <button class="more-item" onclick="selectAnimal('tete', this)">Tê Tê</button>
                <button class="more-item" onclick="selectAnimal('chimquoc', this)">Chim Quốc</button>
                <button class="more-item" onclick="selectAnimal('chimganuoc', this)">Chim Gà Nước</button>
                <button class="more-item" onclick="selectAnimal('bocau', this)">Bồ Câu</button>
                <button class="more-item" onclick="selectAnimal('ngualun', this)">Ngựa Lùn</button>
                <button class="more-item" onclick="selectAnimal('ran', this)">Rắn</button>
                <button class="more-item" onclick="selectAnimal('chim', this)">Các Loại Chim</button>
                <button class="more-item" onclick="selectAnimal('soc', this)">Sóc</button>
                <button class="more-item" onclick="selectAnimal('bosat', this)">Bò Sát</button>
                <button class="more-item" onclick="selectAnimal('chuotcongnhum', this)">Chuột Cống Nhum</button>
                <button class="more-item" onclick="selectAnimal('ech', this)">Ếch</button>
                <button class="more-item" onclick="selectAnimal('enuong', this)">Ến Ương</button>
                <button class="more-item" onclick="selectAnimal('oc', this)">Ốc</button>
                <button class="more-item" onclick="selectAnimal('ca', this)">Các Loại Cá</button>
                <button class="more-item" onclick="selectAnimal('contrung', this)">Các Loại Côn Trùng</button>
            </div>
        </div>



    <h2 class="main-title" id="mainTitle">Hướng Dẫn Chăm Sóc Cừu</h2>
    <p class="subtitle" id="subtitle">Tất cả thông tin cần thiết để chăm sóc cừu hiệu quả</p>

    <div class="social-grid" id="socialGrid">
        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">

                    <img src="{{ asset('images/chamcuu.png') }}" alt="Chăm Sóc">
                      </div>
            <div class="card-content">
                <div class="social-title">Chăm Sóc</div>
                <div class="social-description">Quy trình chăm sóc và môi trường sống</div>
                <div class="expandable-content">
                    <p><strong>Môi trường:</strong> Chuồng trại sạch sẽ, thông thoáng, tránh ẩm ướt. Cần đồng cỏ hoặc khu vực thả để cừu di chuyển.</p>
                    <p><strong>Thức ăn:</strong> Cỏ tươi, cỏ khô, cám, ngũ cốc, bổ sung khoáng chất. Đảm bảo nước sạch liên tục.</p>
                    <p><strong>Chăm sóc:</strong> Cắt lông định kỳ (1-2 lần/năm), kiểm tra ký sinh trùng (giun, ve).</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/tiemvaccin.png') }}" alt="Chăm Sóc">
            </div>
            <div class="card-content">
                <div class="social-title">Tiêm Vắc-xin</div>
                <div class="social-description">Lịch tiêm phòng bảo vệ cừu</div>
                <div class="expandable-content">
                    <p><strong>Vắc-xin:</strong> Tiêm phòng bệnh tụ huyết trùng, đậu cừu, viêm phổi, uốn ván.</p>
                    <p>Lịch tiêm được thực hiện định kỳ theo chỉ định của bác sĩ thú y để đảm bảo hiệu quả phòng bệnh tốt nhất.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/phongbenh.png') }}" alt="Chăm Sóc">
            </div>
            <div class="card-content">
                <div class="social-title">Phòng Bệnh</div>
                <div class="social-description">Các biện pháp phòng ngừa bệnh tật</div>
                <div class="expandable-content">
                    <p><strong>Phòng bệnh:</strong> Vệ sinh chuồng trại, kiểm tra ký sinh trùng định kỳ, cách ly cừu bệnh.</p>
                    <p>Thường xuyên quan sát tình trạng sức khỏe của đàn cừu để phát hiện sớm các dấu hiệu bất thường.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>
    </div>

    <div class="footer">
        <p class="footer-text">© 2025 Làng Du Lịch Sinh Thái Ông Đề. Tất cả quyền được bảo lưu.</p>
        <p class="footer-text">Công Ty TNHH Làng Du Lịch Sinh Thái Ông Đề.</p>
        <p class="footer-text">Địa chỉ: Số 168-AB1, Đường Xuân Thuỷ, Khu Dân Cư Hồng Phát, Phường An Bình, Thành Phố Cần Thơ, Việt Nam.</p>
        <p class="footer-text">Mã Số Thuế: 1801218923.</p>
        <p class="footer-text">Hotline: 0931 852 113.</p>
    </div>
</div>

<script>
    function toggleCard(cardElement) {
        const expandableContent = cardElement.querySelector('.expandable-content');
        const isExpanded = cardElement.classList.contains('expanded');

        document.querySelectorAll('.social-card.expanded').forEach(card => {
            if (card !== cardElement) {
                card.classList.remove('expanded');
                card.querySelector('.expandable-content').classList.remove('expanded');
            }
        });

        if (isExpanded) {
            cardElement.classList.remove('expanded');
            expandableContent.classList.remove('expanded');
        } else {
            cardElement.classList.add('expanded');
            expandableContent.classList.add('expanded');
        }
    }

    const animalData = {
        cuu: {
            title: "Hướng Dẫn Chăm Sóc Cừu",
            subtitle: "Tất cả thông tin cần thiết để chăm sóc cừu hiệu quả",
            guides: [
                {
                    icon: "images/chamcuu.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng trại sạch sẽ, thông thoáng, tránh ẩm ướt. Cần đồng cỏ hoặc khu vực thả để cừu di chuyển.</p><p><strong>Thức ăn:</strong> Cỏ tươi, cỏ khô, cám, ngũ cốc, bổ sung khoáng chất. Đảm bảo nước sạch liên tục.</p><p><strong>Chăm sóc:</strong> Cắt lông định kỳ (1-2 lần/năm), kiểm tra ký sinh trùng (giun, ve).</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ cừu",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng bệnh tụ huyết trùng, đậu cừu, viêm phổi, uốn ván.</p><p>Lịch tiêm được thực hiện định kỳ theo chỉ định của bác sĩ thú y để đảm bảo hiệu quả phòng bệnh tốt nhất.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng trại, kiểm tra ký sinh trùng định kỳ, cách ly cừu bệnh.</p><p>Thường xuyên quan sát tình trạng sức khỏe của đàn cừu để phát hiện sớm các dấu hiệu bất thường.</p>"
                }
            ]
        },
        huousao: {
            title: "Hướng Dẫn Chăm Sóc Hươu Sao",
            subtitle: "Kiến thức chăm sóc hươu sao trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "images/chamhuou.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có khu vực cây cối để trú ẩn. Hàng rào cao để tránh hươu nhảy ra.</p><p><strong>Thức ăn:</strong> Cỏ tươi, lá cây, ngũ cốc, bổ sung khoáng chất và vitamin.</p><p><strong>Chăm sóc:</strong> Kiểm tra sừng (đối với hươu đực), cắt tỉa móng, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ hươu sao",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng bệnh tụ huyết trùng, viêm phổi, uốn ván.</p><p>Lịch tiêm được thực hiện định kỳ theo khuyến cáo của bác sĩ thú y chuyên khoa.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, kiểm tra ký sinh trùng, giữ chuồng khô ráo.</p><p>Hươu sao rất nhạy cảm với stress nên cần môi trường yên tĩnh và ổn định.</p>"
                }
            ]
        },
        de: {
            title: "Hướng Dẫn Chăm Sóc Dê",
            subtitle: "Chăm sóc dê hiệu quả trong môi trường trang trại",
            guides: [
                {
                    icon: "images/chamde.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng cao ráo, thông thoáng, có khu vực leo trèo.</p><p><strong>Thức ăn:</strong> Cỏ, lá cây, cám, bổ sung muối khoáng.</p><p><strong>Chăm sóc:</strong> Cắt móng định kỳ, kiểm tra ký sinh trùng, tắm rửa khi cần.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ dê",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng đậu dê, tụ huyết trùng, viêm phổi, uốn ván.</p><p>Thực hiện tiêm phòng đúng lịch để bảo vệ sức khỏe đàn dê hiệu quả.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, cách ly dê bệnh, kiểm tra giun sán.</p><p>Dê có khả năng kháng bệnh tốt nhưng cần chăm sóc vệ sinh môi trường thường xuyên.</p>"
                }
            ]
        },
        tho: {
            title: "Hướng Dẫn Chăm Sóc Thỏ",
            subtitle: "Chăm sóc thỏ cảnh và thỏ giống hiệu quả",
            guides: [
                {
                    icon: "images/chamtho.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng sạch, khô ráo, tránh gió lùa. Cần không gian để thỏ vận động.</p><p><strong>Thức ăn:</strong> Cỏ khô, rau xanh, thức ăn viên, bổ sung vitamin.</p><p><strong>Chăm sóc:</strong> Kiểm tra răng, móng, lông. Tránh cho ăn rau ướt hoặc thức ăn hỏng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ thỏ",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng bệnh xuất huyết thỏ (VHD), myxomatosis.</p><p>Tiêm phòng từ 6-8 tuần tuổi và nhắc lại định kỳ theo khuyến cáo.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, tránh ẩm ướt, kiểm tra ký sinh trùng.</p><p>Thỏ rất nhạy cảm với môi trường ẩm ướt và thức ăn không sạch.</p>"
                }
            ]
        },
        chimcong: {
            title: "Hướng Dẫn Chăm Sóc Chim Công",
            subtitle: "Chăm sóc chim công trong môi trường vườn thú",
            guides: [
                {
                    icon: "images/thucancong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có không gian để chim công xòe đuôi. Cần khu vực khô ráo.</p><p><strong>Thức ăn:</strong> Ngũ cốc, hạt, rau xanh, côn trùng, bổ sung khoáng chất.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh chuồng, tránh stress.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim công",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng bệnh Newcastle, cúm gia cầm.</p><p>Thực hiện tiêm phòng định kỳ để bảo vệ sức khỏe chim công.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ chuồng sạch, kiểm tra ký sinh trùng, cung cấp nước sạch.</p><p>Chim công cần môi trường sạch sẽ và không gian rộng để phát triển tốt.</p>"
                }
            ]
        },
        lele: {
            title: "Hướng Dẫn Chăm Sóc Le Le",
            subtitle: "Chăm sóc le le trong môi trường có nước",
            guides: [
                {
                    icon: "images/lele.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng gần ao hoặc hồ nước, có khu vực khô để nghỉ ngơi.</p><p><strong>Thức ăn:</strong> Thức ăn viên, lúa, côn trùng, rau xanh.</p><p><strong>Chăm sóc:</strong> Đảm bảo khu vực nước sạch, kiểm tra lông và chân.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ le le",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng cúm gia cầm, dịch tả vịt.</p><p>Tiêm phòng định kỳ để bảo vệ khỏi các bệnh truyền nhiễm nguy hiểm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh khu vực nước, cách ly chim bệnh.</p><p>Quan trọng là giữ nguồn nước sạch và không để ô nhiễm.</p>"
                }
            ]
        },
        vittroi: {
            title: "Hướng Dẫn Chăm Sóc Vịt Trời",
            subtitle: "Chăm sóc vịt trời trong môi trường tự nhiên",
            guides: [
                {
                    icon: "images/vittroi.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Cần ao hoặc hồ nước, chuồng khô ráo để nghỉ ngơi.</p><p><strong>Thức ăn:</strong> Lúa, cám, côn trùng, thực vật thủy sinh.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh khu vực nước.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ vịt trời",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dịch tả vịt, cúm gia cầm.</p><p>Lịch tiêm được điều chỉnh phù hợp với đặc điểm sinh học của vịt trời.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra ký sinh trùng.</p><p>Vịt trời có khả năng thích nghi tốt nhưng cần chú ý về chất lượng nước.</p>"
                }
            ]
        },
        chonhuong: {
            title: "Hướng Dẫn Chăm Sóc Chồn Hương",
            subtitle: "Chăm sóc chồn hương trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "images/chonhuong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng kín, sạch sẽ, có khu vực leo trèo.</p><p><strong>Thức ăn:</strong> Thịt, cá, trái cây, thức ăn viên chuyên dụng.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chồn hương",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dại, bệnh Carre.</p><p>Chồn hương cần được tiêm phòng các bệnh truyền nhiễm nguy hiểm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, vệ sinh chuồng, kiểm tra ký sinh trùng.</p><p>Chồn hương nhạy cảm với stress và cần môi trường ổn định.</p>"
                }
            ]
        },
        chimtri: {
            title: "Hướng Dẫn Chăm Sóc Chim Trĩ",
            subtitle: "Chăm sóc chim trĩ trong môi trường vườn thú",
            guides: [
                {
                    icon: "images/chimtri.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có khu vực cây cối để trú ẩn.</p><p><strong>Thức ăn:</strong> Ngũ cốc, côn trùng, rau xanh, bổ sung khoáng chất.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim trĩ",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm.</p><p>Tiêm phòng định kỳ để bảo vệ chim trĩ khỏi các bệnh truyền nhiễm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ chuồng khô ráo, kiểm tra ký sinh trùng.</p><p>Chim trĩ cần môi trường khô ráo và sạch sẽ để phát triển tốt.</p>"
                }
            ]
        },
        galoi: {
            title: "Hướng Dẫn Chăm Sóc Gà Lôi",
            subtitle: "Chăm sóc gà lôi trong môi trường trang trại",
            guides: [
                {
                    icon: "images/galoi.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có khu vực đất để bới.</p><p><strong>Thức ăn:</strong> Hạt, côn trùng, rau xanh, thức ăn viên.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ gà lôi",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm.</p><p>Thực hiện tiêm phòng đúng lịch để bảo vệ đàn gà lôi.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, cách ly chim bệnh.</p><p>Gà lôi có sức đề kháng tốt nhưng cần vệ sinh môi trường thường xuyên.</p>"
                }
            ]
        },
        dadieu: {
            title: "Hướng Dẫn Chăm Sóc Đà Điều",
            subtitle: "Chăm sóc đà điều trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "images/dadieu.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, đất khô, hàng rào cao.</p><p><strong>Thức ăn:</strong> Cỏ, ngũ cốc, thức ăn viên, bổ sung khoáng chất.</p><p><strong>Chăm sóc:</strong> Kiểm tra chân, lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ đà điều",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, viêm phổi.</p><p>Đà điều cần được tiêm phòng để tránh các bệnh nguy hiểm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, kiểm tra ký sinh trùng.</p><p>Đà điều rất nhạy cảm với stress và cần môi trường yên tĩnh.</p>"
                }
            ]
        },
        cho: {
            title: "Hướng Dẫn Chăm Sóc Chó",
            subtitle: "Chăm sóc các giống chó được giới trẻ yêu thích",
            guides: [
                {
                    icon: "images/cho.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Nhà hoặc chuồng sạch sẽ, có không gian vận động.</p><p><strong>Thức ăn:</strong> Thức ăn khô, thịt, bổ sung vitamin, tránh thức ăn độc (sô-cô-la, hành).</p><p><strong>Chăm sóc:</strong> Tắm rửa, chải lông, cắt móng, kiểm tra tai và răng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chó",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dại, Carre, parvo, viêm gan.</p><p>Tiêm phòng từ 6-8 tuần tuổi và nhắc lại định kỳ.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Kiểm tra bọ chét, ve, vệ sinh nơi ở.</p><p>Chó cần được chăm sóc thường xuyên và kiểm tra sức khỏe định kỳ.</p>"
                }
            ]
        },
        meo: {
            title: "Hướng Dẫn Chăm Sóc Mèo",
            subtitle: "Chăm sóc các giống mèo được giới trẻ yêu thích",
            guides: [
                {
                    icon: "images/meo.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Nhà sạch sẽ, có chỗ leo trèo, hộp vệ sinh.</p><p><strong>Thức ăn:</strong> Thức ăn khô, ướt, bổ sung taurine.</p><p><strong>Chăm sóc:</strong> Chải lông, cắt móng, vệ sinh hộp cát.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ mèo",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dại, FVRCP (bệnh hô hấp, calici, panleukopenia).</p><p>Tiêm phòng từ 8-10 tuần tuổi và nhắc lại hàng năm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Kiểm tra giun, bọ chét, vệ sinh nơi ở.</p><p>Mèo cần môi trường sạch sẽ và được chăm sóc thường xuyên.</p>"
                }
            ]
        },
        rongnammy: {
            title: "Hướng Dẫn Chăm Sóc Rồng Nam Mỹ (Iguana)",
            subtitle: "Chăm sóc iguana trong môi trường terrarium",
            guides: [
                {
                    icon: "images/rong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính rộng, có đèn UVB, nhiệt độ 27-32°C.</p><p><strong>Thức ăn:</strong> Rau xanh, hoa quả, bổ sung canxi.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Đảm bảo nhiệt độ, độ ẩm, kiểm tra ký sinh trùng.</p><p>Rồng Nam Mỹ cần môi trường nhiệt đới ổn định.</p>"
                }
            ]
        },
        dui: {
            title: "Hướng Dẫn Chăm Sóc Dúi",
            subtitle: "Chăm sóc dúi trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "images/dui.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có ống để chui, đất khô.</p><p><strong>Thức ăn:</strong> Củ, rễ cây, ngũ cốc, rau xanh.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ chuồng sạch, kiểm tra giun sán.</p><p>Dúi cần môi trường khô ráo và sạch sẽ.</p>"
                }
            ]
        },
        cuadinh: {
            title: "Hướng Dẫn Chăm Sóc Cua Đình",
            subtitle: "Chăm sóc cua đình trong môi trường nước",
            guides: [
                {
                    icon: "images/cua.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể nước sạch, có khu vực khô để nghỉ.</p><p><strong>Thức ăn:</strong> Cá, tôm, rau xanh, thức ăn viên.</p><p><strong>Chăm sóc:</strong> Kiểm tra mai, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra nấm, ký sinh trùng.</p><p>Cua đình cần nước sạch và môi trường ổn định.</p>"
                }
            ]
        },
        ruacan: {
            title: "Hướng Dẫn Chăm Sóc Rùa Cạn",
            subtitle: "Chăm sóc rùa cạn trong terrarium",
            guides: [
                {
                    icon: "images/rua.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, có đèn UVB, nhiệt độ 25-30°C.</p><p><strong>Thức ăn:</strong> Rau xanh, hoa quả, bổ sung canxi.</p><p><strong>Chăm sóc:</strong> Kiểm tra mai, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Đảm bảo nhiệt độ, độ ẩm, kiểm tra ký sinh trùng.</p><p>Rùa cạn cần môi trường ổn định và ánh sáng UVB.</p>"
                }
            ]
        },
        gaden: {
            title: "Hướng Dẫn Chăm Sóc Gà Đen (Gà H'Mông)",
            subtitle: "Chăm sóc gà đen trong môi trường trang trại",
            guides: [
                {
                    icon: "images/ga.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng thoáng, có khu vực bới đất.</p><p><strong>Thức ăn:</strong> Ngũ cốc, côn trùng, rau xanh.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ gà đen",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm, dịch tả.</p><p>Gà đen cần được tiêm phòng đầy đủ để bảo vệ sức khỏe.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, kiểm tra ký sinh trùng.</p><p>Gà đen có sức đề kháng tốt nhưng cần vệ sinh môi trường.</p>"
                }
            ]
        },
        cotrang: {
            title: "Hướng Dẫn Chăm Sóc Cò Trắng",
            subtitle: "Chăm sóc cò trắng trong môi trường có nước",
            guides: [
                {
                    icon: "images/cotrang.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, gần ao nước.</p><p><strong>Thức ăn:</strong> Cá, côn trùng, thức ăn viên.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh khu vực nước.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ cò trắng",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng cúm gia cầm.</p><p>Cò trắng cần được tiêm phòng để tránh bệnh truyền nhiễm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra ký sinh trùng.</p><p>Cò trắng cần môi trường nước sạch để phát triển tốt.</p>"
                }
            ]
        },
        trang: {
            title: "Hướng Dẫn Chăm Sóc Cá (Cá Betta)",
            subtitle: "Chăm sóc cá betta trong bể cá",
            guides: [
                {
                    icon: "images/ca.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, nước sạch, nhiệt độ 24-28°C.</p><p><strong>Thức ăn:</strong> Thức ăn viên, côn trùng nhỏ, giáp xác.</p><p><strong>Chăm sóc:</strong> Thay nước định kỳ, kiểm tra vây.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, tránh nuôi chung nhiều con đực.</p><p>Cá betta đực có tính hiếu chiến, không nên nuôi chung.</p>"
                }
            ]
        },
        khi: {
            title: "Hướng Dẫn Chăm Sóc Khỉ",
            subtitle: "Chăm sóc khỉ trong môi trường vườn thú",
            guides: [
                {
                    icon: "images/khi.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có cây leo, tránh gió lùa.</p><p><strong>Thức ăn:</strong> Trái cây, rau, hạt, thức ăn viên.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ khỉ",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dại, viêm gan.</p><p>Khỉ cần được tiêm phòng các bệnh truyền nhiễm nguy hiểm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, kiểm tra ký sinh trùng.</p><p><strong>Lưu ý:</strong> Cần giấy phép nuôi tại Việt Nam, hãy kiểm tra quy định địa phương.</p>"
                }
            ]
        },
        kyda: {
            title: "Hướng Dẫn Chăm Sóc Kỳ Đà",
            subtitle: "Chăm sóc kỳ đà trong môi trường terrarium",
            guides: [
                {
                    icon: "images/kyda.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, đèn UVB, nhiệt độ 28-32°C.</p><p><strong>Thức ăn:</strong> Côn trùng, thịt, bổ sung canxi.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Đảm bảo nhiệt độ, độ ẩm, kiểm tra ký sinh trùng.</p><p>Kỳ đà cần môi trường nhiệt đới ổn định.</p>"
                }
            ]
        },
        chimnhong: {
            title: "Hướng Dẫn Chăm Sóc Chim Nhồng",
            subtitle: "Chăm sóc chim nhồng trong môi trường lồng nuôi",
            guides: [
                {
                    icon: "images/chimnhong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Lồng rộng, có chỗ đậu, sạch sẽ.</p><p><strong>Thức ăn:</strong> Hạt, trái cây, côn trùng.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh lồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim nhồng",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm.</p><p>Thực hiện tiêm phòng định kỳ để bảo vệ sức khỏe chim nhồng.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ lồng sạch, kiểm tra ký sinh trùng.</p><p>Chim nhồng cần môi trường sạch sẽ để phát triển tốt.</p>"
                }
            ]
        },
        heomoi: {
            title: "Hướng Dẫn Chăm Sóc Heo Mọi",
            subtitle: "Chăm sóc heo mọi trong môi trường trang trại",
            guides: [
                {
                    icon: "images/chamheotoc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng sạch, có khu vực đất để bới.</p><p><strong>Thức ăn:</strong> Cám, rau, củ, bổ sung khoáng chất.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ heo mọi",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng dịch tả lợn, lở mồm long móng.</p><p>Thực hiện tiêm phòng đúng lịch để bảo vệ sức khỏe đàn heo.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, kiểm tra ký sinh trùng.</p><p>Heo mọi cần môi trường sạch sẽ và thoáng khí.</p>"
                }
            ]
        },
        tete: {
            title: "Hướng Dẫn Chăm Sóc Tê Tê",
            subtitle: "Chăm sóc tê tê trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "images/tete.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng kín, nhiệt độ ổn định, có chỗ trú.</p><p><strong>Thức ăn:</strong> Kiến, mối, thức ăn viên chuyên dụng.</p><p><strong>Chăm sóc:</strong> Kiểm tra vảy, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, kiểm tra ký sinh trùng.</p><p>Tê tê cần môi trường yên tĩnh và ổn định.</p>"
                }
            ]
        },
        chimquoc: {
            title: "Hướng Dẫn Chăm Sóc Chim Quốc",
            subtitle: "Chăm sóc chim quốc trong môi trường vườn thú",
            guides: [
                {
                    icon: "images/chimquoc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có cây cối để trú.</p><p><strong>Thức ăn:</strong> Hạt, côn trùng, trái cây.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim quốc",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm.</p><p>Thực hiện tiêm phòng định kỳ để bảo vệ sức khỏe chim quốc.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ chuồng sạch, kiểm tra ký sinh trùng.</p><p>Chim quốc cần môi trường sạch sẽ và không gian rộng.</p>"
                }
            ]
        },
        chimganuoc: {
            title: "Hướng Dẫn Chăm Sóc Chim Gà Nước",
            subtitle: "Chăm sóc chim gà nước trong môi trường có nước",
            guides: [
                {
                    icon: "images/ganuoc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng gần ao nước, có khu vực khô.</p><p><strong>Thức ăn:</strong> Côn trùng, thực vật thủy sinh, hạt.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh khu vực nước.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim gà nước",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng cúm gia cầm.</p><p>Chim gà nước cần được tiêm phòng để tránh bệnh truyền nhiễm.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra ký sinh trùng.</p><p>Chim gà nước cần môi trường nước sạch để phát triển tốt.</p>"
                }
            ]
        },
        bocau: {
            title: "Hướng Dẫn Chăm Sóc Bồ Câu",
            subtitle: "Chăm sóc bồ câu trong môi trường chuồng nuôi",
            guides: [
                {
                    icon: "images/bocau.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng thoáng, có chỗ đậu.</p><p><strong>Thức ăn:</strong> Ngũ cốc, hạt, rau xanh.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ bồ câu",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, đậu bồ câu.</p><p>Thực hiện tiêm phòng đúng lịch để bảo vệ đàn bồ câu.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Vệ sinh chuồng, kiểm tra ký sinh trùng.</p><p>Bồ câu cần môi trường sạch sẽ và thoáng khí.</p>"
                }
            ]
        },
        ngualun: {
            title: "Hướng Dẫn Chăm Sóc Ngựa Lùn",
            subtitle: "Chăm sóc ngựa lùn trong môi trường trang trại",
            guides: [
                {
                    icon: "images/ngualun.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Chuồng rộng, có đồng cỏ để thả.</p><p><strong>Thức ăn:</strong> Cỏ khô, ngũ cốc, bổ sung khoáng chất.</p><p><strong>Chăm sóc:</strong> Kiểm tra móng, lông, vệ sinh chuồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ ngựa lùn",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng uốn ván, cúm ngựa.</p><p>Ngựa lùn cần được tiêm phòng định kỳ để bảo vệ sức khỏe.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Kiểm tra ký sinh trùng, vệ sinh chuồng.</p><p>Ngựa lùn cần môi trường sạch sẽ và không gian rộng để vận động.</p>"
                }
            ]
        },
        ran: {
            title: "Hướng Dẫn Chăm Sóc Các Loại Rắn",
            subtitle: "Chăm sóc rắn trong môi trường terrarium",
            guides: [
                {
                    icon: "images/ran.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, có đèn sưởi, nhiệt độ 25-30°C.</p><p><strong>Thức ăn:</strong> Chuột, chim nhỏ, tùy loài.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Đảm bảo nhiệt độ, độ ẩm, kiểm tra nấm, ký sinh trùng.</p><p>Rắn cần môi trường ổn định và sạch sẽ.</p>"
                }
            ]
        },
        chim: {
            title: "Hướng Dẫn Chăm Sóc Các Loại Chim",
            subtitle: "Chăm sóc các loài chim trong môi trường lồng nuôi",
            guides: [
                {
                    icon: "images/chimtri.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Lồng rộng, sạch sẽ, có chỗ đậu.</p><p><strong>Thức ăn:</strong> Hạt, trái cây, côn trùng, tùy loài.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, vệ sinh lồng.</p>"
                },
                {
                    icon: "images/tiemvaccin.png",
                    title: "Tiêm Vắc-xin",
                    shortDesc: "Lịch tiêm phòng bảo vệ các loại chim",
                    fullDesc: "<p><strong>Vắc-xin:</strong> Tiêm phòng Newcastle, cúm gia cầm (nếu cần).</p><p>Thực hiện tiêm phòng định kỳ tùy theo loài chim.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ lồng sạch, kiểm tra ký sinh trùng.</p><p>Các loài chim cần môi trường sạch sẽ và không gian thoải mái.</p>"
                }
            ]
        },
        soc: {
            title: "Hướng Dẫn Chăm Sóc Sóc",
            subtitle: "Chăm sóc sóc trong môi trường lồng nuôi",
            guides: [
                {
                    icon: "images/soc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Lồng rộng, có cây leo.</p><p><strong>Thức ăn:</strong> Hạt, trái cây, côn trùng.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh lồng.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Tránh stress, kiểm tra ký sinh trùng.</p><p>Sóc cần môi trường yên tĩnh và không gian vận động.</p>"
                }
            ]
        },
        bosat: {
            title: "Hướng Dẫn Chăm Sóc Các Loại Bò Sát",
            subtitle: "Chăm sóc bò sát trong môi trường terrarium",
            guides: [
                {
                    icon: "images/rong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, đèn UVB, nhiệt độ tùy loài (25-35°C).</p><p><strong>Thức ăn:</strong> Côn trùng, thịt, rau, tùy loài.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Đảm bảo nhiệt độ, độ ẩm, kiểm tra ký sinh trùng.</p><p>Bò sát cần môi trường ổn định và ánh sáng UVB.</p>"
                }
            ]
        },
        chuotcongnhum: {
            title: "Hướng Dẫn Chăm Sóc Chuột Cống Nhum",
            subtitle: "Chăm sóc chuột cống nhum trong môi trường lồng nuôi",
            guides: [
                {
                    icon: "images/chuot.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Lồng rộng, có ống chui, sạch sẽ.</p><p><strong>Thức ăn:</strong> Hạt, rau, trái cây, bổ sung vitamin.</p><p><strong>Chăm sóc:</strong> Kiểm tra lông, móng, vệ sinh lồng.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ lồng sạch, kiểm tra ký sinh trùng.</p><p>Chuột cống nhum cần môi trường sạch sẽ và không gian vận động.</p>"
                }
            ]
        },
        ech: {
            title: "Hướng Dẫn Chăm Sóc Ếch",
            subtitle: "Chăm sóc ếch trong môi trường terrarium",
            guides: [
                {
                    icon: "images/ech.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể có nước và khu vực khô, nhiệt độ 24-28°C.</p><p><strong>Thức ăn:</strong> Côn trùng, giun, thức ăn viên.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra nấm, ký sinh trùng.</p><p>Ếch cần môi trường sạch sẽ và độ ẩm ổn định.</p>"
                }
            ]
        },
        enuong: {
            title: "Hướng Dẫn Chăm Sóc Ến Ương",
            subtitle: "Chăm sóc ến ương trong môi trường terrarium",
            guides: [
                {
                    icon: "images/echuong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể nước sạch, có khu vực khô, nhiệt độ 24-28°C.</p><p><strong>Thức ăn:</strong> Côn trùng, giun, thực vật thủy sinh.</p><p><strong>Chăm sóc:</strong> Kiểm tra da, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra nấm, ký sinh trùng.</p><p>Ến ương cần môi trường sạch sẽ và độ ẩm ổn định.</p>"
                }
            ]
        },
        oc: {
            title: "Hướng Dẫn Chăm Sóc Ốc",
            subtitle: "Chăm sóc ốc trong môi trường terrarium",
            guides: [
                {
                    icon: "images/oc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể ẩm, có đất hoặc cát, nhiệt độ 20-25°C.</p><p><strong>Thức ăn:</strong> Rau xanh, hoa quả, bổ sung canxi.</p><p><strong>Chăm sóc:</strong> Kiểm tra vỏ, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ độ ẩm, kiểm tra ký sinh trùng.</p><p>Ốc cần môi trường ẩm và sạch sẽ.</p>"
                }
            ]
        },
        ca: {
            title: "Hướng Dẫn Chăm Sóc Các Loại Cá",
            subtitle: "Chăm sóc các loài cá trong bể nuôi",
            guides: [
                {
                    icon: "images/caloc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể nước sạch, có máy lọc, nhiệt độ tùy loài (20-30°C).</p><p><strong>Thức ăn:</strong> Thức ăn viên, côn trùng, thực vật, tùy loài.</p><p><strong>Chăm sóc:</strong> Thay nước định kỳ, kiểm tra vây, da.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ nước sạch, kiểm tra nấm, ký sinh trùng.</p><p>Các loài cá cần môi trường nước ổn định và sạch sẽ.</p>"
                }
            ]
        },
        contrung: {
            title: "Hướng Dẫn Chăm Sóc Các Loại Côn Trùng",
            subtitle: "Chăm sóc côn trùng trong môi trường terrarium",
            guides: [
                {
                    icon: "images/contrung.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc và môi trường sống",
                    fullDesc: "<p><strong>Môi trường:</strong> Bể kính, độ ẩm và nhiệt độ tùy loài (20-30°C).</p><p><strong>Thức ăn:</strong> Lá, mật ong, thức ăn chuyên dụng, tùy loài.</p><p><strong>Chăm sóc:</strong> Kiểm tra vỏ, vệ sinh bể.</p>"
                },
                {
                    icon: "images/phongbenh.png",
                    title: "Phòng Bệnh",
                    shortDesc: "Các biện pháp phòng ngừa bệnh tật",
                    fullDesc: "<p><strong>Phòng bệnh:</strong> Giữ môi trường sạch, kiểm tra nấm, ký sinh trùng.</p><p>Côn trùng cần môi trường ổn định và sạch sẽ.</p>"
                }
            ]
        }
    };

    function selectAnimal(animalKey, tabElement) {
        const data = animalData[animalKey];
        if (!data) return;

        document.querySelectorAll('.tab-item, .more-item').forEach(item => item.classList.remove('active'));
        tabElement.classList.add('active');

        document.getElementById('mainTitle').textContent = data.title;
        document.getElementById('subtitle').textContent = data.subtitle;

        document.querySelectorAll('.social-card.expanded').forEach(card => {
            card.classList.remove('expanded');
            card.querySelector('.expandable-content').classList.remove('expanded');
        });

        const socialGrid = document.getElementById('socialGrid');
        socialGrid.innerHTML = data.guides.map(guide => `
                <div class="social-card" onclick="toggleCard(this)">
                    <div class="card-header">
                        <div class="icon">${guide.icon}</div>
                    </div>
                    <div class="card-content">
                        <div class="social-title">${guide.title}</div>
                        <div class="social-description">${guide.shortDesc}</div>
                        <div class="expandable-content">
                            ${guide.fullDesc}
                        </div>
                    </div>
                    <div class="expand-icon"></div>
                </div>
            `).join('');
    }
    function selectAnimal(animal, buttonElement) {
        const data = animalData[animal];
        document.getElementById('mainTitle').textContent = data.title;
        document.getElementById('subtitle').textContent = data.subtitle;

        const socialGrid = document.getElementById('socialGrid');
        socialGrid.innerHTML = '';

        data.guides.forEach(guide => {
            const card = document.createElement('div');
            card.className = 'social-card';
            card.onclick = function() { toggleCard(this); };

            // Kiểm tra xem icon có phải là đường dẫn hình ảnh hay không
            const isImage = guide.icon.includes('.png') || guide.icon.includes('.jpg') || guide.icon.includes('.jpeg');
            const iconContent = isImage
                ? `<img src="${guide.icon}" alt="${guide.title}">` // Loại bỏ inline style
                : guide.icon;

            card.innerHTML = `
            <div class="card-header">
                <div class="icon">${iconContent}</div>
            </div>
            <div class="card-content">
                <div class="social-title">${guide.title}</div>
                <div class="social-description">${guide.shortDesc}</div>
                <div class="expandable-content">${guide.fullDesc}</div>
            </div>
            <div class="expand-icon"></div>
        `;
            socialGrid.appendChild(card);
        });

        document.querySelectorAll('.tab-item, .more-item').forEach(item => item.classList.remove('active'));
        buttonElement.classList.add('active');
    }
    function toggleMoreMenu() {
        const moreMenuSection = document.querySelector('.more-menu-section');
        moreMenuSection.classList.toggle('active');
    }</script>
<style>
    .card-header .icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .social-card:hover .card-header .icon img {
        transform: scale(1.1);
    }
    /* Ẩn menu "more" ban đầu */
    .more-menu-section {
        display: none;
    }

    /* Hiển thị menu khi có class "active" */
    .more-menu-section.active {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin: 20px 0;
    }

    /* Định dạng nút "Xem thêm" */
    .view-more-btn {
        display: block;
        padding: 12px 20px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin: 20px auto;
        width: fit-content;
    }

    .view-more-btn:hover {
        color: white;
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.2);
    }   </style>

</body>
</html>
</body>
</html>
