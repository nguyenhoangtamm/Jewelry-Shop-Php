<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .forgot-password-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #667eea 0%, #764ba2 100%);
        }

        .forgot-password-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            min-width: 500px;
            margin: 0 20px;
            text-align: center;
        }

        .forgot-password-form h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .forgot-password-form p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .forgot-password-form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .forgot-password-form button {
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

        .forgot-password-form button:hover {
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
    </style>
</head>

<body>
    <div class="forgot-password-container">
        <div class="forgot-password-form">
            <h1><i class='bx bx-lock-alt'></i> Quên mật khẩu?</h1>
            <p>Nhập email của bạn và chúng tôi sẽ gửi cho bạn link để đặt lại mật khẩu.</p>

            <div id="alert-message" class="alert" style="display: none;"></div>

            <form id="forgotPasswordForm">
                @csrf
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
                <button type="submit">
                    <span class="loading"></span>
                    <span class="button-text">Gửi link đặt lại mật khẩu</span>
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
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            const loading = submitButton.querySelector('.loading');
            const buttonText = submitButton.querySelector('.button-text');
            const alertDiv = document.getElementById('alert-message');

            // Hiển thị loading
            loading.classList.add('show');
            buttonText.textContent = 'Đang gửi...';
            submitButton.disabled = true;

            // Ẩn alert cũ
            alertDiv.style.display = 'none';

            const formData = new FormData(form);

            fetch('{{ route("password.email") }}', {
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
                        form.reset();
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
                    buttonText.textContent = 'Gửi link đặt lại mật khẩu';
                    submitButton.disabled = false;
                });
        });
    </script>
</body>

</html>