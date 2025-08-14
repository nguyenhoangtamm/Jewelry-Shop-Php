# Jewelry Shop - Laravel Project

> Dự án quản lý cửa hàng trang sức, xây dựng bằng Laravel.

## Mục lục

-   [Giới thiệu](#giới-thiệu)
-   [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
-   [Cài đặt](#cài-đặt)
-   [Cấu trúc thư mục](#cấu-trúc-thư-mục)
-   [Sử dụng](#sử-dụng)
-   [Đóng góp](#đóng-góp)
-   [Thông tin liên hệ](#thông-tin-liên-hệ)

## Giới thiệu

Dự án Jewelry Shop là một hệ thống quản lý cửa hàng trang sức, hỗ trợ các chức năng quản lý sản phẩm, đơn hàng, người dùng, đánh giá, v.v. Dự án sử dụng framework Laravel (PHP) giúp phát triển nhanh chóng, bảo mật và dễ mở rộng.

## Yêu cầu hệ thống

-   PHP >= 8.1
-   Composer
-   MySQL/MariaDB
-   Node.js & npm (nếu muốn build frontend)

## Cài đặt

1. Clone dự án:
    ```bash
    git clone https://github.com/nguyenhoangtamm/Jewelry-Shop-Php.git
    cd Jewelry-Shop
    ```
2. Cấu hình Php
   Đảm bảo các extension sau đã được bật trong file `php.ini`:
   (nêu dùng xampp thì bỏ quả bươc này)
   Chuyển từ

```ini
;extension=mysqli
;extension=pdo_mysql
;extension=zip
```

```ini
extension=mysqli
extension=pdo_mysql
extension=zip
```

Nếu sử dụng 7-Zip cho các chức năng nén/giải nén, hãy đảm bảo bạn đã cài đặt 7-Zip trên hệ thống và thêm đường dẫn của nó vào biến môi trường `PATH` (Windows).  
Sau khi chỉnh sửa, hãy khởi động lại Apache hoặc PHP-FPM. 3. Cài đặt các package PHP:
`bash
    composer install
    ` 4. Tạo file `.env` từ file mẫu và cấu hình thông tin database:
`bash
    cp .env.example .env
    # Hoặc trên Windows: copy .env.example .env
    ` 5. Tạo key ứng dụng:
`bash
    php artisan key:generate
    ` 6. Chạy migration và seed dữ liệu mẫu:
`bash
    php artisan migrate
    ` 7. Khởi động server:
`bash
    php artisan serve
    `

## Cấu trúc thư mục

-   `app/Models/` - Các model Eloquent (Category, Jewelry, Order, User...)
-   `app/Http/Controllers/` - Controller xử lý logic request
-   `database/migrations/` - Các file migration tạo bảng
-   `database/seeders/` - Seeder dữ liệu mẫu
-   `resources/views/` - Giao diện Blade
-   `public/` - Thư mục public, entrypoint index.php
-   `routes/web.php` - Định nghĩa route web

## Sử dụng

-   Truy cập trang chủ tại: `http://localhost:8000`
-   Đăng nhập/đăng ký tài khoản để sử dụng các chức năng quản lý
-   Quản lý sản phẩm, đơn hàng, người dùng, đánh giá, upload file, v.v.

## Đóng góp

Mọi đóng góp, báo lỗi hoặc đề xuất tính năng mới đều được hoan nghênh! Vui lòng tạo issue hoặc pull request.

## Thông tin liên hệ

-   Tác giả: Nguyễn Hoàng Tâm
-   Email: [nguyenhoangtamm@gmail.com](mailto:nguyenhoangtamm@gmail.com)

## License

Dự án sử dụng giấy phép [MIT](https://opensource.org/licenses/MIT).

# Hướng dẫn tích hợp Google Gemini API

## Bước 1: Lấy API Key từ Google AI Studio

1. Truy cập: https://makersuite.google.com/app/apikey
2. Đăng nhập bằng tài khoản Google
3. Nhấn "Create API Key"
4. Copy API key được tạo

## Bước 2: Cấu hình API Key

1. Mở file `.env` trong thư mục gốc dự án
2. Tìm dòng: `GEMINI_API_KEY=your_gemini_api_key_here`
3. Thay thế `your_gemini_api_key_here` bằng API key thực tế của bạn

Ví dụ:

```
GEMINI_API_KEY=abcdef
```

## Bước 3: Test Chatbox

1. Khởi động server: `php artisan serve`
2. Truy cập chatbox trên website
3. Gửi tin nhắn để test AI response

## Tính năng mới sau khi tích hợp:

✅ **AI thông minh**: Phản hồi tự nhiên và hiểu ngữ cảnh
✅ **Tư vấn chuyên sâu**: Có thể phân tích yêu cầu phức tạp
✅ **Đa ngôn ngữ**: Hỗ trợ cả tiếng Việt và tiếng Anh
✅ **Fallback system**: Vẫn hoạt động khi API gặp lỗi
✅ **Logging**: Ghi log lỗi để debug

## Lưu ý:

-   API key cần được bảo mật, không chia sẻ công khai
-   Gemini API có giới hạn request miễn phí hàng tháng
-   Hệ thống sẽ tự động chuyển về rule-based nếu API fail
