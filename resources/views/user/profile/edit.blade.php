@extends('user.layout')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Section -->
            <div class="text-center mb-4">
                <div class="galaxy-icon mb-3">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h2 class="galaxy-title">Chỉnh sửa thông tin cá nhân</h2>
                <p class="text-muted">Cập nhật thông tin của bạn để có trải nghiệm tốt hơn</p>
            </div>

            <div class="modern-card">
                <div class="card-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger modern-alert">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <h6 class="alert-title">Có lỗi xảy ra:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Section -->
                        <div class="avatar-section mb-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="avatar-container">
                                        <div class="avatar-wrapper">
                                            @if($user->avatar)
                                            <img id="avatar-preview" src="{{ \App\Helpers\ImageHelper::getImageUrl($user->avatar) }}"
                                                alt="Avatar" class="avatar-image">
                                            @else
                                            <div id="avatar-preview" class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            @endif
                                            <div class="avatar-overlay">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </div>
                                        <div class="avatar-upload mt-3">
                                            <label for="avatar" class="upload-btn">
                                                <i class="fas fa-upload me-2"></i>
                                                Thay đổi ảnh
                                            </label>
                                            <input type="file" class="d-none" id="avatar" name="avatar"
                                                accept="image/*" onchange="previewAvatar(this)">
                                            <small class="upload-hint">JPG, PNG, GIF (Tối đa 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="info-section">
                                        <h5 class="section-title">Thông tin cơ bản</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tên đăng nhập <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="input-icon fas fa-user"></i>
                                                        <input type="text" class="form-control modern-input @error('username') is-invalid @enderror"
                                                            name="username" value="{{ old('username', $user->username) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Họ và tên <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="input-icon fas fa-id-card"></i>
                                                        <input type="text" class="form-control modern-input @error('fullname') is-invalid @enderror"
                                                            name="fullname" value="{{ old('fullname', $user->fullname) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="input-icon fas fa-envelope"></i>
                                                        <input type="email" class="form-control modern-input @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email', $user->email) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Số điện thoại <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="input-icon fas fa-phone"></i>
                                                        <input type="text" class="form-control modern-input @error('phone_number') is-invalid @enderror"
                                                            id="phone_number" name="phone_number"
                                                            value="{{ old('phone_number', $user->phone_number) }}" required
                                                            maxlength="10" pattern="[0-9]{10}">
                                                    </div>
                                                    <small class="form-hint">Nhập đúng 10 số, không quá 5 số trùng nhau</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Ngày sinh</label>
                                                    <div class="input-wrapper">
                                                        <i class="input-icon fas fa-calendar"></i>
                                                        <input type="date" class="form-control modern-input @error('date_of_birth') is-invalid @enderror"
                                                            name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="section-divider"></div>
                        <div class="address-section mb-5">
                            <h5 class="section-title">Địa chỉ liên hệ</h5>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <i class="input-icon fas fa-map-marker-alt"></i>
                                    <textarea class="form-control modern-textarea @error('address') is-invalid @enderror"
                                        name="address" rows="4" maxlength="500"
                                        placeholder="Nhập địa chỉ của bạn...">{{ old('address', $user->address) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="section-divider"></div>
                        <div class="password-section">
                            <h5 class="section-title">
                                <i class="fas fa-shield-alt me-2"></i>
                                Đổi mật khẩu
                                <span class="optional-badge">Tùy chọn</span>
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon fas fa-lock"></i>
                                            <input type="password" class="form-control modern-input @error('current_password') is-invalid @enderror"
                                                id="current_password" name="current_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon fas fa-key"></i>
                                            <input type="password" class="form-control modern-input @error('new_password') is-invalid @enderror"
                                                id="new_password" name="new_password" minlength="8">
                                        </div>
                                        <small class="form-hint">Tối thiểu 8 ký tự</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Xác nhận mật khẩu</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon fas fa-check-circle"></i>
                                            <input type="password" class="form-control modern-input"
                                                id="new_password_confirmation" name="new_password_confirmation" minlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-section mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-secondary-modern">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary-modern">
                                    <i class="fas fa-save me-2"></i>
                                    Lưu thay đổi
                                    <div class="btn-shine"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.id = 'avatar-preview';
                    img.src = e.target.result;
                    img.className = 'avatar-image';
                    img.alt = 'Avatar Preview';
                    preview.parentNode.replaceChild(img, preview);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Phone number validation
    document.getElementById('phone_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value.length > 10) {
            value = value.slice(0, 10);
        }

        if (value.length === 10) {
            const digits = value.split('');
            const digitCounts = {};
            digits.forEach(digit => {
                digitCounts[digit] = (digitCounts[digit] || 0) + 1;
            });

            const maxCount = Math.max(...Object.values(digitCounts));
            if (maxCount > 5) {
                e.target.setCustomValidity('Số điện thoại không được có quá 5 chữ số giống nhau');
            } else {
                e.target.setCustomValidity('');
            }
        } else if (value.length > 0) {
            e.target.setCustomValidity('Số điện thoại phải đủ 10 số');
        } else {
            e.target.setCustomValidity('');
        }

        e.target.value = value;
    });

    // Password confirmation validation
    document.getElementById('new_password_confirmation').addEventListener('input', function(e) {
        const newPassword = document.getElementById('new_password').value;
        if (e.target.value !== newPassword && e.target.value !== '') {
            e.target.setCustomValidity('Mật khẩu xác nhận không khớp');
        } else {
            e.target.setCustomValidity('');
        }
    });

    document.getElementById('new_password').addEventListener('input', function(e) {
        const confirmPassword = document.getElementById('new_password_confirmation');
        if (confirmPassword.value !== '' && confirmPassword.value !== e.target.value) {
            confirmPassword.setCustomValidity('Mật khẩu xác nhận không khớp');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
</script>

<style>
    :root {
        --galaxy-blue: #1a365d;
        --galaxy-blue-light: #2d5aa0;
        --galaxy-blue-dark: #0f1724;
        --galaxy-accent: #4299e1;
        --galaxy-gradient: linear-gradient(135deg, #1a365d 0%, #2d5aa0 100%);
        --white: #ffffff;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e0;
        --gray-400: #a0aec0;
        --gray-500: #718096;
        --gray-600: #4a5568;
        --shadow-sm: 0 1px 2px 0 rgba(26, 54, 93, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(26, 54, 93, 0.1), 0 2px 4px -1px rgba(26, 54, 93, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(26, 54, 93, 0.1), 0 4px 6px -2px rgba(26, 54, 93, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(26, 54, 93, 0.1), 0 10px 10px -5px rgba(26, 54, 93, 0.04);
    }

    body {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        color: var(--gray-600);
        line-height: 1.6;
    }

    /* Header Styles */
    .galaxy-icon {
        width: 80px;
        height: 80px;
        background: var(--galaxy-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .galaxy-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .galaxy-icon:hover::before {
        left: 100%;
    }

    .galaxy-icon i {
        color: white;
        font-size: 2rem;
        z-index: 2;
    }

    .galaxy-title {
        background: var(--galaxy-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: var(--galaxy-blue);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Modern Card */
    .modern-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--gray-100);
        position: relative;
        overflow: hidden;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--galaxy-gradient);
    }

    /* Alert Styles */
    .modern-alert {
        background: rgba(239, 68, 68, 0.05);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .alert-icon i {
        color: #dc2626;
        font-size: 1.1rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        color: #dc2626;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Avatar Section */
    .avatar-section {
        background: var(--gray-50);
        border-radius: 20px;
        padding: 2rem;
    }

    .avatar-container {
        text-align: center;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .avatar-image,
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .avatar-placeholder {
        background: var(--galaxy-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(26, 54, 93, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-overlay i {
        color: white;
        font-size: 1.5rem;
    }

    .upload-btn {
        background: var(--galaxy-gradient);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .upload-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .upload-btn:hover::before {
        left: 100%;
    }

    .upload-hint {
        display: block;
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Form Sections */
    .info-section,
    .address-section,
    .password-section {
        margin-bottom: 2rem;
    }

    .section-title {
        color: var(--galaxy-blue);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gray-200), transparent);
        margin: 2rem 0;
    }

    .optional-badge {
        background: var(--gray-100);
        color: var(--gray-500);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        color: var(--gray-700);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .required {
        color: #dc2626;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--galaxy-blue);
        font-size: 1rem;
        z-index: 2;
    }

    .modern-input,
    .modern-textarea {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        background: var(--white);
        color: var(--gray-700);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .modern-input:focus,
    .modern-textarea:focus {
        outline: none;
        border-color: var(--galaxy-accent);
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        transform: translateY(-1px);
    }

    .modern-input:hover,
    .modern-textarea:hover {
        border-color: var(--galaxy-blue-light);
    }

    .modern-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-hint {
        color: var(--gray-500);
        font-size: 0.8rem;
        margin-top: 0.5rem;
        display: block;
    }

    .is-invalid {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
    }

    /* Buttons */
    .btn-primary-modern {
        background: var(--galaxy-gradient);
        color: white;
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .btn-secondary-modern {
        background: var(--gray-100);
        color: var(--gray-600);
        padding: 0.875rem 2rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-secondary-modern:hover {
        background: var(--gray-200);
        border-color: var(--gray-300);
        color: var(--gray-700);
        transform: translateY(-1px);
    }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary-modern:hover .btn-shine {
        left: 100%;
    }

    /* Action Section */
    .action-section {
        padding-top: 2rem;
        border-top: 1px solid var(--gray-100);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .modern-card .card-body {
            padding: 1.5rem;
        }

        .avatar-section {
            padding: 1.5rem;
        }

        .galaxy-icon {
            width: 60px;
            height: 60px;
        }

        .galaxy-icon i {
            font-size: 1.5rem;
        }

        .avatar-image,
        .avatar-placeholder {
            width: 100px;
            height: 100px;
        }

        .action-section .d-flex {
            flex-direction: column-reverse;
            gap: 1rem;
        }

        .btn-primary-modern,
        .btn-secondary-modern {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--galaxy-blue-light);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--galaxy-blue);
    }
</style>
@endsection