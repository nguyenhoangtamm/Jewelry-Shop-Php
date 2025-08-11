<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 28px;
        }

        .content {
            margin-bottom: 30px;
        }

        .content h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .content p {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .reset-button {
            text-align: center;
            margin: 30px 0;
        }

        .reset-button a {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .reset-button a:hover {
            transform: translateY(-2px);
        }

        .alternative-link {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .alternative-link p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .alternative-link a {
            color: #667eea;
            word-break: break-all;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .warning strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="content">
            <h2>Xin chào {{ $user->fullname ?? $user->username }},</h2>

            <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>

            <p>Nếu bạn đã yêu cầu đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới để tiếp tục:</p>

            <div class="reset-button">
                <a href="{{ $url }}" target="_blank">Đặt lại mật khẩu</a>
            </div>

            <div class="alternative-link">
                <p><strong>Nếu nút không hoạt động, vui lòng sao chép và dán liên kết sau vào trình duyệt:</strong></p>
                <p><a href="{{ $url }}">{{ $url }}</a></p>
            </div>

            <div class="warning">
                <strong>Lưu ý quan trọng:</strong>
                <p>• Liên kết này sẽ hết hạn sau 24 giờ</p>
                <p>• Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</p>
                <p>• Để bảo mật tài khoản, không chia sẻ liên kết này với bất kỳ ai</p>
            </div>

            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>

            <p>Trân trọng,<br>
                Đội ngũ {{ config('app.name') }}</p>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>