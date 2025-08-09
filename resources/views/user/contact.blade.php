@extends('user.layout')
@section('title', 'Liên Hệ')

@section('content')
<div class="contact-wrapper">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="hero-content">
            <h1 class="hero-title">Liên Hệ Với Chúng Tôi</h1>
            <p class="hero-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
        </div>
        <div class="hero-particles"></div>
    </div>

    <div class="contact-container">
        @if(session('success'))
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="contact-grid">
            <!-- Contact Information -->
            <div class="contact-info-card">
                <div class="info-header">
                    <h3>Thông Tin Liên Hệ</h3>
                    <p>Hãy liên hệ với chúng tôi qua các kênh dưới đây</p>
                </div>

                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>Địa chỉ</h5>
                            <p>Nguyễn Huệ, Phường 1, TP. Cao Lãnh, Đồng Tháp</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h5>Email</h5>
                            <p>info@jewelryshop.vn</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h5>Hotline</h5>
                            <p>1900 123 456</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h5>Giờ làm việc</h5>
                            <p>Thứ 2 - Chủ nhật: 8:00 - 22:00</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-section">
                    <h5>Theo dõi chúng tôi</h5>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-card">
                <div class="form-header">
                    <h3>Gửi Tin Nhắn</h3>
                    <p>Điền thông tin và chúng tôi sẽ phản hồi trong 24h</p>
                </div>

                <form method="POST" action="{{ route('contact.submit') }}" class="contact-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Họ và tên
                        </label>
                        <input type="text" class="form-input" id="name" name="name"
                               placeholder="Nhập họ tên của bạn" value="{{ old('name') }}">
                        @error('name') 
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email" class="form-input" id="email" name="email"
                               placeholder="Nhập địa chỉ email" value="{{ old('email') }}">
                        @error('email') 
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone"></i>
                            Số điện thoại
                        </label>
                        <input type="tel" class="form-input" id="phone" name="phone"
                               placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">
                            <i class="fas fa-tag"></i>
                            Chủ đề
                        </label>
                        <select class="form-input" id="subject" name="subject">
                            <option value="">Chọn chủ đề</option>
                            <option value="product">Sản phẩm</option>
                            <option value="order">Đơn hàng</option>
                            <option value="service">Dịch vụ</option>
                            <option value="complaint">Khiếu nại</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">
                            <i class="fas fa-comment"></i>
                            Nội dung
                        </label>
                        <textarea class="form-input" id="message" name="message" rows="5"
                                  placeholder="Nhập nội dung tin nhắn...">{{ old('message') }}</textarea>
                        @error('message') 
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Gửi tin nhắn</span>
                        <div class="btn-ripple"></div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="map-header">
                <h3>Vị Trí Cửa Hàng</h3>
                <p>Ghé thăm showroom của chúng tôi để trải nghiệm trực tiếp</p>
            </div>
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.7246901746856!2d105.63400637506334!3d10.46071178966474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0ef2072363df3%3A0xc25b7a22e4e0a5cb!2zTmd1eeG7hW4gSMawbSwgUC4gMSwgQ2FvIEzhuqFuaCwgxJDhu5FuZyBUaMOhcA!5e0!3m2!1svi!2s!4v1720514600000!5m2!1svi!2s"
                    allowfullscreen
                    loading="lazy">
                </iframe>
                <div class="map-overlay">
                    <div class="location-pin">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Galaxy Blue Theme Variables */
:root {
    --galaxy-primary: #1a237e;
    --galaxy-secondary: #3949ab;
    --galaxy-accent: #5c6bc0;
    --galaxy-light: #9fa8da;
    --galaxy-gradient: linear-gradient(135deg, #1a237e 0%, #3949ab 50%, #5c6bc0 100%);
    --galaxy-radial: radial-gradient(circle at center, #3949ab 0%, #1a237e 100%);
    --text-primary: #222222;          /* đổi chữ trắng thành xám đậm cho phù hợp nền sáng hơn */
    --text-secondary: #455a64;
    --text-muted: #78909c;
    --background: #f0f4f8;           /* nền sáng hơn, xanh nhạt */
    --surface: rgba(90, 110, 200, 0.1); /* nền surface vẫn giữ màu xanh nhẹ nhưng sáng hơn */
    --glass-bg: rgba(255, 255, 255, 0.15); /* tăng độ sáng của nền kính */
    --glass-border: rgba(0, 0, 0, 0.1);     /* đổi sang viền tối nhẹ phù hợp nền sáng */
    --shadow: 0 8px 32px rgba(26, 35, 126, 0.1);  /* giảm shadow để nhẹ nhàng hơn */
    --shadow-hover: 0 12px 48px rgba(26, 35, 126, 0.15);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --success: #4caf50;
    --error: #f44336;
}


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--background);
    color: var(--text-primary);
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    font-size: 18px; /* tăng font size lên 18px */
}

