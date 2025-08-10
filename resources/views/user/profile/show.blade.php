@extends('user.layout')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="profile-container">
    <!-- Cover Background -->
    <div class="profile-cover">
        <div class="cover-pattern"></div>
        <div class="profile-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <div class="avatar-wrapper">
                            @if($user->avatar)
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($user->avatar) }}" alt="Avatar"
                                class="profile-avatar">
                            @else
                            <div class="default-avatar">
                                <i class="fas fa-gem"></i>
                            </div>
                            @endif
                            <div class="avatar-status"></div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- User Info -->
                        <div class="user-info">
                            <div>
                                <h2 class="user-name">{{ $user->fullname ?: $user->username }}</h2>
                                <p class="user-username">{{ $user->username }}</p>
                            </div>
                            <div class="user-stats">
                                <div class="stat-item">
                                    <span class="stat-number">{{ rand(10, 99) }}</span>
                                    <span class="stat-label">Đơn hàng</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ rand(5, 25) }}</span>
                                    <span class="stat-label">Yêu thích</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ rand(100, 999) }}</span>
                                    <span class="stat-label">Điểm thưởng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Action Buttons -->
                        <div class="profile-actions">
                            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn-action">
                                <i class="fas fa-edit"></i>
                                <span>Chỉnh sửa</span>
                            </a>
                            <button class="btn btn-outline btn-action">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row g-4">
                <!-- Profile Details Card -->
                <div class="col-lg-7 col-md-6">
                    <div class="info-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-user-circle"></i>
                                Thông tin cá nhân
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </div>
                                    <div class="info-value">{{ $user->email }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i>
                                        Số điện thoại
                                    </div>
                                    <div class="info-value">{{ $user->phone_number ?: 'Chưa cập nhật' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-birthday-cake"></i>
                                        Ngày sinh
                                    </div>
                                    <div class="info-value">
                                        {{ $user->date_of_birth ? date('d/m/Y', strtotime($user->date_of_birth)) : 'Chưa cập nhật' }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Địa chỉ
                                    </div>
                                    <div class="info-value">{{ $user->address ?: 'Chưa cập nhật' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-crown"></i>
                                        Vai trò
                                    </div>
                                    <div class="info-value">
                                        <span class="role-badge role-{{ strtolower($user->role) }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Sidebar -->
                <div class="col-lg-5 col-md-6">
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h6 class="card-title">
                                <i class="fas fa-bolt"></i>
                                Thao tác nhanh
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="#" class="quick-action-item">
                                    <div class="action-icon bg-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-title">Đơn hàng</span>
                                        <small class="action-desc">Xem lịch sử mua hàng</small>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>

                                <a href="#" class="quick-action-item">
                                    <div class="action-icon bg-danger">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-title">Yêu thích</span>
                                        <small class="action-desc">Sản phẩm đã lưu</small>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>

                                <a href="#" class="quick-action-item">
                                    <div class="action-icon bg-warning">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-title">Điểm thưởng</span>
                                        <small class="action-desc">Tích lũy & đổi quà</small>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>

                                <a href="#" class="quick-action-item">
                                    <div class="action-icon bg-info">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-title">Thông báo</span>
                                        <small class="action-desc">Cập nhật mới nhất</small>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Level Card - Full Width Bottom -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="member-card">
                        <div class="card-body">
                            <div class="member-level">
                                <div class="member-content">
                                    <i class="fas fa-gem member-icon"></i>
                                    <div class="member-info">
                                        <h6 class="member-title">Khách hàng VIP</h6>
                                        <p class="member-desc">Tận hưởng ưu đãi đặc biệt dành riêng cho bạn</p>
                                    </div>
                                </div>
                                <div class="member-progress">
                                    <div class="progress-wrapper">
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 75%"></div>
                                        </div>
                                        <small class="progress-text">Còn 2.5M để lên hạng Diamond 💎</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* =================== MODERN PROFILE CSS - GALAXY BLUE THEME =================== */

    :root {
        --galaxy-blue: #1a365d;
        --galaxy-blue-light: #2d5aa0;
        --galaxy-blue-dark: #0f1724;
        --galaxy-accent: #4299e1;
        --galaxy-gradient: linear-gradient(135deg, #1a365d 0%, #2d5aa0 100%);
        --galaxy-soft: linear-gradient(135deg, #e6f3ff 0%, #f0f8ff 100%);
        --white: #ffffff;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #a0aec0;
        --gray-500: #718096;
        --gray-600: #4a5568;
        --gray-700: #2d3748;
        --gray-800: #1a202c;
        --gray-900: #171923;
        --shadow-sm: 0 1px 2px 0 rgba(26, 54, 93, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(26, 54, 93, 0.1), 0 2px 4px -2px rgba(26, 54, 93, 0.05);
        --shadow-lg: 0 10px 15px -3px rgba(26, 54, 93, 0.1), 0 4px 6px -4px rgba(26, 54, 93, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(26, 54, 93, 0.1), 0 8px 10px -6px rgba(26, 54, 93, 0.05);
    }

    /* =================== GLOBAL STYLES =================== */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: var(--gray-700);
        line-height: 1.6;
        min-height: 100vh;
    }

    /* =================== PROFILE CONTAINER =================== */
    .profile-container {
        min-height: 100vh;
        position: relative;
    }

    /* =================== COVER SECTION =================== */
    .profile-cover {
        position: relative;
        height: 320px;
        background: var(--galaxy-gradient);
        overflow: hidden;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
            linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.05) 50%, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }

        33% {
            transform: translateY(-8px) rotate(1deg);
            opacity: 0.9;
        }

        66% {
            transform: translateY(5px) rotate(-1deg);
            opacity: 0.8;
        }
    }

    .cover-overlay {
        display: none;
    }

    .profile-header {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .profile-header .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
        width: 100%;
    }

    .profile-header .row {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: nowrap;
        width: 100%;
    }

    .profile-header .col-auto {
        flex: 0 0 auto;
    }

    .profile-header .col {
        flex: 1;
        min-width: 0;
    }

    .profile-header .col-auto:last-child {
        flex: 0 0 auto;
        margin-left: auto;
    }

    /* =================== AVATAR STYLES =================== */
    .avatar-wrapper {
        position: relative;
    }

    .profile-avatar,
    .default-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-xl);
        transition: all 0.3s ease;
    }

    .profile-avatar {
        object-fit: cover;
        display: block;
    }

    .profile-avatar:hover,
    .default-avatar:hover {
        transform: scale(1.05);
        border-color: rgba(255, 255, 255, 0.6);
        box-shadow: 0 25px 35px -5px rgba(26, 54, 93, 0.2);
    }

    .default-avatar {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .avatar-status {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: var(--shadow-md);
        animation: pulse-status 2s ease-in-out infinite;
    }

    @keyframes pulse-status {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* =================== USER INFO =================== */
    .user-info {
        color: white;
    }

    .user-name {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .user-username {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .user-stats {
        display: flex;
        gap: 2.5rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .stat-item:hover {
        transform: translateY(-3px) scale(1.05);
        background: rgba(255, 255, 255, 0.15);
    }

    .stat-number {
        display: block;
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-top: 0.25rem;
    }

    /* =================== ACTION BUTTONS =================== */
    .profile-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.75rem;
        border-radius: 16px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .btn-action:hover::before {
        left: 100%;
    }

    .btn-primary.btn-action {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: var(--shadow-lg);
    }

    .btn-primary.btn-action:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px -5px rgba(26, 54, 93, 0.3);
        color: white;
        text-decoration: none;
        border-color: rgba(255, 255, 255, 0.5);
    }

    .btn-outline.btn-action {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.875rem;
        width: 52px;
        height: 52px;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .btn-outline.btn-action:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-3px);
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* =================== MAIN CONTENT =================== */
    .profile-content {
        margin-top: -80px;
        position: relative;
        z-index: 3;
        padding-bottom: 3rem;
    }

    .profile-content .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .profile-content .row {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }

    .profile-content .g-4 {
        gap: 1.5rem;
    }

    .profile-content .col-lg-7,
    .profile-content .col-md-6:first-child {
        flex: 1;
    }

    .profile-content .col-lg-5,
    .profile-content .col-md-6:last-child {
        flex: 0 0 400px;
    }

    /* =================== CARDS =================== */
    .info-card,
    .sidebar-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--gray-100);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .info-card::before,
    .sidebar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--galaxy-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .info-card:hover,
    .sidebar-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .info-card:hover::before,
    .sidebar-card:hover::before {
        opacity: 1;
    }

    .card-header {
        padding: 1.75rem;
        border-bottom: 1px solid var(--gray-100);
        background: linear-gradient(135deg, var(--galaxy-soft) 0%, var(--white) 100%);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--galaxy-blue);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .card-title i {
        color: var(--galaxy-accent);
        font-size: 1.1rem;
        padding: 0.5rem;
        background: rgba(66, 153, 225, 0.1);
        border-radius: 8px;
    }

    .card-body {
        padding: 1.75rem;
    }

    /* =================== INFO GRID =================== */
    .info-grid {
        display: grid;
        gap: 1.25rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-100);
    }

    .info-item:hover {
        background: linear-gradient(135deg, var(--galaxy-soft) 0%, var(--white) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--galaxy-accent);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        color: var(--gray-700);
        flex: 1;
    }

    .info-label i {
        color: var(--galaxy-blue);
        width: 18px;
        font-size: 1.1rem;
        padding: 0.375rem;
        background: rgba(26, 54, 93, 0.1);
        border-radius: 6px;
    }

    .info-value {
        font-weight: 600;
        color: var(--galaxy-blue);
        text-align: right;
        flex: 1;
    }

    /* =================== ROLE BADGE =================== */
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid transparent;
    }

    .role-user {
        background: linear-gradient(135deg, #e6f3ff 0%, #cce7ff 100%);
        color: var(--galaxy-blue);
        border-color: rgba(26, 54, 93, 0.2);
    }

    .role-admin {
        background: linear-gradient(135deg, #fff3cd 0%, #ffecb3 100%);
        color: #b8860b;
        border-color: rgba(184, 134, 11, 0.2);
    }

    /* =================== QUICK ACTIONS =================== */
    .quick-actions {
        display: grid;
        gap: 1rem;
    }

    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        border-radius: 16px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-100);
        position: relative;
        overflow: hidden;
    }

    .quick-action-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(26, 54, 93, 0.05), transparent);
        transition: left 0.5s;
    }

    .quick-action-item:hover::before {
        left: 100%;
    }

    .quick-action-item:hover {
        background: linear-gradient(135deg, var(--galaxy-soft) 0%, var(--white) 100%);
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
        color: inherit;
        border-color: var(--galaxy-accent);
    }

    .action-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
        box-shadow: var(--shadow-md);
        transition: transform 0.3s ease;
    }

    .action-icon.bg-primary {
        background: var(--galaxy-gradient);
    }

    .action-icon.bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .action-icon.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .action-icon.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .quick-action-item:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .action-content {
        flex: 1;
    }

    .action-title {
        display: block;
        font-weight: 700;
        color: var(--galaxy-blue);
        margin-bottom: 0.25rem;
        font-size: 1.05rem;
    }

    .action-desc {
        color: var(--gray-600);
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* =================== MEMBER LEVEL =================== */
    .member-level {
        padding: 2.5rem;
        text-align: center;
        background: var(--galaxy-gradient);
        color: white;
        border-radius: 20px;
        margin: 1rem;
        position: relative;
        overflow: hidden;
    }

    .member-level::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background:
            radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .member-icon {
        font-size: 3.5rem;
        margin-bottom: 1.25rem;
        color: #fbbf24;
        animation: pulse 2.5s ease-in-out infinite;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1) rotate(0deg);
        }

        50% {
            transform: scale(1.1) rotate(5deg);
        }
    }

    .member-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .member-desc {
        opacity: 0.9;
        margin-bottom: 1.75rem;
        font-size: 1.05rem;
        position: relative;
        z-index: 2;
    }

    .member-progress {
        max-width: 320px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .progress {
        width: 100%;
        height: 12px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 0.75rem;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        border-radius: 6px;
        transition: width 0.6s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-bar::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% {
            left: -100%;
        }

        100% {
            left: 100%;
        }
    }

    .progress-text {
        font-size: 0.9rem;
        opacity: 0.95;
        font-weight: 600;
    }

    /* =================== ALERTS =================== */
    .alert {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.75rem;
        margin-bottom: 1.5rem;
        border-radius: 16px;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
        opacity: 0.3;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-color: #86efac;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
    }

    .btn-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        padding: 0.25rem;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }

    /* =================== FULL WIDTH MEMBER CARD =================== */
    .profile-content .row.mt-4 {
        margin-top: 2rem;
    }

    .profile-content .row.mt-4 .col-12 {
        flex: 1;
    }

    /* =================== RESPONSIVE DESIGN =================== */
    @media (max-width: 992px) {

        .profile-content .col-lg-7,
        .profile-content .col-lg-5 {
            flex: 1;
        }

        .profile-content .row {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .profile-header .row {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .profile-header .col-auto:last-child {
            margin-left: 0;
        }

        .user-stats {
            justify-content: center;
            gap: 1.5rem;
        }

        .profile-actions {
            justify-content: center;
            gap: 0.75rem;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .info-value {
            text-align: left;
        }

        .profile-cover {
            height: 280px;
        }

        .user-name {
            font-size: 1.8rem;
        }

        .profile-content {
            margin-top: -60px;
        }

        .btn-action {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {

        .profile-avatar,
        .default-avatar {
            width: 100px;
            height: 100px;
        }

        .user-stats {
            gap: 1rem;
        }

        .stat-number {
            font-size: 1.4rem;
        }

        .member-level {
            margin: 0.5rem;
            padding: 2rem;
        }

        .member-icon {
            font-size: 3rem;
        }

        .card-header,
        .card-body {
            padding: 1.25rem;
        }

        .info-item,
        .quick-action-item {
            padding: 1rem;
        }
    }

    /* =================== UTILITIES =================== */
    .g-4>* {
        margin-bottom: 1.5rem;
    }

    .align-items-center {
        align-items: center;
    }

    .text-center {
        text-align: center;
    }

    /* =================== ADDITIONAL BOOTSTRAP COMPATIBILITY =================== */
    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -0.75rem;
    }

    .col,
    .col-auto,
    .col-lg-5,
    .col-lg-7,
    .col-md-6,
    .col-12 {
        padding: 0 0.75rem;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    /* =================== ENHANCED ANIMATIONS =================== */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .info-card,
    .sidebar-card {
        animation: slideInUp 0.6s ease-out;
    }

    .info-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .sidebar-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    /* =================== SCROLL BEHAVIOR =================== */
    html {
        scroll-behavior: smooth;
    }

    /* =================== CUSTOM SCROLLBAR =================== */
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
        transition: background 0.2s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--galaxy-blue);
    }
</style>
@endsection