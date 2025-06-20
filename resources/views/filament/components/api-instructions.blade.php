<div style="line-height: 1.6; font-size: 14px; color: #6b7280; padding: 10px; background-color: #f9fafb; border: 1px solid #d1d5db; border-radius: 4px;">
    <div class="font-semibold text-base text-blue-700">
        📘 Hướng Dẫn Kết Nối Facebook & Instagram API
    </div>

    <strong>🔹 App ID & App Secret:</strong><br>
    1. Truy cập <a href="https://developers.facebook.com/apps/" target="_blank" style="color: #3b82f6;">Facebook Developers</a>.<br>
    2. Đăng nhập và nhấn "Create App" nếu bạn chưa có ứng dụng.<br>
    3. Sau khi tạo, vào phần <strong>Settings > Basic</strong> để sao chép <strong>App ID</strong> và <strong>App Secret</strong>.<br><br>

    <strong>🔹 User Access Token (Token người dùng):</strong><br>
    1. Truy cập <a href="https://developers.facebook.com/tools/explorer/" target="_blank" style="color: #3b82f6;">Graph API Explorer</a>.<br>
    2. Chọn ứng dụng bạn vừa tạo ở dropdown.<br>
    3. Nhấn vào <strong>"Get Token" > "Get User Access Token"</strong>.<br>
    4. Chọn các quyền:<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ pages_show_list<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ pages_read_engagement<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ pages_read_user_content<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ pages_manage_posts<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ publish_pages<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ instagram_basic<br>
    &nbsp;&nbsp;&nbsp;&nbsp;✔ instagram_content_publish<br>
    5. Nhấn "Generate Access Token", sau đó copy token và dán vào ô <strong>User Access Token</strong> ở trên.<br><br>

    <strong>🔹 Kết nối tài khoản Instagram:</strong><br>
    1. Tài khoản Instagram phải là <strong>Business</strong> hoặc <strong>Creator</strong>.<br>
    2. Tài khoản này phải được <strong>liên kết với Fanpage Facebook</strong>.<br>
    3. Truy cập <a href="https://www.facebook.com/pages/" target="_blank" style="color: #3b82f6;">Trang Facebook</a> &rarr; vào phần <strong>Cài đặt</strong> &rarr; <strong>Instagram</strong> để đảm bảo đã liên kết.<br>
    4. Khi gọi API, cần lấy <strong>Instagram Business Account ID</strong> thông qua endpoint:<br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>GET /{page-id}?fields=instagram_business_account</code><br>
    5. Dùng ID này để đăng bài qua endpoint:<br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>POST /{ig-user-id}/media</code> và <code>/media_publish</code><br>
</div>
