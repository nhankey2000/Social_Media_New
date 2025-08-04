<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Bánh Xèo Cô Tư - Bánh Xèo Truyền Thống Ngon Nhất Cần Thơ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(-45deg, #ff6b35, #f7931e, #ff8c00, #e65100);
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
            background-image: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.06) 0%, transparent 50%), radial-gradient(circle at 60% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 50%), radial-gradient(circle at 90% 60%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
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

        .container p { color: white; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section { margin-bottom: 24px; animation: fadeIn 1s ease-out 0.2s both; }

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

        .logo:hover { transform: translateY(-4px); }

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
            background: linear-gradient(-45deg, #ffffff, #87ceeb, #e0ffff, #87ceeb, #ffffff);
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
            margin-bottom: 24px;
            font-weight: 400;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .description {
            font-size: 1.1rem;
            color: white;
            margin-bottom: 48px;
            font-weight: 300;
            animation: fadeIn 1s ease-out 0.6s both;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            cursor: pointer;
        }

        .social-card:nth-child(1) { animation-delay: 0.8s; }
        .social-card:nth-child(2) { animation-delay: 1s; }
        .social-card:nth-child(3) { animation-delay: 1.2s; }
        .social-card:nth-child(4) { animation-delay: 1.4s; }
        .social-card:nth-child(5) { animation-delay: 1.4s; }

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

        .social-card:hover::before { left: 100%; }

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
            background: linear-gradient(45deg, #ff6b35, #f7931e, #ffd700, #32cd32, #ff8c00, #ff6b35);
            background-size: 300% 300%;
            animation: rainbowRotate 3s linear infinite;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .social-card:hover .social-icon::before { opacity: 0.7; }

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

        .map-card {
            background: linear-gradient(135deg, rgba(34, 139, 34, 0.95), rgba(50, 205, 50, 0.95));
            color: white;
        }

        .map-card .social-title, .map-card .social-description { color: white; }

        .map-card:hover {
            background: linear-gradient(135deg, rgba(34, 139, 34, 0.98), rgba(50, 205, 50, 0.98));
        }

        .menu-card {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.95), rgba(247, 147, 30, 0.95));
            color: white;
        }

        .menu-card .social-title, .menu-card .social-description { color: white; }

        .menu-card:hover {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.98), rgba(247, 147, 30, 0.98));
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
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px;
            margin-top: 32px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 1s ease-out 1.8s both;
        }

        .contact-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin-bottom: 16px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            color: white;
            font-size: 0.95rem;
        }

        .contact-icon {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .menu-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .menu-modal.show {
            display: flex;
            opacity: 1;
        }

        .menu-modal-content {
            background: white;
            border-radius: 16px;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .zoom-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .zoom-modal.show {
            display: flex;
            opacity: 1;
        }

        .zoom-modal-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
            text-align: center;
        }

        .zoom-modal img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            animation: zoomIn 0.3s ease-out;
        }

        @keyframes zoomIn {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-button:hover { color: #ff6b35; }

        @media (max-width: 768px) {
            body { justify-content: flex-start; padding: 40px 16px 20px; }
            .container { padding: 0; margin-top: 20px; }
            .main-title { font-size: 2.5rem; margin-bottom: 12px; }
            .subtitle { font-size: 1.125rem; margin-bottom: 20px; }
            .description { font-size: 1rem; margin-bottom: 32px; }
            .logo { width: 160px; height: 100px; margin-bottom: 20px; }
            .logo img { width: 120px; height: 64px; }
            .social-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 32px; }
            .social-card { padding: 24px 20px; }
            .contact-info { padding: 20px; }
            .menu-modal-content { max-width: 95%; padding: 15px; }
            .menu-modal img { max-width: 90%; }
        }

        @media (max-width: 480px) {
            body { padding: 30px 10px 20px; }
            .main-title { font-size: 2rem; }
            .subtitle { font-size: 1rem; }
            .description { font-size: 0.9rem; }
            .logo { width: 140px; height: 80px; }
            .logo img { width: 100px; height: 48px; }
            .social-card { padding: 20px 16px; }
            .social-icon { width: 40px; height: 40px; }
            .social-icon img { width: 40px; height: 40px; }
            .contact-info { padding: 16px; }
            .contact-item { font-size: 0.85rem; text-align: left; justify-content: flex-start; }
            .social-grid { grid-template-columns: 1fr; gap: 12px; }
            .menu-modal-content { max-width: 98%; padding: 10px; }
            .menu-modal img { max-width: 100%; }
            .close-button { font-size: 20px; }
        }

        @media (hover: none) and (pointer: coarse) {
            .social-card:hover { transform: none; }
            .social-card:active { transform: scale(0.98); }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo-section">
        <div class="logo">
            <img src="{{ asset('images/logobx.png') }}" alt="Logo Bánh Xèo Cô Tư">
        </div>
    </div>

    <h1 class="main-title">Bánh Xèo Cô Tư</h1>
    <p class="subtitle">Bánh xèo truyền thống ngon nhất Cần Thơ</p>
    <p class="description">
        Thưởng thức hương vị đậm đà của bánh xèo miền Tây với công thức truyền thống được truyền qua nhiều thế hệ.
        Bánh xèo giòn rụm, nhân tôm thịt tươi ngon, ăn kèm rau sống và nước mắm chua ngọt đặc biệt.
    </p>

    <div class="social-grid">
        <a href="#" onclick="showMenu(); return false;" class="social-card menu-card">
            <div class="social-icon">
                <img src="{{ asset('images/menu.png') }}" alt="Thực đơn">
            </div>
            <div class="social-title">Thực đơn</div>
            <div class="social-description">Xem thực đơn và bảng giá chi tiết</div>
        </a>

        <a href="https://maps.google.com/?q=Bánh+Xèo+Cô+Tư+Cần+Thơ" target="_blank" class="social-card map-card">
            <div class="social-icon">
                <img src="{{ asset('images/ggmap.png') }}" alt="Google Maps">
            </div>
            <div class="social-title">Địa điểm</div>
            <div class="social-description">Tìm đường và xem bản đồ đến quán</div>
        </a>
        <a href="https://www.tiktok.com/@banhxeoco4cantho" target="_blank" class="social-card tiktok">
            <div class="social-icon">
                <img src="{{ asset('images/tiktok.png') }}" alt="TikTok">
            </div>
            <div class="social-title">TikTok</div>
            <div class="social-description">Xem video làm bánh xèo và đánh giá khách hàng</div>
        </a>

        <a href="https://www.facebook.com/profile.php?id=61578479400472&locale=vi_VN" target="_blank" class="social-card facebook">
            <div class="social-icon">
                <img src="{{ asset('images/facebook1.png') }}" alt="Facebook">
            </div>
            <div class="social-title">Facebook</div>
            <div class="social-description">Theo dõi tin tức và khuyến mãi mới nhất</div>
        </a>
        <a href="https://zalo.me/0907888421" target="_blank" class="social-card facebook">
            <div class="social-icon">
                <img src="{{ asset('images/zalo1.png') }}" alt="Zalo">
            </div>
            <div class="social-title">Zalo</div>
            <div class="social-description">Liên hệ và Tư vấn</div>
        </a>

    </div>

    <div id="menuModal" class="menu-modal">
        <div class="menu-modal-content">
            <span class="close-button" onclick="hideMenu()">&times;</span>
            <img src="images/menu1.png" alt="Menu 1 Bánh Xèo Cô Tư" onclick="zoomImage(this.src)">
            <img src="images/menu2.png" alt="Menu 2 Bánh Xèo Cô Tư" onclick="zoomImage(this.src)">
        </div>
    </div>

    <div id="zoomModal" class="zoom-modal">
        <div class="zoom-modal-content">
            <span class="close-button" onclick="hideZoom()">&times;</span>
            <img id="zoomedImage" src="" alt="Zoomed Image">
        </div>
    </div>

    <div class="contact-info">
        <h3 class="contact-title">Thông tin liên hệ</h3>
        <div class="contact-item">
            <span class="contact-icon">📍</span>
            <span>Địa chỉ: Trục chính KĐT Mới Hồng Phát – P. An Bình – TP. Cần Thơ</span>
        </div>
        <div class="contact-item">
            <span class="contact-icon">📞</span>
            <span>Hotline: 0907 888 421</span>
        </div>
        <div class="contact-item">
            <span class="contact-icon">🕐</span>
            <span>Giờ mở cửa: 10:00 - 19:00 (hàng ngày)</span>
        </div>

    </div>

    <div class="footer">
        <p class="footer-text">© 2025 Bánh Xèo Cô Tư. Tất cả quyền được bảo lưu.</p>
        <p class="footer-text">Thuộc Hệ Sinh Thái Ông Đề - Làng Du Lịch Sinh Thái Ông Đề</p>
        <p class="footer-text">Địa chỉ: Trục chính KĐT Mới Hồng Phát – P. An Bình – TP. Cần Thơ</p>
    </div>
</div>

<script>
    document.querySelectorAll('.social-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            this.appendChild(ripple);

            setTimeout(() => { ripple.remove(); }, 600);
        });
    });

    const style = document.createElement('style');
    style.textContent = `@keyframes ripple { to { transform: scale(4); opacity: 0; } }`;
    document.head.appendChild(style);

    if ('scrollBehavior' in document.documentElement.style) {
        document.documentElement.style.scrollBehavior = 'smooth';
    }

    function showMenu() {
        const modal = document.getElementById('menuModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideMenu() {
        const modal = document.getElementById('menuModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    function zoomImage(src) {
        const zoomModal = document.getElementById('zoomModal');
        const zoomedImage = document.getElementById('zoomedImage');
        if (zoomModal && zoomedImage) {
            zoomedImage.src = src;
            zoomModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideZoom() {
        const zoomModal = document.getElementById('zoomModal');
        if (zoomModal) {
            zoomModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideMenu();
            hideZoom();
        }
    });

    document.getElementById('menuModal').addEventListener('click', function(e) {
        if (e.target === this) { hideMenu(); }
    });

    document.getElementById('zoomModal').addEventListener('click', function(e) {
        if (e.target === this) { hideZoom(); }
    });
</script>
</body>
</html>
