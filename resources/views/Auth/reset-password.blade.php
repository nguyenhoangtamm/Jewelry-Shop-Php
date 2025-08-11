<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .reset-password-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #667eea 0%, #764ba2 100%);
        }

        .reset-password-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .reset-password-form h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .reset-password-form p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .reset-password-form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .reset-password-form button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.3s ease;
        }

        .reset-password-form button:hover {
            transform: translateY(-2px);
        }

        .back-to-login {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .back-to-login a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .password-requirements {
            text-align: left;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 14px;
        }

        .password-requirements ul {
            margin: 5px 0 0 20px;
            color: #666;
        }

        .password-requirements li {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="reset-password-container">
        <div class="reset-password-form">
            <h1><i class='bx bx-key'></i> Đặt lại mật khẩu</h1>
            <p>Nhập mật khẩu mới của bạn để hoàn tất quá trình đặt lại.</p>

            <div id="alert-message" class="alert" style="display: none;"></div>

            <form id="resetPasswordForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="email" name="email" value="{{ $email }}" readonly style="background-color: #f5f5f5;">

                <div class="password-requirements">
                    <strong>Yêu cầu mật khẩu:</strong>
                    <ul>
                        <li>Ít nhất 8 ký tự</li>
                        <li>Nên có chữ hoa, chữ thường</li>
                        <li>Nên có số và ký tự đặc biệt</li>
                    </ul>
                </div>

                <input type="password" name="password" placeholder="Mật khẩu mới" required minlength="8">
                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required minlength="8">

                <button type="submit">
                    <span class="loading"></span>
                    <span class="button-text">Đặt lại mật khẩu</span>
                </button>
            </form>

            <div class="back-to-login">
                <a href="{{ route('login') }}">
                    <i class='bx bx-arrow-back'></i> Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            const loading = submitButton.querySelector('.loading');
            const buttonText = submitButton.querySelector('.button-text');
            const alertDiv = document.getElementById('alert-message');
            const password = form.querySelector('input[name="password"]').value;
            const passwordConfirmation = form.querySelector('input[name="password_confirmation"]').value;

            // Kiểm tra mật khẩu khớp
            if (password !== passwordConfirmation) {
                alertDiv.className = 'alert alert-error';
                alertDiv.textContent = 'Mật khẩu xác nhận không khớp.';
                alertDiv.style.display = 'block';
                return;
            }

            // Hiển thị loading
            loading.classList.add('show');
            buttonText.textContent = 'Đang xử lý...';
            submitButton.disabled = true;

            // Ẩn alert cũ
            alertDiv.style.display = 'none';

            const formData = new FormData(form);

            fetch('{{ route("password.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertDiv.className = 'alert alert-success';
                        alertDiv.textContent = data.message;
                        alertDiv.style.display = 'block';

                        // Chuyển hướng về trang login sau 2 giây
                        setTimeout(() => {
                            window.location.href = '{{ route("login") }}';
                        }, 2000);
                    } else {
                        alertDiv.className = 'alert alert-error';
                        alertDiv.textContent = data.message || 'Có lỗi xảy ra. Vui lòng thử lại.';
                        alertDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alertDiv.className = 'alert alert-error';
                    alertDiv.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    alertDiv.style.display = 'block';
                })
                .finally(() => {
                    // Ẩn loading
                    loading.classList.remove('show');
                    buttonText.textContent = 'Đặt lại mật khẩu';
                    submitButton.disabled = false;
                });
        });
    </script>
</body>

</html>