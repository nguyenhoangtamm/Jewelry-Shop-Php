<!-- Alert messages -->
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div id="alert-message" class="alert" style="display: none;"></div>

<div class="container" id="main">
    <div class="sign-up">
        <form id="registerForm" action="{{ route('auth.register') }}" method="POST">
            @csrf
            <h1>Đăng ký</h1>
            <div class="social-container">
                <span class="social"><i class='bx bxl-facebook-circle'></i></span>
                <span class="social"><i class='bx bxl-discord-alt'></i></span>
                <span class="social"><i class='bx bxl-tiktok'></i></span>
            </div>
            <p>or use your email for registration</p>
            <input type="text" name="fullname" placeholder="Họ và tên đầy đủ" required>
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone_number" placeholder="Số điện thoại" pattern="[0-9]{10}" required>
            <input type="date" name="date_of_birth" placeholder="Ngày sinh" required>
            <input type="text" name="address" placeholder="Địa chỉ (tùy chọn)">
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
            <button type="submit">Đăng ký</button>
        </form>
    </div>
    <div class="sign-in">
        <form id="loginForm" action="{{ route('auth.login') }}" method="POST">
            @csrf
            <h1>Đăng nhập</h1>
            <div class="social-container">
                <a href="#" class="social"><i class='bx bxl-facebook-circle'></i></a>
                <a href="#" class="social"><i class='bx bxl-discord-alt'></i></a>
                <a href="#" class="social"><i class='bx bxl-tiktok'></i></a>
            </div>
            <p>or use your account</p>
            <input type="text" name="login_field" placeholder="Email hoặc tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <a href="forgot-password.php">Quên mật khẩu?</a>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-left">
                <h1>Chào mừng trở lại!</h1>
                <p>Để giữ kết nối với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
                <button id="signIn">Đăng nhập</button>
            </div>
            <div class="overlay-right">
                <h1>Xin chào bạn!</h1>
                <p>Nhập thông tin cá nhân và bắt đầu hành trình với chúng tôi</p>
                <button id="signUp">Đăng ký</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const main = document.getElementById('main');
    const alertMessage = document.getElementById('alert-message');

    // Toggle between sign up and sign in forms
    signUpButton.addEventListener('click', () => {
        main.classList.add('right-panel-active');
    });
    signInButton.addEventListener('click', () => {
        main.classList.remove('right-panel-active');
    });

    // Show alert message
    function showAlert(message, type = 'error') {
        alertMessage.textContent = message;
        alertMessage.className = `alert alert-${type}`;
        alertMessage.style.display = 'block';

        // Auto hide after 5 seconds
        setTimeout(() => {
            alertMessage.style.display = 'none';
        }, 5000);
    }

    // // Handle register form
    // document.getElementById('registerForm').addEventListener('submit', async function(e) {
    //     e.preventDefault();

    //     const formData = new FormData(this);

    //     try {
    //         const response = await fetch('{{ route("auth.register") }}', {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: formData
    //         });

    //         const result = await response.json();

    //         if (result.success) {
    //             showAlert(result.message, 'success');
    //             this.reset();
    //             setTimeout(() => {
    //                 main.classList.remove('right-panel-active');
    //             }, 2000);
    //         } else if (result.errors) {
    //             // Hiển thị lỗi validate
    //             let msg = '';
    //             for (const key in result.errors) {
    //                 msg += result.errors[key][0] + '<br>';
    //             }
    //             showAlert(msg, 'error');
    //         } else {
    //             showAlert(result.message || 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
    //         }
    //     } catch (error) {
    //         showAlert('Có lỗi xảy ra, vui lòng thử lại!', 'error');
    //         console.error('Error:', error);
    //     }
    // });

    // // Handle login form
    // document.getElementById('loginForm').addEventListener('submit', async function(e) {
    //     e.preventDefault();

    //     const formData = new FormData(this);

    //     try {
    //         const response = await fetch('{{ route("auth.login") }}', {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: formData
    //         });

    //         const result = await response.json();

    //         if (result.success) {
    //             showAlert(result.message, 'success');
    //             setTimeout(() => {
    //                 if (result.user && result.user.role === 'admin') {
    //                     window.location.href = '{{ url("admin/index") }}';
    //                 } else {
    //                     window.location.href = '{{ url("/") }}';
    //                 }
    //             }, 1500);
    //         } else if (result.errors) {
    //             let msg = '';
    //             for (const key in result.errors) {
    //                 msg += result.errors[key][0] + '<br>';
    //             }
    //             showAlert(msg, 'error');
    //         } else {
    //             showAlert(result.message || 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
    //         }
    //     } catch (error) {
    //         showAlert('Có lỗi xảy ra, vui lòng thử lại!', 'error');
    //         console.error('Error:', error);
    //     }
    // });
</script>