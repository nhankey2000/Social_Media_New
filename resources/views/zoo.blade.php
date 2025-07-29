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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
            max-height: 400px;
            padding: 20px;
        }

        .expandable-content p {
            color: #374151;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0;
            text-align: justify;
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

            .tab-item {
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

            .logo img {
                width: 120px;
                height: 64px;
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

            .tab-menu {
                gap: 4px;
                padding: 4px;
            }

            .tab-item {
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

            .logo img {
                width: 100px;
                height: 48px;
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

    <h1 class="header-title" id="headerTitle">Hướng Dẫn Chăm Sóc Thú Vườn Thú</h1>

    <div class="menu-section">
        <div class="tab-menu">
            <button class="tab-item active" onclick="selectAnimal('cuu', this)">Cừu</button>
{{--            <button class="tab-item" onclick="selectAnimal('nai', this)">Nai</button>--}}
            <button class="tab-item" onclick="selectAnimal('tho', this)">Thỏ</button>
{{--            <button class="tab-item" onclick="selectAnimal('casau', this)">Cá Sấu</button>--}}
            <button class="tab-item" onclick="selectAnimal('dadieu', this)">Đà Điều</button>
            <button class="tab-item" onclick="selectAnimal('cong', this)">Công</button>
            <button class="tab-item" onclick="selectAnimal('chim', this)">Chim</button>
            <button class="tab-item" onclick="selectAnimal('ga', this)">Gà</button>
            <button class="tab-item" onclick="selectAnimal('de', this)">Dê</button>
            <button class="tab-item" onclick="selectAnimal('bo', this)">Bò</button>
            <button class="tab-item" onclick="selectAnimal('trau', this)">Trâu</button>
            <button class="tab-item" onclick="selectAnimal('huou', this)">Hươu</button>
            <button class="tab-item" onclick="selectAnimal('heotoc', this)">Heo Tộc</button>
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
                <div class="social-description">Quy trình chăm sóc hàng ngày cho cừu</div>
                <div class="expandable-content">
                    <p>Cừu mẹ: chu kỳ động dục 16-17 ngày, mang thai 146-150 ngày. Cừu con: bú sữa đầu 10 ngày, 11-20 ngày bú 3 lần/ngày, 80-90 ngày cai sữa. Dấu hiệu sắp đẻ: bầu vú căng, xuống sữa, âm hộ sưng to. Sau khi đẻ, pha nước đường 1% + muối 0,5% cho cừu mẹ uống để phục hồi sức khỏe.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/tiemvaccin.png') }}" alt="Tiêm Vacxin">
            </div>
            <div class="card-content">
                <div class="social-title">Tiêm Vacxin</div>
                <div class="social-description">Lịch tiêm phòng bảo vệ cừu</div>
                <div class="expandable-content">
                    <p>Tiêm vacxin phòng bệnh than (Anthrax) và tụ huyết trùng (Pasteurellosis) vào tháng 3 và tháng 9 hàng năm. Tiêm vacxin dại khi có dịch bệnh hoặc khi nhập giống mới. Sử dụng vacxin chất lượng cao, tiêm đúng liều lượng theo hướng dẫn bác sĩ thú y.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/giongcuu.png') }}" alt="Bệnh Thường Gặp">
            </div>
            <div class="card-content">
                <div class="social-title">Bệnh Thường Gặp</div>
                <div class="social-description">Các bệnh phổ biến ở cừu</div>
                <div class="expandable-content">
                    <p>Bệnh than (Anthrax): triệu chứng sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh theo chỉ định bác sĩ, kết hợp vệ sinh chuồng trại.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/ddcuu.png') }}" alt="Dinh Dưỡng">
            </div>
            <div class="card-content">
                <div class="social-title">Dinh Dưỡng</div>
                <div class="social-description">Chế độ ăn và bổ sung dinh dưỡng</div>
                <div class="expandable-content">
                    <p>Ăn cỏ tươi, rơm, củ quả như cà rốt và khoai lang. Bổ sung 0,1-0,3kg thức ăn tinh/ngày. Cần 5,5-9g canxi, 2,9-5g phốt pho, 3.500-11.000 UI Vitamin D hàng ngày. Tránh nước tù đọng, bổ sung Vitamin A, D vào mùa đông.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/sinhsancuu.png') }}" alt="Sinh Sản">
            </div>
            <div class="card-content">
                <div class="social-title">Sinh Sản</div>
                <div class="social-description">Quy trình sinh sản và chăm sóc cừu con</div>
                <div class="expandable-content">
                    <p>Cừu cái mang thai 146-150 ngày, đẻ 1-2 con/lứa. Tỷ lệ đực/cái 1/25, đực giống 8-9 tháng tuổi mới phối. Sau đẻ, giữ cừu mẹ và con trong khu vực ấm áp, cung cấp thức ăn giàu đạm.</p>
                </div>
            </div>
            <div class="expand-icon"></div>
        </div>

        <div class="social-card" onclick="toggleCard(this)">
            <div class="card-header">
                <img src="{{ asset('images/lich.png') }}" alt="Lịch Theo Dõi">
            </div>
            <div class="card-content">
                <div class="social-title">Lịch Theo Dõi</div>
                <div class="social-description">Lịch trình chăm sóc định kỳ</div>
                <div class="expandable-content">
                    <p>Tháng 1: kiểm tra sức khỏe tổng quát. Tháng 3, 9: tiêm vacxin. Hàng tuần: vệ sinh chuồng, kiểm tra nước uống. Hàng tháng: tẩy giun, bổ sung khoáng chất.</p>
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
                    icon: "chamcuu.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho cừu",
                    fullDesc: "Cừu mẹ: chu kỳ động dục 16-17 ngày, mang thai 146-150 ngày. Cừu con: bú sữa đầu 10 ngày, 11-20 ngày bú 3 lần/ngày, 80-90 ngày cai sữa. Dấu hiệu sắp đẻ: bầu vú căng, xuống sữa, âm hộ sưng to. Sau khi đẻ, pha nước đường 1% + muối 0,5% cho cừu mẹ uống để phục hồi sức khỏe."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ cừu",
                    fullDesc: "Tiêm vacxin phòng bệnh than (Anthrax) và tụ huyết trùng (Pasteurellosis) vào tháng 3 và tháng 9 hàng năm. Tiêm vacxin dại khi có dịch bệnh hoặc khi nhập giống mới. Sử dụng vacxin chất lượng cao, tiêm đúng liều lượng theo hướng dẫn bác sĩ thú y."
                },
                {
                    icon: "giongcuu.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở cừu",
                    fullDesc: "Bệnh than (Anthrax): triệu chứng sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh theo chỉ định bác sĩ, kết hợp vệ sinh chuồng trại."
                },
                {
                    icon: "ddcuu.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",
                    fullDesc: "Ăn cỏ tươi, rơm, củ quả như cà rốt và khoai lang. Bổ sung 0,1-0,3kg thức ăn tinh/ngày. Cần 5,5-9g canxi, 2,9-5g phốt pho, 3.500-11.000 UI Vitamin D hàng ngày. Tránh nước tù đọng, bổ sung Vitamin A, D vào mùa đông."
                },
                {
                    icon: "sinhsancuu.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc cừu con",
                    fullDesc: "Cừu cái mang thai 146-150 ngày, đẻ 1-2 con/lứa. Tỷ lệ đực/cái 1/25, đực giống 8-9 tháng tuổi mới phối. Sau đẻ, giữ cừu mẹ và con trong khu vực ấm áp, cung cấp thức ăn giàu đạm."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 1: kiểm tra sức khỏe tổng quát. Tháng 3, 9: tiêm vacxin. Hàng tuần: vệ sinh chuồng, kiểm tra nước uống. Hàng tháng: tẩy giun, bổ sung khoáng chất."
                }
            ]
        },
        // nai: {
        //     title: "Hướng Dẫn Chăm Sóc Nai",
        //     subtitle: "Kiến thức chăm sóc nai trong vườn thú",
        //     guides: [
        //         {
        //             icon: "chamnai.png",
        //             title: "Chăm Sóc",
        //             shortDesc: "Quy trình chăm sóc hàng ngày cho nai",
        //             fullDesc: "Tránh tiếng ồn, chuyển động đột ngột. Kiểm tra sức khỏe thường xuyên. Vệ sinh chuồng hàng ngày, thay nước sạch. Quan sát hành vi để phát hiện sớm bệnh tật."
        //         },
        //         {
        //             icon: "vaccin.png",
        //             title: "Tiêm Vacxin",
        //             shortDesc: "Lịch tiêm phòng bảo vệ nai",
        //             fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và viêm phổi vào đầu và cuối mùa mưa. Tiêm vacxin dại khi có dịch. Tham khảo ý kiến bác sĩ thú y để đảm bảo liều lượng."
        //         },
        //         {
        //             icon: "benhthuonggapnai.png",
        //             title: "Bệnh Thường Gặp",
        //             shortDesc: "Các bệnh phổ biến ở nai",
        //             fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Viêm phổi: ho, khó thở. Ký sinh trùng: gầy yếu, rụng lông. Điều trị bằng thuốc theo chỉ định và vệ sinh môi trường."
        //         },
        //         {
        //             icon: "thucanai.png",
        //             title: "Dinh Dưỡng",
        //             shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",
        //             fullDesc: "Ăn cỏ, lá cây, rau củ, trái cây như táo. Bổ sung thức ăn viên chuyên dụng. Cần nước sạch liên tục, chia nhỏ bữa ăn trong ngày để tránh đầy hơi."
        //         },
        //         {
        //             icon: "sinhsannai.png",
        //             title: "Sinh Sản",
        //             shortDesc: "Quy trình sinh sản và chăm sóc nai con",
        //             fullDesc: "Nai cái mang thai 240-250 ngày, đẻ 1 con/lứa. Nai đực phối giống từ 2 tuổi. Sau đẻ, giữ nai mẹ và con trong khu vực yên tĩnh, cung cấp thức ăn giàu năng lượng."
        //         },
        //         {
        //             icon: "lich.png",
        //             title: "Lịch Theo Dõi",
        //             shortDesc: "Lịch trình chăm sóc định kỳ",
        //             fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra chân và móng. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa khô: tăng cường nước uống."
        //         }
        //     ]
        // },
        tho: {
            title: "Hướng Dẫn Chăm Sóc Thỏ",
            subtitle: "Chăm sóc thỏ cảnh và thỏ giống hiệu quả",
            guides: [
                {
                    icon: "chamtho.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho thỏ",
                    fullDesc: "Vệ sinh chuồng hàng ngày, tắm rửa định kỳ khi cần. Cắt móng thường xuyên, chải lông để tránh rụng lông quá nhiều. Kiểm tra sức khỏe đều đặn, đặc biệt sau sinh."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ thỏ",
                    fullDesc: "Tiêm vacxin phòng bệnh dại và myxomatosis từ 6-8 tuần tuổi, nhắc lại mỗi 6 tháng. Sử dụng vacxin phù hợp với giống thỏ, tiêm bởi bác sĩ thú y."
                },
                {
                    icon: "tho.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở thỏ",
                    fullDesc: "Myxomatosis: sưng mắt, tai. Tiêu chảy: do thức ăn không sạch. Rụng lông: stress hoặc ký sinh trùng. Điều trị sớm với thuốc chuyên dụng."
                },
                {
                    icon: "ddtho.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ ăn và bổ sung dinh dưỡng",
                    fullDesc: "Cỏ khô, rau xanh như xà lách, cà rốt. Tránh rau có độ ẩm cao như cải xanh. Nước sạch luôn có sẵn, bổ sung thức ăn viên chuyên dụng."
                },
                {
                    icon: "sinhsantho.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc thỏ con",
                    fullDesc: "Thỏ cái mang thai 30-32 ngày, đẻ 4-8 con/lứa. Thỏ đực phối từ 5-6 tháng tuổi. Sau đẻ, giữ khu vực sạch sẽ, cung cấp thức ăn giàu canxi."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra răng và móng. Hàng tháng: tẩy giun, bổ sung vitamin C. Mùa hè: tăng cường nước mát."
                }
            ]
        },
        // casau: {
        //     title: "Hướng Dẫn Chăm Sóc Cá Sấu",
        //     subtitle: "An toàn và hiệu quả trong chăm sóc cá sấu",
        //     guides: [
        //         {
        //             icon: "chamcasau.png",
        //             title: "Chăm Sóc",
        //             shortDesc: "Quy trình chăm sóc an toàn cho cá sấu",
        //             fullDesc: "Kiểm tra sức khỏe từ xa, quan sát hành vi hàng ngày. Vệ sinh môi trường nước thường xuyên, thay nước định kỳ. Theo dõi nhiệt độ và chất lượng nước để đảm bảo ổn định."
        //         },
        //         {
        //             icon: "vaccin.png",
        //             title: "Tiêm Vacxin",
        //             shortDesc: "Lịch tiêm phòng bảo vệ cá sấu",
        //             fullDesc: "Tiêm vacxin phòng bệnh viêm da và nhiễm trùng da vào đầu mùa xuân. Tiêm nhắc lại hàng năm, ưu tiên cá sấu non. Tham khảo chuyên gia thủy sản."
        //         },
        //         {
        //             icon: "benhthuonggapcasau.png",
        //             title: "Bệnh Thường Gặp",
        //             shortDesc: "Các bệnh phổ biến ở cá sấu",
        //             fullDesc: "Viêm da: da sần sùi, đỏ. Nhiễm trùng nước: lơ lửng, yếu. Ký sinh trùng: gầy yếu, chậm lớn. Điều trị bằng thuốc chuyên dụng và cải thiện môi trường nước."
        //         },
        //         {
        //             icon: "thucancasau.png",
        //             title: "Dinh Dưỡng",
        //             shortDesc: "Chế độ dinh dưỡng cho cá sấu",
        //             fullDesc: "Cá tươi, thịt gia cầm, thịt bò. Cho ăn 2-3 lần/tuần, lượng 5-10% trọng lượng cơ thể. Tránh thức ăn ôi thiu, sử dụng que dài khi cho ăn."
        //         },
        //         {
        //             icon: "sinhsancasau.png",
        //             title: "Sinh Sản",
        //             shortDesc: "Quy trình sinh sản và chăm sóc cá sấu con",
        //             fullDesc: "Cá sấu cái đẻ 20-60 trứng sau 30-40 ngày, ấp 60-90 ngày. Sau nở, giữ cá con trong nước ấm 28-30°C, cung cấp thức ăn nhỏ như cá con."
        //         },
        //         {
        //             icon: "lich.png",
        //             title: "Lịch Theo Dõi",
        //             shortDesc: "Lịch trình chăm sóc định kỳ",
        //             fullDesc: "Tháng 3, 9: kiểm tra sức khỏe. Hàng tuần: vệ sinh hồ nước. Hàng tháng: đo nhiệt độ, bổ sung khoáng. Mùa mưa: kiểm tra hệ thống thoát nước."
        //         }
        //     ]
        // },
        dadieu: {
            title: "Hướng Dẫn Chăm Sóc Đà Điều",
            subtitle: "Chăm sóc đà điều trong môi trường nuôi nhốt",
            guides: [
                {
                    icon: "chamdadieu.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho đà điều",
                    fullDesc: "Tránh stress, tiếng ồn lớn. Kiểm tra chân thường xuyên vì dễ bị thương. Vệ sinh khu vực sống hàng ngày. Quan sát hành vi sinh sản để hỗ trợ kịp thời."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ đà điều",
                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và cúm gia cầm vào đầu và cuối mùa khô. Tiêm nhắc lại mỗi năm, ưu tiên chim non. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggapdadieu.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở đà điều",
                    fullDesc: "Cúm gia cầm: sốt, tiêu chảy. Chân bị thương: sưng, khó đi. Ký sinh trùng: rụng lông, gầy yếu. Điều trị bằng thuốc và cải thiện môi trường."
                },
                {
                    icon: "thucandadieu.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng đà điều",
                    fullDesc: "Thức ăn viên chuyên dụng, rau xanh, trái cây như chuối. Tránh thức ăn cứng, sắc nhọn. Nước sạch luôn có sẵn, bổ sung protein vào mùa sinh sản."
                },
                {
                    icon: "sinhsandadieu.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc đà điều con",
                    fullDesc: "Đà điều đẻ 8-15 trứng/lứa, ấp 40-50 ngày. Sau nở, giữ khu vực ấm áp, cung cấp thức ăn mềm như cám trộn rau. Tách chim con khỏi chim lớn."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 4, 10: tiêm vacxin. Hàng tuần: kiểm tra chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa hè: tăng bóng mát."
                }
            ]
        },
        cong: {
            title: "Hướng Dẫn Chăm Sóc Công",
            subtitle: "Chăm sóc công trong vườn thú và trang trại",
            guides: [
                {
                    icon: "chamcong.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho công",
                    fullDesc: "Vệ sinh chuồng hàng ngày, thay cát lót. Kiểm tra sức khỏe thường xuyên. Tạo môi trường yên tĩnh cho sinh sản. Cắt móng định kỳ để tránh nhiễm trùng."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ công",
                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và đậu gà vào tháng 2 và tháng 8. Tiêm nhắc lại mỗi 6 tháng, ưu tiên công con. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggapcong.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở công",
                    fullDesc: "Newcastle: khó thở, tiêu chảy. Đậu gà: mụn nước trên da. Ký sinh trùng: rụng lông. Điều trị bằng vacxin và vệ sinh chuồng trại."
                },
                {
                    icon: "thucancong.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho công",
                    fullDesc: "Thóc, ngô, rau xanh, côn trùng nhỏ. Bổ sung protein trong mùa sinh sản. Nước sạch thường xuyên, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."
                },
                {
                    icon: "sinhsancong.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc công con",
                    fullDesc: "Công mái đẻ 4-8 trứng/lứa, ấp 28-30 ngày. Sau nở, giữ công con trong khu vực ấm áp, cung cấp thức ăn mềm như cám trộn ngô."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 3, 9: tiêm vacxin. Hàng tuần: kiểm tra lông và móng. Hàng tháng: tẩy giun, bổ sung canxi. Mùa đông: tăng nhiệt độ chuồng."
                }
            ]
        },
        chim: {
            title: "Hướng Dẫn Chăm Sóc Chim",
            subtitle: "Chăm sóc các loài chim cảnh và chim nuôi",
            guides: [
                {
                    icon: "chamchim.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho chim",
                    fullDesc: "Vệ sinh lồng hàng ngày, thay nước sạch. Cung cấp cành cây để chim đậu. Tránh tiếng ồn lớn và ánh sáng mạnh. Kiểm tra sức khỏe định kỳ, đặc biệt là lông và mắt."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ chim",
                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle và cúm gia cầm vào tháng 3 và 9. Tiêm nhắc lại mỗi 6 tháng, ưu tiên chim non. Tham khảo bác sĩ thú y để đảm bảo liều lượng."
                },
                {
                    icon: "benhthuonggapchim.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở chim",
                    fullDesc: "Cúm gia cầm: sốt, lông xù. Ký sinh trùng: rụng lông, gầy yếu. Nhiễm trùng hô hấp: hắt hơi, khó thở. Điều trị bằng thuốc và cải thiện môi trường sống."
                },
                {
                    icon: "thucanchim.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho chim",
                    fullDesc: "Hạt ngũ cốc, trái cây, rau xanh. Bổ sung cát sỏi để hỗ trợ tiêu hóa. Nước sạch luôn có sẵn, tránh thức ăn mốc. Cho ăn 2-3 lần/ngày."
                },
                {
                    icon: "sinhsanchim.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc chim con",
                    fullDesc: "Chim mái đẻ 3-6 trứng/lứa, ấp 14-21 ngày. Sau nở, giữ khu vực ấm áp, cung cấp thức ăn mềm như cám trộn. Tách chim con khi đủ lông."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra lông và mắt. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa đông: tăng nhiệt độ lồng."
                }
            ]
        },
        ga: {
            title: "Hướng Dẫn Chăm Sóc Gà",
            subtitle: "Chăm sóc gà hiệu quả trong trang trại",
            guides: [
                {
                    icon: "chamga.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho gà",
                    fullDesc: "Vệ sinh chuồng trại hàng ngày, thay nước sạch. Cung cấp không gian đủ rộng để gà di chuyển. Kiểm tra sức khỏe định kỳ, đặc biệt là mào và chân."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ gà",
                    fullDesc: "Tiêm vacxin phòng bệnh Newcastle, Gumboro và cúm gia cầm từ 1-2 tuần tuổi, nhắc lại mỗi 6 tháng. Sử dụng vacxin chất lượng cao, theo chỉ dẫn bác sĩ thú y."
                },
                {
                    icon: "benhthuonggapga.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở gà",
                    fullDesc: "Newcastle: khó thở, tiêu chảy. Gumboro: suy giảm miễn dịch. Cúm gia cầm: sốt, giảm đẻ. Điều trị bằng thuốc và vệ sinh chuồng trại kỹ lưỡng."
                },
                {
                    icon: "thucanga.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho gà",
                    fullDesc: "Cám gà, ngô, thóc, rau xanh. Bổ sung canxi và protein trong giai đoạn đẻ trứng. Nước sạch liên tục, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."
                },
                {
                    icon: "sinhsanga.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc gà con",
                    fullDesc: "Gà mái đẻ 10-20 trứng/lứa, ấp 21 ngày. Sau nở, giữ gà con trong khu vực ấm 32-35°C, cung cấp cám khởi đầu giàu protein."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra chuồng và sức khỏe. Hàng tháng: tẩy giun, bổ sung khoáng chất. Mùa mưa: kiểm tra độ ẩm chuồng."
                }
            ]
        },
        de: {
            title: "Hướng Dẫn Chăm Sóc Dê",
            subtitle: "Chăm sóc dê hiệu quả trong môi trường trang trại",
            guides: [
                {
                    icon: "chamde.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho dê",
                    fullDesc: "Vệ sinh chuồng hàng ngày, đảm bảo thông thoáng. Kiểm tra sức khỏe định kỳ, đặc biệt là móng và răng. Cung cấp nước sạch và tránh stress cho dê."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ dê",
                    fullDesc: "Tiêm vacxin phòng bệnh than và tụ huyết trùng vào tháng 3 và 9. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y để đảm bảo liều lượng."
                },
                {
                    icon: "benhthuonggapde.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở dê",
                    fullDesc: "Bệnh than: sốt cao, chết đột ngột. Tụ huyết trùng: sưng cổ, khó thở. Giun sán: tiêu chảy, giảm cân. Điều trị bằng kháng sinh và vệ sinh chuồng."
                },
                {
                    icon: "thucande.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho dê",
                    fullDesc: "Cỏ tươi, lá cây, thức ăn tinh 0,2-0,4kg/ngày. Bổ sung canxi, phốt pho và vitamin A, D. Nước sạch liên tục, tránh thức ăn mốc hoặc ôi thiu."
                },
                {
                    icon: "sinhsande.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc dê con",
                    fullDesc: "Dê cái mang thai 145-155 ngày, đẻ 1-3 con/lứa. Dê đực phối giống từ 8 tháng tuổi. Sau đẻ, giữ khu vực ấm áp, cung cấp thức ăn giàu dinh dưỡng."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra móng và răng. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa khô: tăng cường nước uống."
                }
            ]
        },
        bo: {
            title: "Hướng Dẫn Chăm Sóc Bò",
            subtitle: "Chăm sóc bò hiệu quả trong trang trại",
            guides: [
                {
                    icon: "chambo.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho bò",
                    fullDesc: "Vệ sinh chuồng trại hàng ngày, đảm bảo khô ráo. Kiểm tra sức khỏe định kỳ, đặc biệt là chân và dạ dày. Cung cấp không gian rộng để bò di chuyển."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ bò",
                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và tụ huyết trùng vào tháng 3 và 9. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggapbo.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở bò",
                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Tụ huyết trùng: khó thở, sưng cổ. Giun sán: giảm cân, tiêu chảy. Điều trị bằng kháng sinh và vệ sinh chuồng."
                },
                {
                    icon: "thucanbo.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho bò",
                    fullDesc: "Cỏ tươi, rơm, thức ăn tinh 1-2kg/ngày. Bổ sung canxi, phốt pho, vitamin A, D. Nước sạch liên tục, chia nhỏ bữa ăn để tránh đầy hơi."
                },
                {
                    icon: "sinhsanbo.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc bò con",
                    fullDesc: "Bò cái mang thai 280-290 ngày, đẻ 1 con/lứa. Bò đực phối giống từ 18 tháng tuổi. Sau đẻ, giữ khu vực sạch sẽ, cung cấp thức ăn giàu protein."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 1, 7: tiêm vacxin. Hàng tuần: kiểm tra chân và dạ dày. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa mưa: kiểm tra độ ẩm chuồng."
                }
            ]
        },
        trau: {
            title: "Hướng Dẫn Chăm Sóc Trâu",
            subtitle: "Chăm sóc trâu hiệu quả trong trang trại",
            guides: [
                {
                    icon: "chamtrau.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho trâu",
                    fullDesc: "Vệ sinh chuồng trại hàng ngày, cung cấp bãi tắm nước. Kiểm tra sức khỏe định kỳ, đặc biệt là móng và da. Tránh stress và tiếng ồn lớn."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ trâu",
                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và tụ huyết trùng vào tháng 2 và 8. Tiêm vacxin dại khi cần. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggaptrau.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở trâu",
                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Tụ huyết trùng: khó thở, sưng cổ. Giun sán: gầy yếu, tiêu chảy. Điều trị bằng thuốc và vệ sinh chuồng."
                },
                {
                    icon: "thucantrau.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho trâu",
                    fullDesc: "Cỏ tươi, rơm, lá cây. Bổ sung thức ăn tinh 1-1,5kg/ngày. Cần nước sạch liên tục, bổ sung muối và khoáng chất. Tránh thức ăn ôi thiu."
                },
                {
                    icon: "sinhsantrau.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc trâu con",
                    fullDesc: "Trâu cái mang thai 300-330 ngày, đẻ 1 con/lứa. Trâu đực phối giống từ 2 tuổi. Sau đẻ, giữ khu vực khô ráo, cung cấp thức ăn giàu năng lượng."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 3, 9: tiêm vacxin. Hàng tuần: kiểm tra móng và da. Hàng tháng: tẩy giun, bổ sung khoáng. Mùa khô: tăng cường nước uống."
                }
            ]
        },
        huou: {
            title: "Hướng Dẫn Chăm Sóc Hươu",
            subtitle: "Chăm sóc hươu trong môi trường vườn thú",
            guides: [
                {
                    icon: "chamhuou.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho hươu",
                    fullDesc: "Tránh tiếng ồn và chuyển động đột ngột. Kiểm tra sừng và chân định kỳ. Vệ sinh chuồng hàng ngày, cung cấp không gian rộng để hươu di chuyển."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ hươu",
                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và viêm phổi vào tháng 2 và 8. Tiêm vacxin dại khi có dịch. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggaphuou.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở hươu",
                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Viêm phổi: ho, khó thở. Ký sinh trùng: rụng lông, gầy yếu. Điều trị bằng thuốc và vệ sinh môi trường."
                },
                {
                    icon: "thucanhuou.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho hươu",
                    fullDesc: "Cỏ tươi, lá cây, rau củ như cà rốt. Bổ sung thức ăn viên chuyên dụng. Nước sạch liên tục, chia nhỏ bữa ăn để tránh đầy hơi."
                },
                {
                    icon: "sinhsanhuou.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc hươu con",
                    fullDesc: "Hươu cái mang thai 230-240 ngày, đẻ 1 con/lứa. Hươu đực phối giống từ 2 tuổi. Sau đẻ, giữ khu vực yên tĩnh, cung cấp thức ăn giàu năng lượng."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra sừng và chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa khô: tăng cường nước uống."
                }
            ]
        },
        heotoc: {
            title: "Hướng Dẫn Chăm Sóc Heo Tộc",
            subtitle: "Chăm sóc heo tộc trong môi trường trang trại",
            guides: [
                {
                    icon: "chamheotoc.png",
                    title: "Chăm Sóc",
                    shortDesc: "Quy trình chăm sóc hàng ngày cho heo tộc",
                    fullDesc: "Vệ sinh chuồng hàng ngày, đảm bảo khô ráo. Kiểm tra sức khỏe định kỳ, đặc biệt là da và chân. Cung cấp không gian để heo vận động tự nhiên."
                },
                {
                    icon: "tiemvaccin.png",
                    title: "Tiêm Vacxin",
                    shortDesc: "Lịch tiêm phòng bảo vệ heo tộc",
                    fullDesc: "Tiêm vacxin phòng bệnh lở mồm long móng và dịch tả lợn vào tháng 3 và 9. Tiêm nhắc lại mỗi 6 tháng. Tham khảo bác sĩ thú y."
                },
                {
                    icon: "benhthuonggapheotoc.png",
                    title: "Bệnh Thường Gặp",
                    shortDesc: "Các bệnh phổ biến ở heo tộc",
                    fullDesc: "Lở mồm long móng: sốt, lở loét miệng. Dịch tả lợn: sốt cao, tiêu chảy. Giun sán: gầy yếu, chậm lớn. Điều trị bằng thuốc và vệ sinh chuồng."
                },
                {
                    icon: "thucanheotoc.png",
                    title: "Dinh Dưỡng",
                    shortDesc: "Chế độ dinh dưỡng cho heo tộc",
                    fullDesc: "Cám, rau xanh, củ quả như khoai lang, bí đỏ. Bổ sung protein và khoáng chất. Nước sạch liên tục, tránh thức ăn ôi thiu. Cho ăn 2-3 lần/ngày."
                },
                {
                    icon: "sinhsanheotoc.png",
                    title: "Sinh Sản",
                    shortDesc: "Quy trình sinh sản và chăm sóc heo con",
                    fullDesc: "Heo cái mang thai 110-120 ngày, đẻ 6-12 con/lứa. Heo đực phối giống từ 8 tháng tuổi. Sau đẻ, giữ khu vực ấm áp, cung cấp thức ăn giàu dinh dưỡng."
                },
                {
                    icon: "lich.png",
                    title: "Lịch Theo Dõi",
                    shortDesc: "Lịch trình chăm sóc định kỳ",
                    fullDesc: "Tháng 2, 8: tiêm vacxin. Hàng tuần: kiểm tra da và chân. Hàng tháng: tẩy giun, bổ sung vitamin. Mùa mưa: kiểm tra độ ẩm chuồng."
                }
            ]
        }
    };

    function selectAnimal(animalKey, tabElement) {
        const data = animalData[animalKey];

        document.querySelectorAll('.tab-item').forEach(item => item.classList.remove('active'));
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
                    <img src="{{ asset('images/${guide.icon}') }}" alt="${guide.title}">
                </div>
                <div class="card-content">
                    <div class="social-title">${guide.title}</div>
                    <div class="social-description">${guide.shortDesc}</div>
                    <div class="expandable-content">
                        <p>${guide.fullDesc}</p>
                    </div>
                </div>
                <div class="expand-icon"></div>
            </div>
        `).join('');
    }
</script>
</body>
</html>
