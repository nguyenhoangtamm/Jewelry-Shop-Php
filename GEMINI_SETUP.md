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
