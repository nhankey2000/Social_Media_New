<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Liệu Bảo Mật</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            min-height: 100vh;
            padding: 20px;
            /* Ngăn chọn text */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            /* Ngăn kéo thả */
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
        }

        .document-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            border: 1px solid #e0e0e0;
        }

        .header {
            background: linear-gradient(45deg, #2196F3, #1976D2);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .document-content {
            padding: 40px;
            line-height: 1.8;
            font-size: 16px;
            position: relative;
            background: white;
        }

        /* Watermark overlay */
        .document-content::before {
            content: "BẢO MẬT - KHÔNG SAO CHÉP";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            font-size: 48px;
            color: rgba(0, 0, 0, 0.04);
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 1;
            font-weight: bold;
        }

        .content-text {
            position: relative;
            z-index: 2;
        }

        h1, h2, h3 {
            color: #212121;
            margin: 20px 0 15px 0;
        }

        h1 {
            font-size: 28px;
            text-align: center;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 10px;
        }

        h2 {
            font-size: 22px;
            color: #1565C0;
        }

        h3 {
            font-size: 18px;
            color: #424242;
        }

        p {
            margin: 15px 0;
            text-align: justify;
            text-indent: 30px;
            color: #212121;
            line-height: 1.7;
        }

        .highlight {
            background: linear-gradient(120deg, #f3f8ff 0%, #e8f2ff 100%);
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #1976D2;
            border-radius: 5px;
            color: #212121;
        }

        .warning {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #ff4444;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            z-index: 1000;
            transform: translateY(-100%);
            transition: transform 0.3s ease;
        }

        .warning.show {
            transform: translateY(0);
        }

        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 9999;
        }

        /* Ngăn right-click menu */
        .no-context {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Print protection */
        @media print {
            body {
                display: none !important;
            }
        }

        .footer {
            background: #fafafa;
            padding: 20px;
            text-align: center;
            color: #757575;
            font-style: italic;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body class="no-context">
<div class="warning" id="warning">
    ⚠️ CẢNH BÁO: Không được phép sao chép hoặc chụp màn hình!
</div>

<div class="protection-overlay" id="overlay">
    🔒 TÀI LIỆU ĐƯỢC BẢO VỆ - KHÔNG ĐƯỢC PHÉP TRUY CẬP
</div>

<div class="document-container">
    <div class="header">
        📄 TÀI LIỆU BẢO MẬT
    </div>

    <div class="document-content">
        <div class="content-text">
            <h1>DỰ ÁN "NIGHT HUNTERS – KHU VƯỜN BÓNG ĐÊM"</h1>

            <div class="highlight">
                <strong>Trải nghiệm săn bắt – sinh tồn – ma trận – ma quái – giải trí cảm giác mạnh</strong><br>
                Hãy bước vào bóng tối, nơi tiếng mưa thì thầm kể những câu chuyện cổ xưa, ánh trăng dẫn lối qua rừng sâu huyền bí, và mỗi nhịp tim là một nốt nhạc trong bản giao hưởng của sự sống và nỗi sợ. Khu Vườn Bóng Đêm không chỉ là một điểm đến, mà là một thế giới, nơi bạn đối mặt với bản năng, chinh phục nỗi sợ, và mang về những kỷ niệm không thể nào quên.
            </div>

            <h2>1. Ý TƯỞNG TỔNG QUAN – HÀNH TRÌNH DƯỚI ÁNH TRĂNG</h2>
            <p>Khu Vườn Bóng Đêm là một kiệt tác giải trí lần đầu tiên xuất hiện tại Việt Nam, mang đến trải nghiệm đa chiều, kích thích mọi giác quan, từ thị giác, thính giác, xúc giác đến vị giác. Tưởng tượng bạn bước vào một khu rừng nguyên sinh nhân tạo, nơi bóng tối ôm lấy bạn như một người bạn cũ, tiếng mưa rơi tí tách hòa quyện với tiếng côn trùng rả rích, và ánh trăng mờ ảo chiếu sáng những bí ẩn đang chờ đợi.</p>

            <h3>Đây là nơi bạn sẽ:</h3>
            <p><strong>Săn bắt hoang dã:</strong> Soi đèn bắt ếch, nhái, câu cá, đặt lờ, lọp, giăng lưới, và thậm chí đối mặt với những "con mồi bí ẩn" chỉ xuất hiện trong bóng đêm.</p>

            <p><strong>Ẩm thực dã chiến:</strong> Ngồi bên chòi tre, dưới ánh đèn dầu lập lòe, tự tay nấu cháo ếch nóng hổi, nướng cá thơm lừng, hay thưởng thức những món ăn độc lạ từ chiến lợi phẩm.</p>

            <p><strong>Thử thách ma quái:</strong> Lạc lối trong mê cung sương mù, đối diện với những mô hình động vật khổng lồ – ếch to bằng người, mèo ma với mắt đỏ rực, chó sói gầm gừ, hay ma quỷ phát ra tiếng kêu rùng rợn. Nhân viên hóa trang xuất hiện bất ngờ, mang đến những khoảnh khắc vừa sợ vừa vui.</p>

            <p><strong>Trải nghiệm đa dạng:</strong> Từ thử thách sinh tồn, trò chơi đồng đội, đến những khoảnh khắc thư giãn bên đầm sen hay chụp ảnh hồng ngoại trong bóng tối.</p>

            <p><strong>An toàn tuyệt đối:</strong> Hệ thống đèn khẩn cấp, camera giám sát, nhân viên y tế túc trực, và thiết kế an toàn đảm bảo bạn luôn được bảo vệ trong mọi tình huống.</p>

            <h3>Mục tiêu của Khu Vườn Bóng Đêm:</h3>
            <p>Tạo ra một sản phẩm du lịch giải trí độc nhất vô nhị, kết hợp văn hóa dân gian, cảm giác mạnh, và công nghệ hiện đại.</p>
            <p>Thu hút mọi đối tượng: giới trẻ tìm cảm giác mạnh, gia đình muốn gắn kết, khách du lịch khao khát trải nghiệm mới lạ, và cả những người yêu thích ẩm thực dã chiến.</p>
            <p>Tối ưu chi phí đầu tư (600 triệu), mang lại lợi nhuận cao (350 triệu/tháng) và khả năng mở rộng nhượng quyền.</p>
            <p>Tạo hiệu ứng lan tỏa trên mạng xã hội với các video viral, ảnh check-in, và thử thách độc lạ, biến Khu Vườn Bóng Đêm thành biểu tượng du lịch mới của Việt Nam.</p>

            <h2>2. ĐIỂM NHẤN ĐỘC ĐÁO – THẾ GIỚI HUYỀN BÍ KHÔNG THỂ RỜI MẮT</h2>
            <p>Khu Vườn Bóng Đêm không chỉ là một điểm tham quan, mà là một câu chuyện sống động được kể qua từng bước chân của bạn. Mỗi góc rừng, mỗi tiếng động, mỗi ánh sáng đều được thiết kế để kéo bạn vào một thế giới nơi ranh giới giữa thực và mộng trở nên mờ nhạt.</p>

            <h3>Rừng nguyên sinh nhân tạo – Bức tranh sống động của bóng tối:</h3>
            <p>Không gian được bao bọc bởi hàng rào dây leo rậm rạp, mái lưới lan ba lớp ngăn ánh sáng tự nhiên, tạo cảm giác như lạc vào rừng sâu bất tận.</p>
            <p>Ánh trăng giả lơ lửng trên cao, tỏa ánh sáng vàng nhạt, vừa đủ để bạn thấy đường nhưng vẫn cảm nhận được sự bí ẩn.</p>
            <p>Hệ thống phun sương tạo mưa nhẹ liên tục, làm ướt áo mưa mỏng bạn khoác trên người. Tiếng mưa rơi hòa quyện với tiếng côn trùng, gió rít, và sấm sét xa xa, tạo nên một bản nhạc rừng đêm đầy mê hoặc.</p>
            <p>Những bụi cây, hốc đá, và đầm lầy nhân tạo được thiết kế tinh xảo, như thể bạn đang bước vào một khu rừng thật sự, nơi mỗi góc đều ẩn chứa một bí mật.</p>

            <h3>Hoạt động săn bắt – Bản năng nguyên thủy trỗi dậy:</h3>
            <p>Được trang bị đèn soi, chĩa tre, cần câu, lờ, lọp, lưới, và giỏ tre, bạn sẽ hóa thân thành một thợ săn thực thụ, lần mò trong bóng tối để bắt ếch, nhái, cá, ốc, và thậm chí là những "con mồi bí ẩn" (như ếch nhuộm huỳnh quang an toàn, chỉ xuất hiện trong các sự kiện đặc biệt).</p>
            <p>Các hoạt động được thiết kế đa dạng: soi ếch dưới bụi rậm, câu cá trong ao mương, đặt lờ lọp ở đầm lầy, hay giăng lưới bắt nhái. Mỗi chiến lợi phẩm là một niềm tự hào, có thể mang về hoặc chế biến tại chỗ thành những món ăn dân dã.</p>

            <h3>Mê cung ma quái – Nơi nỗi sợ trở thành niềm vui:</h3>
            <p>Một mê cung đầy sương mù, với những ngõ ngách ngoằn ngoèo dẫn bạn qua các mô hình động vật kinh dị: ếch khổng lồ phát tiếng "ộp ộp" vang vọng, mèo ma với đôi mắt đỏ rực, chó sói gầm gừ, hay ma quỷ lướt qua trong bóng tối.</p>
            <p>Mô hình được thiết kế cơ học tinh vi, có thể chuyển động (quay đầu, nhúc nhích chân, há miệng), kết hợp loa ẩn phát tiếng kêu và đèn LED tạo ánh mắt sống động.</p>
            <p>Nhân viên hóa trang thành ma quỷ, mèo ma, hay thợ săn ma thuật sẽ xuất hiện bất ngờ, mang đến những khoảnh khắc giật mình nhưng đầy tiếng cười.</p>
            <p><strong>Điểm mới:</strong> Thêm "Cánh cửa bí mật" trong mê cung, dẫn đến một khu vực ẩn chứa kho báu (voucher, quà lưu niệm), nhưng chỉ những người dũng cảm nhất mới dám mở.</p>
            <p>Nếu bạn quá sợ hãi, chỉ cần nhấn nút cứu hộ (đeo trên cổ tay), đèn khẩn cấp sẽ bật sáng, và nhân viên sẽ dẫn bạn ra ngoài trong tích tắc.</p>

            <h3>Ẩm thực đêm khuya – Hương vị của chiến thắng:</h3>
            <p>Sau hành trình săn bắt và vượt mê cung, bạn sẽ ngồi lại trong những chòi tre lợp lá, dưới ánh đèn dầu lập lòe, tự tay nấu cháo ếch, nướng cá, hấp ốc, hoặc thưởng thức các món đặc biệt như "Ếch chiên ma quái" (ếch chiên giòn với gia vị độc quyền).</p>
            <p><strong>Điểm mới:</strong> Thêm khu "Lửa trại bóng đêm" với đống lửa nhân tạo (an toàn), nơi khách có thể nướng chiến lợi phẩm, hát hò, và kể chuyện ma quái dưới sự dẫn dắt của MC.</p>
            <p>Đầu bếp hỗ trợ chế biến hoặc hướng dẫn bạn tự nấu, mang đến trải nghiệm chill nhưng đầy cảm xúc.</p>

            <h3>Trải nghiệm đa dạng – Phù hợp mọi đối tượng:</h3>
            <p><strong>Điểm mới:</strong> Thêm khu "Đầm sen bóng đêm" với hoa sen nhân tạo phát sáng nhẹ, nơi khách có thể ngồi thuyền nhỏ (an toàn, có nhân viên chèo), ngắm cảnh, và chụp ảnh check-in.</p>
            <p>Trò chơi đồng đội: Các thử thách như "Giải mã bí ẩn rừng đêm" (tìm manh mối để thoát mê cung) hoặc "Săn kho báu ma quái" (tìm vật phẩm ẩn trong khu vườn).</p>
            <p>Khu vực thư giãn: Góc "Trăng rằm" với võng tre, đèn lồng, và nhạc acoustic, dành cho những ai muốn nghỉ ngơi sau hành trình kịch tính.</p>
            <p>Trải nghiệm công nghệ: Chụp ảnh hồng ngoại miễn phí, video thực tế ảo (VR) tái hiện mê cung ma quái, và app "Night Hunters" để đặt vé, xem bản đồ, lưu giữ kỷ niệm.</p>

            <h3>An toàn tuyệt đối – Niềm tin trong bóng tối:</h3>
            <p>Lối đi chống trơn trượt, được lát đá tự nhiên ở các điểm ẩm ướt.</p>
            <p>Camera giám sát toàn khu, kết nối với trung tâm điều hành.</p>
            <p>Nhân viên y tế túc trực 24/7, với hộp sơ cứu tại mỗi khu vực.</p>
            <p>Hệ thống đèn khẩn cấp ẩn, bật sáng tức thì khi khách cần hỗ trợ.</p>
            <p><strong>Điểm mới:</strong> Mỗi khách được đeo vòng tay thông minh với nút cứu hộ và đèn LED nhỏ, giúp nhân viên định vị nhanh trong trường hợp khẩn cấp.</p>

            <h2>3. QUY MÔ & BỐ TRÍ – KHÔNG GIAN ĐƯỢC DỆT NÊN TỪ GIẤC MƠ</h2>
            <p><strong>Diện tích:</strong> Tối thiểu 2.500 m² (50m x 50m), lý tưởng 3.500 m² để tạo không gian rộng rãi, đa dạng.</p>

            <h3>Phân khu chức năng:</h3>

            <h4>Khu đón khách & phát dụng cụ (10m x 20m):</h4>
            <p>Nhà chờ mái lá, trang trí bằng tre, dây leo, và đèn lồng lập lòe, gợi cảm giác như một ngôi làng cổ trong rừng.</p>
            <p>Quầy phát dụng cụ: đèn soi, chĩa tre, cần câu, lờ, lọp, lưới, giỏ tre, áo mưa mỏng, ủng cao su, và vòng tay thông minh.</p>
            <p>MC chào đón với trang phục thợ săn cổ xưa, kể câu chuyện huyền thoại về "Lời nguyền bóng đêm" để kích thích sự tò mò.</p>

            <h4>Đường mê cung rừng (15m x 40m):</h4>
            <p>Lối đi zig-zag, bao quanh bởi cây xanh, dây leo, và bụi rậm nhân tạo.</p>
            <p>Hệ thống phun sương tạo mưa nhẹ, loa 3D phát tiếng côn trùng, gió, sấm sét, và tiếng bước chân lén lút.</p>
            <p><strong>Điểm mới:</strong> Thêm "Cây cổ thụ ma thuật" phát sáng nhẹ, nơi khách có thể viết điều ước lên lá giả và treo lên cây.</p>

            <h4>Khu ao – bờ mương (10m x 30m):</h4>
            <p>Ao nhỏ thả cá lóc, cá rô, ốc bươu; bờ mương lầy lội để đặt lờ, lọp, giăng lưới.</p>
            <p>Cầu khỉ tre bắc qua mương, có dây vịn an toàn, tạo cảm giác phiêu lưu.</p>

            <h4>Khu săn bắt ếch – nhái (15m x 30m):</h4>
            <p>Bụi rậm, hốc cây, và đầm lầy nhân tạo, nơi thả ếch, nhái, ểnh ương, và ốc.</p>
            <p><strong>Điểm mới:</strong> Thêm "Con mồi bí ẩn" – ếch nhuộm huỳnh quang an toàn, xuất hiện trong các sự kiện đặc biệt, ai bắt được nhận quà lưu niệm.</p>

            <h4>Khu mê cung ma quái (15m x 25m):</h4>
            <p>Mê cung với nhiều ngõ cụt, sương mù dày đặc từ máy tạo khói.</p>
            <p>Mô hình động vật kinh dị (ếch khổng lồ, mèo ma, chó sói, ma quỷ, và rắn khổng lồ mới) được đặt ở các góc bất ngờ.</p>
            <p><strong>Điểm mới:</strong> Thêm "Hầm mộ bóng đêm" – một lối đi bí mật dưới lòng đất (an toàn, có đèn mờ), dẫn đến kho báu hoặc một mô hình ma quái đặc biệt.</p>
            <p>Nhân viên hóa trang xuất hiện ngẫu nhiên, mang đến hiệu ứng giật mình.</p>

            <h4>Khu đầm sen bóng đêm (10m x 15m):</h4>
            <p>Đầm sen nhân tạo với hoa sen phát sáng nhẹ, thuyền nhỏ (4 người/thuyền) chèo qua đầm, tạo không gian lãng mạn và check-in.</p>
            <p><strong>Điểm mới:</strong> Thêm "Đèn hoa sen" nổi trên mặt nước, khách có thể thả đèn với điều ước (an toàn, thân thiện môi trường).</p>

            <h4>Khu chòi ẩm thực & lửa trại (15m x 20m):</h4>
            <p>7–10 chòi tre lợp lá, mỗi chòi chứa 4–6 người, trang bị bếp than, nồi, chảo, gia vị.</p>
            <p>Khu lửa trại nhân tạo (đèn LED và quạt tạo hiệu ứng lửa), nơi khách nướng chiến lợi phẩm, hát hò, và nghe kể chuyện ma quái.</p>

            <h4>Khu trăng rằm thư giãn (10m x 10m):</h4>
            <p>Góc võng tre, đèn lồng, và nhạc acoustic, dành cho khách muốn nghỉ ngơi.</p>
            <p><strong>Điểm mới:</strong> Thêm "Góc kể chuyện" với MC kể các truyền thuyết dân gian về rừng đêm.</p>

            <h4>Khu vệ sinh – sơ cứu (5m x 15m):</h4>
            <p>Nhà vệ sinh sạch sẽ, khu thay đồ, và trạm y tế với nhân viên túc trực.</p>
            <p><strong>Điểm mới:</strong> Thêm tủ khóa an toàn để khách gửi đồ cá nhân.</p>

            <h3>Lối đi:</h3>
            <p>Thiết kế một chiều, khép kín, dẫn khách qua các khu theo thứ tự: đón khách → mê cung rừng → ao mương → săn bắt → đầm sen → mê cung ma quái → chòi ẩm thực/lửa trại → trăng rằm → quay về cổng.</p>
            <p>Đường đất tự nhiên, rộng 1.5m, lát đá chống trơn, có biển chỉ dẫn bằng gỗ khắc chữ phát sáng.</p>

            <h2>4. CHI TIẾT TRIỂN KHAI – NGHỆ THUẬT TẠO NÊN BÓNG TỐI</h2>

            <h3>4.1. Thiết kế cảnh quan & hạ tầng</h3>

            <h4>Hàng rào & mái che:</h4>
            <p>Hàng rào lưới B40 cao 2.5m, phủ dây leo giả và cây thật (cây trường xuân, dễ trồng).</p>
            <p>Mái che bằng 3 lớp lưới lan, kết hợp dây leo giả và đèn LED nhỏ tạo hiệu ứng sao trời.</p>

            <h4>Hệ thống nước:</h4>
            <p>Ống PVC 21mm, béc phun sương (120.000đ/m), tạo mưa nhẹ liên tục.</p>
            <p>Hệ thống thoát nước thông minh, dẫn nước ra ao nuôi, tiết kiệm tài nguyên.</p>

            <h4>Lối đi:</h4>
            <p>Đường đất tự nhiên, lát đá chống trơn ở các điểm ẩm ướt.</p>
            <p>Cầu khỉ tre bắc qua mương, có dây vịn và lưới bảo hộ ẩn.</p>

            <h4>Trang trí:</h4>
            <p>Hốc cây, bụi rậm, đầm lầy làm từ mút xốp, nhựa giả tự nhiên, và sơn phản quang nhẹ.</p>
            <p>Mô hình động vật kinh dị (ếch, mèo, chó, ma quỷ, rắn) làm từ mút xốp, gắn động cơ (quay đầu, há miệng), đèn LED đỏ, và loa phát tiếng kêu.</p>
            <p><strong>Điểm mới:</strong> Thêm "Tượng đá ma thuật" phát sáng ngẫu nhiên, tạo cảm giác huyền bí.</p>

            <h4>Hiệu ứng ánh sáng:</h4>
            <p>Đèn LED vàng mờ ẩn trong cây, tạo ánh trăng giả.</p>
            <p>Đèn strobe tạo hiệu ứng chớp sét, đặt ở khu mê cung.</p>
            <p>Đèn khẩn cấp ẩn, bật sáng tức thì khi cần cứu hộ.</p>
            <p><strong>Điểm mới:</strong> Thêm đèn UV ở khu săn bắt, làm nổi bật ếch huỳnh quang trong sự kiện đặc biệt.</p>

            <h4>Hiệu ứng âm thanh:</h4>
            <p>Loa Bluetooth công suất nhỏ, phát tiếng mưa, côn trùng, gió, sấm sét, và tiếng kêu ma quái.</p>
            <p><strong>Điểm mới:</strong> Thêm hiệu ứng "tiếng thì thầm" (giọng nói ma mị) ở khu mê cung ma quái.</p>

            <h4>Hiệu ứng gió & khói:</h4>
            <p>Quạt công nghiệp nhỏ tạo luồng gió lạnh.</p>
            <p>Máy tạo khói (2–3 máy) ở khu mê cung ma quái và đầm sen, tăng cảm giác huyền bí.</p>

            <h3>4.2. Trang thiết bị & đạo cụ</h3>

            <h4>Cho khách:</h4>
            <p>Đèn soi (đèn dầu nhỏ hoặc đèn pin sạc, 20.000–50.000đ/chiếc).</p>
            <p>Chĩa tre 2–3 mũi hoặc chĩa inox (50.000đ/chiếc).</p>
            <p>Cần câu tre, lưới nhỏ, lờ, lọp, giỏ tre (30.000–100.000đ/bộ).</p>
            <p>Áo mưa mỏng và ủng cao su (cho thuê 20.000đ hoặc bán 50.000đ).</p>
            <p><strong>Điểm mới:</strong> Vòng tay thông minh với nút cứu hộ, đèn LED nhỏ, và mã QR để nhận ảnh hồng ngoại.</p>

            <h4>Cho khu ma quái:</h4>
            <p>Mô hình động vật kinh dị (7 mô hình, 5–10 triệu/con), gắn động cơ, đèn LED, và loa.</p>
            <p>Máy tạo khói (3 máy, 2–3 triệu/máy).</p>
            <p><strong>Điểm mới:</strong> Trang phục hóa trang cao cấp (ma quỷ, mèo ma, thợ săn ma thuật) với hiệu ứng đèn LED và khói mini.</p>

            <h3>4.3. Động vật thả nuôi</h3>
            <p><strong>Loài:</strong> Ếch đồng, nhái, ểnh ương, cá lóc, cá rô, cá trê, ốc bươu, và tôm càng xanh (mới).</p>
            <p><strong>Nguồn cung:</strong> Mua từ trại giống địa phương, đảm bảo động vật khỏe mạnh, dễ bắt.</p>
            <p><strong>Số lượng:</strong></p>
            <p>Ếch/nhái: 150–200 con/lượt, 2 lượt/ngày (300–400 con/ngày).</p>
            <p>Cá: 50–100 con/lượt.</p>
            <p>Ốc: 10–15kg/lượt.</p>
            <p>Tôm: 5–10kg/lượt (sự kiện đặc biệt).</p>
            <p><strong>Chi phí:</strong> 7–10 triệu/tháng, thả định kỳ 2–3 ngày/lần.</p>
            <p><strong>Điểm mới:</strong> Ếch huỳnh quang an toàn (sử dụng mực sinh học), xuất hiện trong sự kiện "Săn đêm ma thuật".</p>

            <h3>4.4. Nhân sự & vận hành</h3>
            <p><strong>Cơ cấu nhân sự (ca 6 tiếng, 17h00–23h00, 2 ca/ngày):</strong></p>
            <p>1 quản lý: Điều hành, xử lý sự cố.</p>
            <p>3 hướng dẫn viên: Dẫn đoàn, tạo không khí, kể chuyện.</p>
            <p>2 kỹ thuật viên: Vận hành phun mưa, ánh sáng, âm thanh.</p>
            <p>3 nhân viên hóa trang: Đóng vai ma quỷ, mèo ma, thợ săn ma thuật.</p>
            <p>2 nhân viên hỗ trợ: Phát/thu dụng cụ, hỗ trợ y tế, chèo thuyền đầm sen.</p>
            <p><strong>Tổng:</strong> 11 người/ca, 22 người/ngày.</p>
            <p><strong>Chi phí nhân sự:</strong> 150–180 triệu/tháng (lương 5–8 triệu/người).</p>

            <h3>4.5. Quy trình trải nghiệm (120 phút)</h3>

            <h4>Phút 0–15: Đón khách</h4>
            <p>MC chào đón, phát dụng cụ, và kể câu chuyện "Lời nguyền bóng đêm" về một thợ săn bị mắc kẹt trong rừng ma quái.</p>
            <p>Phổ biến nội quy: không chạy, đi theo nhóm, nhấn nút cứu hộ nếu cần.</p>

            <h4>Phút 15–35: Đường mê cung rừng</h4>
            <p>Khách đi qua lối zig-zag, cảm nhận mưa nhẹ, ánh trăng, tiếng sấm, và tiếng thì thầm ma mị.</p>
            <p>MC: "Cẩn thận, có thứ gì đó đang rình rập trong bụi cây…".</p>

            <h4>Phút 35–55: Khu ao – bờ mương</h4>
            <p>Khách đặt lờ, giăng lưới, câu cá, soi ốc, và tôm.</p>
            <p>MC: "Ai sẽ bắt được con tôm càng xanh huyền thoại?".</p>

            <h4>Phút 55–75: Khu săn bắt ếch – nhái</h4>
            <p>Khách soi đèn bắt ếch, nhái, và ốc.</p>
            <p>MC: "Soi vào gốc cây, bạn thấy đôi mắt huỳnh quang kia không?".</p>

            <h4>Phút 75–90: Khu đầm sen bóng đêm</h4>
            <p>Khách ngồi thuyền nhỏ, ngắm hoa sen phát sáng, thả đèn hoa sen với điều ước.</p>
            <p>MC: "Hãy thì thầm điều ước, nhưng đừng để ma quái nghe thấy…".</p>

            <h4>Phút 90–110: Khu mê cung ma quái</h4>
            <p>Mô hình động vật kinh dị chuyển động, nhân viên hóa trang xuất hiện.</p>
            <p>MC: "Đi chậm thôi, cánh cửa bí mật đang chờ bạn… nhưng bạn dám mở không?".</p>

            <h4>Phút 110–120: Chòi ẩm thực, lửa trại & trăng rằm</h4>
            <p>Khách nấu cháo, nướng cá, hoặc tham gia lửa trại hát hò.</p>
            <p>MC tổng kết, thu dụng cụ, tặng ảnh hồng ngoại qua mã QR.</p>

            <h2>5. DỰ TOÁN CHI PHÍ – ĐẦU TƯ THÔNG MINH, LỢI NHUẬN KHỦNG</h2>

            <h3>Chi phí đầu tư ban đầu</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background: #2196F3; color: white;">
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Hạng mục</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Khối lượng</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Đơn giá (VNĐ)</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Thành tiền (VNĐ)</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Hàng rào B40 + dây leo</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">200m dài</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">400.000/m</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">80.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Mái lưới lan + đèn sao</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">2.500m²</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">80.000/m²</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">200.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Hệ thống phun mưa</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">250m ống</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">120.000/m</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">30.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Hệ thống đèn, loa, quạt</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">Trọn gói</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">-</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">100.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Làm đường, mương, cầu khỉ</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">Trọn gói</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">-</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">60.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Ao nuôi + đầm sen</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">3 ao nhỏ</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">-</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">50.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Mô hình ma quái (7 con)</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">7 mô hình</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">8.000.000/con</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">56.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Máy tạo khói</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">3 máy</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">3.000.000/máy</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">9.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Nhà chờ + chòi tre</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">100m²</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">1.800.000/m²</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">180.000.000</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">Dụng cụ & vòng tay thông minh</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">150 bộ</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">300.000/bộ</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">45.000.000</td>
                </tr>
                <tr style="background: #f5f5f5; font-weight: bold;">
                    <td style="border: 1px solid #ddd; padding: 8px;" colspan="3">Tổng chi phí đầu tư ban đầu</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">610.000.000</td>
                </tr>
            </table>

            <h3>Chi phí duy trì hàng tháng</h3>
            <p>Con giống (ếch, cá, ốc, tôm): 7–10 triệu.</p>
            <p>Điện, nước, bảo trì: 7 triệu.</p>
            <p>Nhân sự (22 người): 150–180 triệu.</p>
            <p><strong>Tổng:</strong> 164–197 triệu/tháng.</p>

            <h2>6. KẾ HOẠCH MARKETING – BÙNG NỔ MẠNG XÃ HỘI</h2>

            <h3>Mục tiêu:</h3>
            <p>Thu hút 1.500 khách trong tháng đầu (80% công suất, 50–60 khách/ngày).</p>
            <p>Tạo hiệu ứng viral trên TikTok, Instagram, Facebook, YouTube với hashtag #VuonBongDem, #SanBongDem, #LoiNguyenBongDem.</p>
            <p>Biến Khu Vườn Bóng Đêm thành điểm check-in "must-visit" của giới trẻ.</p>

            <h3>Giai đoạn 1: Teaser (Ngày -10 đến -1)</h3>
            <p><strong>Ngày -10:</strong> Poster "Khu Vườn Bóng Đêm – Lời nguyền dưới ánh trăng" với hình ảnh rừng đêm, ma quái, và ánh mắt đỏ rực. Đăng TikTok, Instagram.</p>
            <p><strong>Ngày -9:</strong> Clip teaser 15 giây: Tiếng sấm, ánh chớp, bóng thợ săn lướt qua, kết thúc bằng câu "Bạn dám bước vào?".</p>
            <p><strong>Ngày -8:</strong> Livestream hậu trường: Zoom cận cảnh mô hình ếch khổng lồ, nhưng giữ bí mật.</p>
            <p><strong>Ngày -7:</strong> Minigame "Tìm thợ săn mất tích" trên Instagram, giải thưởng: 10 vé miễn phí.</p>
            <p><strong>Ngày -6:</strong> Ảnh dụng cụ (đèn dầu, chĩa, vòng tay thông minh). Caption: "Hành trang săn đêm, bạn sẵn sàng chưa?".</p>
            <p><strong>Ngày -5:</strong> Clip 30 giây: Tester hét lên khi gặp ma quái, cười sảng khoái ở cuối.</p>
            <p><strong>Ngày -4:</strong> Livestream setup đầm sen, thả đèn hoa sen thử nghiệm.</p>
            <p><strong>Ngày -3:</strong> Minigame "Đoán tiếng kêu ma quái" trên TikTok, giải: 5 vé VIP.</p>
            <p><strong>Ngày -2:</strong> Video flycam toàn cảnh khu vườn, kết thúc bằng logo và slogan.</p>
            <p><strong>Ngày -1:</strong> Công bố khai trương, giá vé, giờ mở cửa, kèm trailer 1 phút đầy kịch tính.</p>

            <h3>Giai đoạn 2: Tuần khai trương (Ngày 1–7)</h3>
            <p><strong>Ngày 1:</strong> Sự kiện khai trương với KOL, cosplay ma quái, và màn thả đèn hoa sen. Giảm 25% giá vé.</p>
            <p><strong>Ngày 2:</strong> Đăng clip cảm nhận khách: "Sợ nhưng nghiện, phải đi lại!".</p>
            <p><strong>Ngày 3:</strong> Album ảnh 200 khách đầu tiên, hashtag #VuonBongDem.</p>
            <p><strong>Ngày 4:</strong> Livestream săn ếch huỳnh quang, zoom cận cảnh chiến lợi phẩm.</p>
            <p><strong>Ngày 5:</strong> Minigame "Chụp ảnh ma quái", tặng 5 vé miễn phí.</p>
            <p><strong>Ngày 6:</strong> Video hậu trường "Tạo nên mô hình ma quái như thế nào?".</p>
            <p><strong>Ngày 7:</strong> Mời YouTuber quay vlog trải nghiệm toàn bộ hành trình.</p>

            <h3>Giai đoạn 3: 3 tuần tiếp theo (Ngày 8–30)</h3>
            <p><strong>Ngày chẵn:</strong> Post video khách săn bắt, nướng cá, thả đèn sen.</p>
            <p><strong>Ngày lẻ:</strong> Minigame like, share, tag bạn bè, tặng vé ưu đãi.</p>
            <p><strong>Ngày 15:</strong> Sự kiện "1 giờ không hét", livestream, tặng quà cho người thắng.</p>
            <p><strong>Ngày 20:</strong> Đêm Halloween mini: Cosplay, tăng hiệu ứng ma quái, giảm 20% vé.</p>
            <p><strong>Ngày 30:</strong> Sự kiện "Săn Vua Ếch", mời KOL, truyền thông mạnh.</p>

            <h2>7. CHIẾN LƯỢC GIÁ VÉ – ĐA DẠNG, HẤP DẪN</h2>
            <p><strong>Vé lẻ:</strong> 350.000đ/người (120 phút).</p>

            <h3>Combo nhóm:</h3>
            <p>4 người: 1.300.000đ (tiết kiệm 100.000đ).</p>
            <p>6 người: 1.900.000đ (tiết kiệm 200.000đ).</p>

            <h3>Gói đoàn:</h3>
            <p>20 vé: Giảm 15%.</p>
            <p>50 vé: Giảm 20% + suất ăn nhẹ (cháo hoặc trà thảo mộc).</p>

            <h3>Combo ẩm thực:</h3>
            <p>+100.000đ/người: Đầu bếp chế biến (cháo ếch, cá nướng, ốc hấp).</p>
            <p>+50.000đ/người: Khách tự nấu (cung cấp bếp, gia vị).</p>

            <h3>Gói VIP: 600.000đ/người, bao gồm:</h3>
            <p>Hướng dẫn viên riêng, kể chuyện huyền bí.</p>
            <p>Món ăn cao cấp (cháo ếch Singapore, tôm nướng bơ tỏi).</p>
            <p>Ảnh/video hồng ngoại in tại chỗ.</p>

            <h3>Gói Ultra VIP: 1.000.000đ/người, bao gồm:</h3>
            <p>Trải nghiệm VR mê cung ma quái.</p>
            <p>Thuyền riêng ở đầm sen, chụp ảnh với thợ ảnh chuyên nghiệp.</p>
            <p>Quà lưu niệm (mô hình ếch mini, huy hiệu "Thợ săn bóng đêm").</p>

            <h2>8. LỢI ÍCH & TIỀM NĂNG – BIỂU TƯỢNG DU LỊCH MỚI</h2>
            <p><strong>Độc đáo:</strong> Kết hợp săn bắt dân gian, ẩm thực, cảm giác mạnh, và công nghệ hiện đại trong một không gian rừng đêm huyền bí.</p>
            <p><strong>Hấp dẫn đa đối tượng:</strong> Giới trẻ thích check-in, gia đình muốn gắn kết, khách du lịch tìm trải nghiệm độc lạ.</p>
            <p><strong>Tính lan tỏa:</strong> Video săn ếch, ảnh hồng ngoại, và thử thách ma quái dễ viral trên TikTok, Instagram.</p>

            <h3>Doanh thu tiềm năng:</h3>
            <p>60 khách/ngày x 350.000đ = 21 triệu/ngày.</p>
            <p>Tháng đầu: 21 triệu x 30 ngày = 630 triệu.</p>
            <p>Trừ chi phí duy trì (197 triệu): Lợi nhuận ~433 triệu/tháng.</p>
            <p><strong>Tính bền vững:</strong> Hoàn vốn trong 2–3 tháng, dễ mở rộng nhượng quyền.</p>

            <h2>9. TIMELINE TRIỂN KHAI – HÀNH TRÌNH 3 THÁNG</h2>

            <h3>Giai đoạn 1: Chuẩn bị (0–4 tuần)</h3>
            <p>Dọn mặt bằng, thiết kế bản vẽ.</p>
            <p>Đặt vật tư, con giống, mô hình ma quái.</p>

            <h3>Giai đoạn 2: Thi công (5–9 tuần)</h3>
            <p>Làm hàng rào, mái lưới, hệ thống phun mưa.</p>
            <p>Đào ao, đầm sen, lắp âm thanh, ánh sáng.</p>

            <h3>Giai đoạn 3: Vận hành thử (10–11 tuần)</h3>
            <p>Test hệ thống, mời 50 khách nội bộ.</p>

            <h3>Giai đoạn 4: Khai trương (12–13 tuần)</h3>
            <p>Chạy teaser 10 ngày trước.</p>
            <p>Sự kiện khai trương với KOL, cosplay, và thả đèn sen.</p>

            <h2>10. BỘ NHẬN DIỆN THƯƠNG HIỆU – HUYỀN BÍ & MA MỊ</h2>
            <p><strong>Tên:</strong> NIGHT HUNTERS – Khu Vườn Bóng Đêm.</p>
            <p><strong>Slogan:</strong> "Bóng tối gọi tên bạn – Bạn dám trả lời?".</p>
            <p><strong>Màu sắc:</strong> Xanh rừng (#013220), vàng trăng (#FFD700), tím ma mị (#4B0082).</p>
            <p><strong>Logo:</strong> Mặt trăng vàng, bóng thợ săn cầm chĩa, xung quanh là dây leo và mắt ma quái.</p>
            <p><strong>Poster:</strong> Rừng đêm, mưa rơi, ánh sét, thợ săn đối diện ếch khổng lồ.</p>
            <p><strong>Vé:</strong> Mặt trước in logo, mặt sau có mã QR và câu chuyện "Lời nguyền bóng đêm".</p>
            <p><strong>Biển chỉ dẫn:</strong> Gỗ tự nhiên, khắc chữ phát sáng, phong cách cổ xưa.</p>

            <h2>11. QUY TRÌNH VẬN HÀNH – MỌI THỨ DƯỚI SỰ KIỂM SOÁT</h2>
            <p><strong>Trước giờ mở cửa:</strong> Kiểm tra hệ thống, thả con giống, vệ sinh khu vực.</p>
            <p><strong>Trong giờ hoạt động:</strong> Đón khách, dẫn đoàn, giám sát qua camera.</p>
            <p><strong>Xử lý sự cố:</strong> Mất điện, khách hoảng loạn, hoặc bị thương đều có quy trình chuẩn.</p>
            <p><strong>Sau giờ đóng cửa:</strong> Thu dọn, báo cáo doanh thu, chuẩn bị cho ngày tiếp theo.</p>

            <h2>12. ĐỀ XUẤT BỔ SUNG – NÂNG TẦM TRẢI NGHIỆM</h2>

            <h3>Sự kiện đặc biệt:</h3>
            <p><strong>Săn đêm ma thuật:</strong> Thả ếch huỳnh quang, tăng mô hình ma quái, cosplay thợ săn cổ xưa.</p>
            <p><strong>Lễ hội trăng rằm:</strong> Thả đèn sen, tổ chức hát hò, kể chuyện dân gian.</p>

            <h3>Trải nghiệm cá nhân hóa:</h3>
            <p>Khách có thể đặt tên cho ếch huỳnh quang (in trên vòng đeo chân), thả vào khu vườn làm kỷ niệm.</p>
            <p><strong>Gói "Thợ săn huyền thoại":</strong> Quay video hành trình riêng, chỉnh sửa chuyên nghiệp.</p>

            <h3>Công nghệ tương tác:</h3>
            <p>App "Night Hunters" với mini-game săn ếch ảo, tích điểm đổi vé.</p>
            <p>Kính VR cho trải nghiệm mê cung ma quái ảo (tùy chọn).</p>

            <h3>Khu vực trẻ em:</h3>
            <p>Khu săn bắt mini với cá nhựa, ếch đồ chơi, đảm bảo an toàn.</p>
            <p>MC hóa trang thành "Thợ săn nhí" dẫn dắt các bé.</p>

            <h2>13. KẾT LUẬN – GIẤC MƠ TRONG BÓNG TỐI</h2>
            <p>Khu Vườn Bóng Đêm là một bản giao hưởng của cảm xúc, nơi bạn đối mặt với nỗi sợ, chinh phục bản năng, và tận hưởng những khoảnh khắc không thể nào quên. Với chi phí đầu tư hợp lý (610 triệu), lợi nhuận tiềm năng khủng (433 triệu/tháng), và một mô hình giải trí đột phá, dự án này không chỉ là một điểm đến, mà là một huyền thoại mới trong ngành du lịch Việt Nam.</p>

            <p>Hãy tưởng tượng: bạn bước ra khỏi khu vườn, tay cầm giỏ chiến lợi phẩm, trên môi là nụ cười chiến thắng, và trong lòng là câu chuyện về một đêm không thể nào quên. Khu Vườn Bóng Đêm đang chờ bạn – "Bóng tối gọi tên bạn, bạn dám trả lời?".</p>

            <div class="highlight">
                <strong>🌟 TỔNG KẾT DỰ ÁN:</strong><br>
                ✅ Chi phí đầu tư: 610 triệu VNĐ<br>
                ✅ Lợi nhuận dự kiến: 433 triệu/tháng<br>
                ✅ Thời gian hoàn vốn: 2-3 tháng<br>
                ✅ Mô hình có thể nhân rộng và nhượng quyền<br>
                ✅ Trải nghiệm độc đáo đầu tiên tại Việt Nam<br><br>
                <em>"Một dự án không chỉ mang lại lợi nhuận mà còn tạo nên những kỷ niệm khó quên cho hàng nghìn du khách mỗi tháng."</em>
            </div>
        </div>
    </div>

    <div class="footer">
        © 2025 - Tài liệu được bảo vệ bởi luật bản quyền
    </div>
</div>

<script>
    // Ngăn right-click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        showWarning();
        return false;
    });

    // Ngăn các phím tắt
    document.addEventListener('keydown', function(e) {
        // Ngăn Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+S, Ctrl+P, F12, etc.
        if (e.ctrlKey && (e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 83 || e.keyCode === 80)) {
            e.preventDefault();
            showWarning();
            return false;
        }

        // Ngăn F12 (Developer Tools)
        if (e.keyCode === 123) {
            e.preventDefault();
            showWarning();
            return false;
        }

        // Ngăn Ctrl+Shift+I (Developer Tools)
        if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
            e.preventDefault();
            showWarning();
            return false;
        }

        // Ngăn Ctrl+U (View Source)
        if (e.ctrlKey && e.keyCode === 85) {
            e.preventDefault();
            showWarning();
            return false;
        }
    });

    // Hiện cảnh báo
    function showWarning() {
        const warning = document.getElementById('warning');
        warning.classList.add('show');
        setTimeout(() => {
            warning.classList.remove('show');
        }, 3000);
    }

    // Phát hiện Developer Tools
    let devtools = false;
    setInterval(() => {
        if (window.outerHeight - window.innerHeight > 200 || window.outerWidth - window.innerWidth > 200) {
            if (!devtools) {
                devtools = true;
                document.getElementById('overlay').style.display = 'flex';
            }
        } else {
            if (devtools) {
                devtools = false;
                document.getElementById('overlay').style.display = 'none';
            }
        }
    }, 500);

    // Ngăn select text bằng mouse
    document.onselectstart = function() {
        return false;
    };

    document.onmousedown = function() {
        return false;
    };

    // Ngăn kéo thả
    document.ondragstart = function() {
        return false;
    };

    // Phát hiện Print Screen (không hoàn toàn hiệu quả)
    document.addEventListener('keyup', function(e) {
        if (e.keyCode === 44) {
            showWarning();
            // Có thể thêm code để blur nội dung tạm thời
            document.body.style.filter = 'blur(10px)';
            setTimeout(() => {
                document.body.style.filter = 'none';
            }, 2000);
        }
    });

    // Ngăn chụp màn hình bằng cách blur khi mất focus
    window.addEventListener('blur', function() {
        document.body.style.filter = 'blur(5px)';
    });

    window.addEventListener('focus', function() {
        document.body.style.filter = 'none';
    });

    // Disable text selection với CSS và JS
    document.body.style.webkitUserSelect = 'none';
    document.body.style.mozUserSelect = 'none';
    document.body.style.msUserSelect = 'none';
    document.body.style.userSelect = 'none';

    // Thông báo khi load trang
    window.addEventListener('load', function() {
        try {
            console.log('%cTÀI LIỆU BẢO MẬT!', 'color: red; font-size: 50px; font-weight: bold;');
            console.log('%cKhông được phép truy cập Developer Tools!', 'color: red; font-size: 20px;');
        } catch(e) {
            // Bỏ qua lỗi console trong môi trường hạn chế
        }
    });
</script>
</body>
</html>