.contact-wrapper {
    min-height: 100vh;
    background: var(--background);
}
/* Hero Section */
.contact-hero {
    position: relative;
    background: var(--galaxy-gradient);
    padding: 4rem 0 6rem;
    text-align: center;
    overflow: hidden;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Giảm kích thước chữ */
.hero-title {
    font-size: 3rem; /* trước 3.5rem */
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, #ffffff, #e8eaf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.1rem; /* trước 1.2rem */
    color: #ffffff;    /* đổi từ xám sang trắng */
    opacity: 0.9;
}

.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
        radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
        radial-gradient(circle at 60% 80%, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Container */
.contact-container {
    max-width: 1400px;
    margin: -3rem auto 0;
    padding: 0 2rem 4rem;
    position: relative;
    z-index: 3;
}

/* Success Alert */
.success-alert {
    background: rgba(76, 175, 80, 0.1);
    border: 1px solid rgba(76, 175, 80, 0.3);
    color: var(--success);
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
}

.success-alert i {
    font-size: 1.2rem;
}

/* Contact Grid */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 4rem;
}

/* Card Styles */
.contact-info-card,
.contact-form-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
      font-size: 1.125rem; 
}

.contact-info-card:hover,
.contact-form-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    border-color: var(--galaxy-accent);
}

.contact-info-card::before,
.contact-form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--galaxy-gradient);
}

/* Info Header */
.info-header,
.form-header {
    margin-bottom: 2rem;
}

.info-header h3,
.form-header h3 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.info-header p,
.form-header p {
    color: var(--text-secondary);
    font-size: 1rem;
}

/* Info List */
.info-list {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 12px;
    transition: var(--transition);
}

.info-item:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
}

.info-icon {
    width: 50px;
    height: 50px;
    background: var(--galaxy-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.info-content h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.info-content p {
    color: var(--text-secondary);
    margin: 0;
}

/* Social Section */
.social-section {
    border-top: 1px solid var(--glass-border);
    padding-top: 1.5rem;
}

.social-section h5 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 600;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 45px;
    height: 45px;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    text-decoration: none;
    transition: var(--transition);
}

.social-link:hover {
    background: var(--galaxy-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

/* Form Styles */
.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    position: relative;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-size: 0.95rem;
}

.form-label i {
    color: var(--galaxy-accent);
    width: 16px;
}

.form-input {
    width: 100%;
    padding: 1rem 1.25rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.form-input:focus {
    outline: none;
    border-color: var(--galaxy-accent);
    box-shadow: 0 0 0 3px rgba(92, 107, 192, 0.2);
    background: rgba(255, 255, 255, 0.08);
}

.form-input::placeholder {
    color: var(--text-muted);
}

textarea.form-input {
    resize: vertical;
    min-height: 120px;
}

select.form-input {
    cursor: pointer;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--error);
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

/* Submit Button */
.submit-btn {
    position: relative;
    background: var(--galaxy-gradient);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    overflow: hidden;
    margin-top: 1rem;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.submit-btn:active {
    transform: translateY(0);
}

.btn-ripple {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    transform: scale(0);
    opacity: 0;
    transition: transform 0.6s, opacity 0.6s;
}

.submit-btn:active .btn-ripple {
    transform: scale(2);
    opacity: 1;
    transition: transform 0s, opacity 0s;
}

/* Map Section */
.map-section {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
}

.map-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--galaxy-gradient);
}

.map-header {
    text-align: center;
    margin-bottom: 2rem;
}

.map-header h3 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.map-header p {
    color: var(--text-secondary);
}

.map-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    height: 400px;
    box-shadow: var(--shadow);
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
    filter: grayscale(20%) contrast(1.1);
}

.map-overlay {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--galaxy-gradient);
    padding: 0.5rem;
    border-radius: 50%;
    box-shadow: var(--shadow);
}

.location-pin {
    color: white;
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .contact-container {
        padding: 0 1rem 3rem;
    }
}

@media (max-width: 768px) {
    .contact-info-card,
    .contact-form-card,
    .map-section {
        padding: 1.5rem;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .contact-hero {
        padding: 3rem 0 4rem;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .map-container {
        height: 300px;
    }
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.contact-info-card,
.contact-form-card,
.map-section {
    animation: slideInUp 0.6s ease-out;
}

.contact-form-card {
    animation-delay: 0.2s;
}

.map-section {
    animation-delay: 0.4s;
}

/* Focus states for accessibility */
.form-input:focus,
.submit-btn:focus,
.social-link:focus {
    outline: 2px solid var(--galaxy-accent);
    outline-offset: 2px;
}
</style>
@endsection