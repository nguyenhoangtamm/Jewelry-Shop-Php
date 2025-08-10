@extends('user.layout')
@section('title', 'Trang chủ')
@section('content')


</style>
<script src="https://cdn.tailwindcss.com">
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">


<style>
    @import url("https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap");
</style>
<style>
    body {
        font-family: "Times New Roman", serif;
    }

    .title-font {
        font-family: "Playfair Display", serif;
    }

    @keyframes bounce-custom {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes sparkle {

        0%,
        100% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .bounce-smooth {
        animation: bounce-custom 1.2s infinite;
    }

    .category-img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 16px;
        padding: 8px;
        border: 2px solid #1e40af;
        box-shadow: 0 8px 25px rgba(30, 64, 175, 0.15);
        transition: all 0.3s ease;
    }

    .category-img:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(30, 64, 175, 0.25);
        border-color: #3b82f6;
    }

    /* Galaxy Blue Color Scheme */
    :root {
        --galaxy-blue: #1e40af;
        --galaxy-blue-light: #3b82f6;
        --galaxy-blue-dark: #1e3a8a;
        --galaxy-accent: #6366f1;
        --galaxy-gold: #fbbf24;
        --galaxy-silver: #e5e7eb;
    }






    .side-circle.left {
        left: -1.25rem;
    }

    .side-circle.right {
        right: -1.25rem;
    }

    .card:hover .side-circle {
        box-shadow: 0 12px 35px rgba(30, 64, 175, 0.5);
        transform: translateY(-50%) scale(1.1);
    }

    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #ffffff;
    }

    /* Galaxy gradient backgrounds */
    .galaxy-gradient {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
        background-size: 200% 200%;
        animation: gradientShift 8s ease infinite;
    }

    .galaxy-gradient-light {
        background: linear-gradient(135deg, #dbeafe 0%, #f0f9ff 50%, #fef7ff 100%);
    }

    /* Enhanced sparkle effect */
    .sparkle::before {
        content: '✨';
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.2rem;
        animation: sparkle 2s infinite;
    }

    /* Modern card styling */
    .modern-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(30, 64, 175, 0.1);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(30, 64, 175, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(30, 64, 175, 0.15);
        border-color: rgba(30, 64, 175, 0.2);
    }

    /* Premium button styling */
    .btn-galaxy {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.25);
    }

    .btn-galaxy:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(30, 64, 175, 0.35);
        background: linear-gradient(135deg, var(--galaxy-blue-dark) 0%, var(--galaxy-blue) 100%);
    }

    /* Enhanced flash sale styling */
    .flash-sale-container {
        background: linear-gradient(135deg, #dbeafe 0%, #f0f9ff 50%, #fef7ff 100%);
        border: 2px solid rgba(30, 64, 175, 0.2);
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(30, 64, 175, 0.1);
    }

    .flash-sale-title {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Countdown styling */
    .countdown-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid var(--galaxy-blue);
        border-radius: 12px;
        padding: 8px 16px;
        color: var(--galaxy-blue);
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(30, 64, 175, 0.1);
        transition: all 0.3s ease;
    }

    .countdown-item:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 25px rgba(30, 64, 175, 0.2);
    }

    /* Voucher redesign */
    .voucher-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid var(--galaxy-blue);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
    }

    .voucher-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--galaxy-blue) 0%, var(--galaxy-accent) 100%);
    }

    .voucher-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(30, 64, 175, 0.2);
    }

    .voucher-amount {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .voucher-footer {
        background: linear-gradient(135deg, #dbeafe 0%, #f0f9ff 100%);
    }

    /* Enhanced contact box */
    .contact-box {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(30, 64, 175, 0.2);
        box-shadow: 0 15px 50px rgba(30, 64, 175, 0.15);
    }

    .contact-header {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
    }

    /* Product card enhancements */
    .product-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(30, 64, 175, 0.1);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(30, 64, 175, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(30, 64, 175, 0.15);
        border-color: rgba(30, 64, 175, 0.3);
    }

    .product-badge {
        background: linear-gradient(135deg, var(--galaxy-gold) 0%, #f59e0b 100%);
        color: white;
        font-weight: 600;
    }

    .product-price {
        color: var(--galaxy-blue);
        font-weight: 800;
    }

    /* Notification popup styling */
    .notification-popup {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-dark) 100%);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(30, 64, 175, 0.3);
    }

    /* Enhanced category sections */
    .category-section {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 24px;
        border: 1px solid rgba(30, 64, 175, 0.1);
    }

    .category-link {
        transition: all 0.3s ease;
    }

    .category-link:hover {
        transform: translateY(-5px);
    }

    .category-link:hover .category-img {
        border-color: var(--galaxy-accent);
    }

    /* Suggestion box styling */
    .suggestion-box {
        background: linear-gradient(135deg, #dbeafe 0%, #f0f9ff 100%);
        color: var(--galaxy-blue);
        border: 2px solid rgba(30, 64, 175, 0.2);
        border-radius: 50px;
        box-shadow: 0 8px 30px rgba(30, 64, 175, 0.1);
    }
</style>

<!-- Banner -->
<section class="max-w-[1200px] mx-auto mt-6 px-4">
    <div class="relative flex overflow-x-auto scroll-smooth rounded-3xl shadow-2xl h-[300px] snap-x snap-mandatory border-4 border-galaxy-blue-light"
        id="bannerWrapper">
        <img src="https://cdn.pnj.io/images/promo/252/tabsale-t6-25-1972x640CTA.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
        <img src="https://cdn.pnj.io/images/promo/177/nhancuoi-t8-1200x450ec.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
        <img src="https://cdn.pnj.io/images/promo/259/thang-trang-suc-t7-25-1972x640KPN.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
    </div>
    <div id="dotWrapper" class="flex justify-center gap-3 mt-4">
        <span class="dot w-4 h-4 rounded-full bg-galaxy-blue opacity-60 transition-all duration-300"></span>
        <span class="dot w-4 h-4 rounded-full bg-galaxy-blue opacity-60 transition-all duration-300"></span>
        <span class="dot w-4 h-4 rounded-full bg-galaxy-blue opacity-60 transition-all duration-300"></span>
    </div>
</section>

<!-- Features Section -->
<div class="w-full bg-gradient-to-r from-blue-50 to-indigo-50 py-12 overflow-x-auto">
    <div class="max-w-[1200px] mx-auto px-4 flex flex-nowrap justify-center gap-x-12">
        <!-- Box 1 -->
        <div class="flex items-center gap-6 min-w-[280px] flex-shrink-0 modern-card p-6">
            <div class="w-20 h-20 rounded-full galaxy-gradient flex items-center justify-center">
                <img alt="Miễn phí vận chuyển" class="w-10 h-10 brightness-0 invert"
                    src="https://cdn-icons-png.flaticon.com/128/3901/3901488.png" />
            </div>
            <div>
                <p class="font-bold text-galaxy-blue text-lg">Miễn phí vận chuyển</p>
                <p class="text-gray-600 text-base">Đơn từ 399K</p>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="flex items-center gap-6 min-w-[280px] flex-shrink-0 modern-card p-6">
            <div class="w-20 h-20 rounded-full galaxy-gradient flex items-center justify-center">
                <img alt="Đổi hàng tận nhà" class="w-10 h-10 brightness-0 invert"
                    src="https://cdn-icons-png.flaticon.com/128/3749/3749977.png" />
            </div>
            <div>
                <p class="font-bold text-galaxy-blue text-lg">Đổi hàng tận nhà</p>
                <p class="text-gray-600 text-base">Trong vòng 15 ngày</p>
            </div>
        </div>

        <!-- Box 3 -->
        <div class="flex items-center gap-6 min-w-[280px] flex-shrink-0 modern-card p-6">
            <div class="w-20 h-20 rounded-full galaxy-gradient flex items-center justify-center">
                <img alt="Thanh toán COD" class="w-10 h-10 brightness-0 invert"
                    src="https://cdn-icons-png.flaticon.com/128/9165/9165704.png" />
            </div>
            <div>
                <p class="font-bold text-galaxy-blue text-lg">Thanh toán COD</p>
                <p class="text-gray-600 text-base">Yên tâm mua sắm</p>
            </div>
        </div>
    </div>
</div>

<body class="bg-white font-serif relative">
    <div class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row items-center justify-center gap-10 md:gap-20">
        <img alt="Three elegant jewelry necklaces with different colored gemstones on a gold background" class="rounded-lg w-full max-w-[400px] object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/79264c76-bb81-444a-87c1-9c27eeb8dbaf.jpg" width="400" />
        <div class="text-center max-w-xl">
            <div class="flex items-center justify-center gap-3 mb-3">
                <span class="text-gray-400 text-xs tracking-widest">
                    TVT JEWELRY
                </span>
                <div class="border-t border-black w-10 rotate-3">
                </div>
                <h2 class="text-3xl font-playfair text-[#6b4f2a] font-semibold leading-tight" style="font-family: 'Playfair Display', serif">
                    VỀ CHÚNG TÔI
                </h2>
                <img alt="Diamond ring icon" class="w-10 h-10 object-contain" height="40" src="https://storage.googleapis.com/a1aa/image/77a570ca-b21f-4f40-0dde-85922a713ab0.jpg" width="40" />
                <div class="border-t border-black w-10 -rotate-3">
                </div>
            </div>
            <p class="text-[#1a1a1a] text-base leading-relaxed mb-6">
                TVT Jewelry là thương hiệu trang sức độc đáo và sáng tạo, ra đời vào năm 2021. Với sự dẫn dắt của đội ngũ thiết kế tài năng, TVT Jewelry đã nhanh chóng trở thành tên tuổi nổi bật trong cộng đồng yêu trang sức.
            </p>
            <p class="text-[#1a1a1a] text-base leading-relaxed mb-8">
                Với triết lý "Trang sức không chỉ là vẻ đẹp bên ngoài, mà còn là một phần của phong cách sống", TVT Jewelry đang khẳng định vị thế của mình trong lĩnh vực trang sức cao cấp.
            </p>
            <button class="bg-[#c9a87a] text-white text-sm px-6 py-2 rounded-md cursor-not-allowed select-none" disabled="">
                Khám phá ngay
            </button>
        </div>
        <img alt="Close-up of a diamond ring with smaller diamonds around the main stone on a beige background" class="rounded-lg w-full max-w-[400px] object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/d2b6ab24-984a-4f0b-fc05-e95f2095d884.jpg" width="400" />
    </div>
    <button aria-label="Notification bell" class="fixed bottom-6 left-6 bg-[#c9a87a] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg">
        <i class="fas fa-bell fa-lg">
        </i>
    </button>

    <body class="bg-white min-h-screen">

        <!-- Enhanced Contact Button -->
        <button id="contactToggle"
            class="fixed bottom-6 right-6 w-14 h-14 rounded-full galaxy-gradient text-white text-2xl flex items-center justify-center shadow-2xl z-50 transition-all duration-300 hover:scale-110">
            <i class="fas fa-headset"></i>
        </button>

        <!-- Enhanced Contact Box -->
        <div id="contactBox"
            class="fixed bottom-24 right-6 w-[300px] font-sans rounded-2xl shadow-2xl contact-box opacity-0 pointer-events-none translate-x-full transition-all duration-300 z-50">
            <div class="rounded-t-2xl contact-header px-6 py-3 text-white text-sm flex items-center justify-between">
                <span class="font-semibold">Liên hệ với chúng tôi</span>
                <button id="closeContact" class="text-white text-lg hover:text-gray-300 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <!-- Hotline -->
                <a href="tel:19006750" class="flex items-center gap-3 hover:bg-blue-50 p-3 rounded-xl transition">
                    <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <p class="font-bold text-galaxy-blue">Hotline:</p>
                        <p class="text-gray-500 text-xs">19006750</p>
                    </div>
                </a>

                <!-- Zalo -->
                <a href="https://zalo.me/0123456789" target="_blank"
                    class="flex items-center gap-3 hover:bg-blue-50 p-3 rounded-xl transition">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <img class="w-6 h-6"
                            src="https://storage.googleapis.com/a1aa/image/daaa21d5-525d-44ec-d6b9-97f49b6b8ddb.jpg" />
                    </div>
                    <div>
                        <p class="font-bold text-galaxy-blue">Zalo chat:</p>
                        <p class="text-gray-500 text-xs">03981975690</p>
                    </div>
                </a>

                <!-- Messenger -->
                <a href="https://m.me/sapowebvietnam" target="_blank"
                    class="flex items-center gap-3 hover:bg-blue-50 p-3 rounded-xl transition">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                        <img class="w-6 h-6"
                            src="https://storage.googleapis.com/a1aa/image/58bfe526-5483-456c-e647-25fad77c39e5.jpg" />
                    </div>
                    <div>
                        <p class="font-bold text-galaxy-blue">Messenger:</p>
                        <p class="text-gray-500 text-xs">m.me/sapowebvietnam</p>
                    </div>
                </a>

                <!-- Cửa hàng -->
                <a href="https://www.google.com/maps?q=Nguyễn+Huệ,+Cao+Lãnh,+Đồng+Tháp" target="_blank"
                    class="flex items-center gap-3 hover:bg-blue-50 p-3 rounded-xl transition">
                    <div class="w-10 h-10 rounded-full galaxy-gradient text-white flex items-center justify-center">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <p class="font-bold text-galaxy-blue">Hệ thống cửa hàng:</p>
                        <p class="text-gray-500 text-xs">Xem địa chỉ cửa hàng</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Enhanced Scroll to Top Button -->
        <button id="scrollTopBtn"
            class="hidden fixed bottom-28 right-6 w-12 h-12 rounded-full galaxy-gradient text-white text-xl flex items-center justify-center shadow-2xl z-40 transition-all duration-300 ease-in-out bounce-smooth hover:scale-110">
            <i class="fas fa-arrow-up"></i>
        </button>

        <!-- Script xử lý -->
        <script>
            const contactToggle = document.getElementById("contactToggle");
            const contactBox = document.getElementById("contactBox");
            const closeContact = document.getElementById("closeContact");
            const scrollTopBtn = document.getElementById("scrollTopBtn");

            // Toggle hiển thị khung liên hệ
            contactToggle.addEventListener("click", () => {
                contactBox.classList.remove("translate-x-full", "opacity-0", "pointer-events-none");
                contactBox.classList.add("translate-x-0", "opacity-100");
            });

            closeContact.addEventListener("click", () => {
                contactBox.classList.remove("translate-x-0", "opacity-100");
                contactBox.classList.add("translate-x-full", "opacity-0", "pointer-events-none");
            });

            // Hiện/ẩn nút scroll-top
            window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.remove("hidden");
                } else {
                    scrollTopBtn.classList.add("hidden");
                }
            });

            // Cuộn lên đầu trang
            scrollTopBtn.addEventListener("click", () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        </script>

        <!-- Enhanced Categories Section -->
        <section class="max-w-[1200px] mx-auto px-4 py-12">
            <div class="category-section p-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8 text-center">
                @foreach($categories as $row)
                <a href="{{ route('products.all', ['category' => $row->id]) }}"
                    class="category-link modern-card p-6 block group">
                    <div class="relative">
                        <img src="{{ $row->image }}"
                            alt="Ảnh"
                            class="category-img mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <div class="sparkle">

                        </div>
                    </div>
                    <p class="text-base font-semibold text-galaxy-blue group-hover:text-galaxy-accent transition-colors">{{ $row->name }}</p>
                </a>
                @endforeach
            </div>
        </section>

        <!-- Enhanced Suggestion -->
        <section class="flex justify-center mt-8">
            <div class="suggestion-box text-xl font-semibold px-8 py-4 shadow-lg flex items-center gap-4">
                <div class="w-12 h-12 rounded-full galaxy-gradient flex items-center justify-center">
                    <img src="https://storage.googleapis.com/a1aa/image/3b9f5989-997d-471c-3b74-05d4cc2a695f.jpg"
                        class="w-8 h-8 rounded-full" />
                </div>
                Bạn đang tìm quà cho người thân yêu?
            </div>
        </section>

        <!-- Enhanced Flash Sale Section -->
        <section class="max-w-[1280px] mx-auto mt-16 px-4">
            <!-- Thanh tiêu đề -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold flash-sale-title tracking-wide uppercase mb-4">
                    Ưu Đãi Vàng Cho Sản Phẩm Trang Sức
                </h1>
                <p class="text-galaxy-blue mt-3 text-lg md:text-xl font-medium">
                    Chỉ áp dụng trong thời gian giới hạn – Đừng bỏ lỡ!
                </p>
            </div>

            <div class="flash-sale-container p-8 shadow-2xl">
                <!-- Tiêu đề Flash Sale -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <h2 class="flex items-center flash-sale-title font-extrabold text-2xl md:text-3xl gap-3">
                        <i class="fas fa-gem text-galaxy-gold text-3xl"></i> FLASH SALE TRANG SỨC
                    </h2>
                    <p class="text-galaxy-blue text-base md:text-lg mt-3 md:mt-0 font-bold">
                        Giảm ngay 120.000đ cho đơn hàng từ 500.000đ
                    </p>
                    <div class="flex gap-3 mt-4 md:mt-0">
                        <!-- Thời gian đếm ngược -->
                        <div id="countdown" class="flex gap-3">
                            <div id="days" class="countdown-item text-sm">0 Ngày</div>
                            <div id="hours" class="countdown-item text-sm">00</div>
                            <div id="minutes" class="countdown-item text-sm">00</div>
                            <div id="seconds" class="countdown-item text-sm">00</div>
                        </div>
                    </div>
                </div>

                <script>
                    // Cài đặt ngày đích (ví dụ: flash sale kết thúc sau 10 ngày từ hôm nay)
                    const countdownDate = new Date();
                    countdownDate.setDate(countdownDate.getDate() + 200)

                    function updateCountdown() {
                        const now = new Date().getTime();
                        const distance = countdownDate.getTime() - now;

                        if (distance < 0) {
                            document.getElementById("countdown").innerHTML =
                                "<span class='text-red-700 font-semibold'>Đã kết thúc</span>";
                            clearInterval(interval);
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.getElementById("days").innerText = `${days} Ngày`;
                        document.getElementById("hours").innerText = String(hours).padStart(2, '0');
                        document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
                        document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
                    }

                    // Cập nhật mỗi giây
                    const interval = setInterval(updateCountdown, 1000);
                    updateCountdown(); // chạy lần đầu
                </script>

                <!-- Enhanced Slider Flash Sale -->
                <!-- Enhanced Slider Flash Sale -->
                <div class="flex overflow-x-auto gap-8 scrollbar-hide">
                    @foreach($newProducts as $p)
                    @php
                    $discount = $p->discount ?? 10;
                    $sold = $p->sold ?? 100;
                    $oldPrice = $p->price / (1 - $discount / 100);
                    $imgUrl = !empty($p->main_image) ? asset($p->main_image) : asset('img/default.png');

                    @endphp

                    <a href="/detail/{{ $p->id }}" class="flex-shrink-0 w-[240px] product-card overflow-hidden relative hover:scale-105 block text-black no-underline">
                        <div class="p-4 flex flex-col gap-2">
                            <div class="flex gap-2 mb-2">
                                <div class="product-badge text-xs font-semibold rounded-lg px-3 py-1">Hàng mới</div>
                                @if($discount >= 20)
                                <div class="bg-gradient-to-r from-galaxy-blue to-galaxy-accent text-white text-xs font-semibold rounded-lg px-3 py-1">Bán chạy</div>
                                @endif
                            </div>

                            <div class="relative sparkle">
                                <img src="{{ $p->image }}" alt="{{ $p->name }}" class="rounded-xl w-full h-[180px] object-cover" />

                                <div class="absolute top-3 right-3 w-10 h-10 galaxy-gradient rounded-xl flex items-center justify-center">
                                    <i class="fas fa-gift text-white"></i>
                                </div>
                            </div>

                            <h3 class="text-sm mt-3 font-semibold truncate text-galaxy-blue">{{ $p->name }}</h3>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="product-price text-lg">{{ number_format($p->price, 0, ',', '.') }}đ</span>
                                <span class="galaxy-gradient text-white text-xs font-bold rounded-lg px-3 py-1">-{{ $discount }}%</span>
                            </div>

                            <div class="text-gray-400 line-through text-sm">{{ number_format($oldPrice, 0, ',', '.') }}đ</div>

                            <div class="mt-3 flex items-center gap-2">
                                <i class="fas fa-fire text-galaxy-gold"></i>
                                <div class="flex-1 bg-gray-200 rounded-full h-5 overflow-hidden">
                                    <div class="galaxy-gradient h-full text-white text-xs text-center font-semibold flex items-center justify-center"
                                        style="width: {{ min(100, ($sold / 500) * 100) }}%;">
                                        Đã bán {{ $sold }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- Enhanced Voucher Section -->
        <div class="max-w-[1200px] mx-auto px-4 mt-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold flash-sale-title mb-2">Mã Giảm Giá Đặc Biệt</h2>
                <p class="text-galaxy-blue">Nhận ngay ưu đãi hấp dẫn cho đơn hàng của bạn</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <!-- Voucher 1 -->
                <div class="w-[270px] voucher-card flex flex-col">
                    <div class="flex justify-between items-center p-4">
                        <p class="text-sm font-medium text-galaxy-blue">Mã: <span class="font-bold">STYLE20</span></p>
                        <i class="far fa-info-circle text-galaxy-accent text-lg cursor-pointer hover:text-galaxy-blue"></i>
                    </div>
                    <div class="mx-4 mb-4">
                        <div class="modern-card py-4 flex justify-center items-center">
                            <p class="text-gray-600 text-sm mr-2">Giảm</p>
                            <p class="voucher-amount font-extrabold text-3xl leading-7">10K</p>
                        </div>
                    </div>
                    <div class="voucher-footer rounded-b-2xl p-5 flex flex-col gap-2 text-sm">
                        <p class="text-galaxy-blue font-medium">Giảm giá 10,000₫ cho đơn từ 350,000₫</p>
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-galaxy-blue">HSD: <span class="font-semibold">12/12/2025</span></p>
                            <button class="btn-galaxy text-sm font-semibold px-5 py-2 copy-voucher"
                                data-code="STYLE20">Lấy mã</button>
                        </div>
                    </div>
                </div>

                <!-- Voucher 2 -->
                <div class="w-[270px] voucher-card flex flex-col">
                    <div class="flex justify-between items-center p-4">
                        <p class="text-sm font-medium text-galaxy-blue">Mã: <span class="font-bold">STYLE30</span></p>
                        <i class="far fa-info-circle text-galaxy-accent text-lg cursor-pointer hover:text-galaxy-blue"></i>
                    </div>
                    <div class="mx-4 mb-4">
                        <div class="modern-card py-4 flex justify-center items-center">
                            <p class="text-gray-600 text-sm mr-2">Giảm</p>
                            <p class="voucher-amount font-extrabold text-3xl leading-7">30K</p>
                        </div>
                    </div>
                    <div class="voucher-footer rounded-b-2xl p-5 flex flex-col gap-2 text-sm">
                        <p class="text-galaxy-blue font-medium">Giảm giá 30,000₫ cho đơn từ 699,000₫</p>
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-galaxy-blue">HSD: <span class="font-semibold">24/12/2025</span></p>
                            <button class="btn-galaxy text-sm font-semibold px-5 py-2 copy-voucher"
                                data-code="STYLE30">Lấy mã</button>
                        </div>
                    </div>
                </div>

                <!-- Voucher 3 -->
                <div class="w-[270px] voucher-card flex flex-col">
                    <div class="flex justify-between items-center p-4">
                        <p class="text-sm font-medium text-galaxy-blue">Mã: <span class="font-bold">STYLE50</span></p>
                        <i class="far fa-info-circle text-galaxy-accent text-lg cursor-pointer hover:text-galaxy-blue"></i>
                    </div>
                    <div class="mx-4 mb-4">
                        <div class="modern-card py-4 flex justify-center items-center">
                            <p class="text-gray-600 text-sm mr-2">Giảm</p>
                            <p class="voucher-amount font-extrabold text-3xl leading-7">50K</p>
                        </div>
                    </div>
                    <div class="voucher-footer rounded-b-2xl p-5 flex flex-col gap-2 text-sm">
                        <p class="text-galaxy-blue font-medium">Giảm giá 50,000₫ cho đơn từ 1,199,000₫</p>
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-galaxy-blue">HSD: <span class="font-semibold">25/12/2024</span></p>
                            <button class="btn-galaxy text-sm font-semibold px-5 py-2 copy-voucher"
                                data-code="STYLE50">Lấy mã</button>
                        </div>
                    </div>
                </div>

                <!-- Voucher 4 -->
                <div class="w-[270px] voucher-card flex flex-col">
                    <div class="flex justify-between items-center p-4">
                        <p class="text-sm font-medium text-galaxy-blue">Mã: <span class="font-bold">FREESHIP</span></p>
                        <i class="far fa-info-circle text-galaxy-accent text-lg cursor-pointer hover:text-galaxy-blue"></i>
                    </div>
                    <div class="mx-4 mb-4">
                        <div class="modern-card py-4 flex justify-center items-center">
                            <p class="text-gray-600 text-sm mr-2">Giảm</p>
                            <p class="voucher-amount font-extrabold text-3xl leading-7">40K</p>
                        </div>
                    </div>
                    <div class="voucher-footer rounded-b-2xl p-5 flex flex-col gap-2 text-sm">
                        <p class="text-galaxy-blue font-medium">Giảm giá 40,000₫ cho đơn từ 2,000,000₫</p>
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-galaxy-blue">HSD: <span class="font-semibold">25/12/2024</span></p>
                            <button class="btn-galaxy text-sm font-semibold px-5 py-2 copy-voucher"
                                data-code="FREESHIP">Lấy mã</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const buttons = document.querySelectorAll(".copy-voucher");

                buttons.forEach(button => {
                    button.addEventListener("click", function() {
                        const code = this.getAttribute("data-code");

                        // Tạo thẻ input ảo để copy
                        const tempInput = document.createElement("input");
                        tempInput.value = code;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        tempInput.setSelectionRange(0, 99999); // Đối với mobile
                        document.execCommand("copy");
                        document.body.removeChild(tempInput);

                        // Đổi nội dung nút hoặc thông báo
                        this.innerText = "Đã sao chép!";
                        this.classList.add("bg-green-600");

                        // Đặt lại sau 2 giây
                        setTimeout(() => {
                            this.innerText = "Lấy mã";
                            this.classList.remove("bg-green-600");
                        }, 2000);
                    });
                });
            });
        </script>

        <!-- Enhanced About Section -->
        <div class="max-w-[1440px] mx-auto p-6 sm:p-10 mt-12">
            <div class="flex flex-col md:flex-row items-center modern-card overflow-hidden">
                <!-- Nội dung bên trái -->
                <div class="md:w-1/2 px-6 md:px-16 py-10 md:py-20">
                    <p class="text-sm font-medium text-galaxy-accent mb-3 tracking-wide uppercase">
                        BỘ SƯU TẬP MỚI
                    </p>
                    <h1 class="font-extrabold text-5xl leading-tight mb-6 text-galaxy-blue">
                        Trang Sức Cao Cấp
                        <br />
                        <span class="flash-sale-title text-5xl font-bold">Thiết Kế Tinh Xảo</span>
                        <br />
                        Tỏa Sáng Phong Cách
                    </h1>
                    <p class="text-base text-gray-700 font-normal mb-8 max-w-md leading-relaxed">
                        Khám phá các mẫu trang sức thời thượng, mang phong cách hiện đại và sang trọng. Mỗi sản phẩm đều
                        được chế tác tỉ mỉ, tôn vinh vẻ đẹp của bạn.
                    </p>
                    <a href="gioi_thieu.php" class="btn-galaxy inline-block font-semibold text-lg">
                        Xem thêm
                    </a>
                </div>

                <!-- Hình ảnh bên phải -->
                <div class="md:w-1/2 relative">
                    <div class="sparkle">
                        <img
                            src="https://cdn.pnj.io/images/detailed/183/sp-bo-trang-suc-cuoi-vang-18k-dinh-da-ruby-pnj-trau-cau-00022-00023-1.png"
                            alt="Trang sức cao cấp"
                            class="w-full max-w-[400px] h-auto object-cover rounded-tr-2xl rounded-br-2xl"
                            loading="lazy" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Notification Bell -->
        <div class="relative bg-gray-100">

            <!-- Bell button bottom left -->
            <button id="bellBtn" aria-label="Notification bell"
                class="fixed bottom-4 left-4 w-16 h-16 md:w-20 md:h-20 rounded-full galaxy-gradient flex items-center justify-center text-white text-3xl md:text-4xl shadow-2xl z-40 hover:scale-105 transition-transform duration-200">
                <i class="fas fa-bell"></i>
            </button>

            <!-- Enhanced Popup container -->
            <div id="notificationPopup"
                class="fixed bottom-24 left-4 w-[380px] md:w-[420px] notification-popup p-8 text-white font-sans shadow-2xl z-30 hidden"
                role="dialog" aria-modal="true" aria-labelledby="popup-title">
                <div class="flex justify-between items-start mb-6">
                    <h2 id="popup-title" class="font-extrabold text-xl leading-tight max-w-[80%]">
                        Ưu điểm nổi bật của TVT Jewelry
                    </h2>
                    <button id="closePopup" aria-label="Close popup"
                        class="text-white text-2xl leading-none hover:opacity-80 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <ul class="space-y-4 mb-6 text-base font-medium leading-relaxed">
                    <li class="flex items-center"><i class="fas fa-gem mr-4 text-galaxy-gold"></i> Thiết kế tinh xảo, độc quyền</li>
                    <li class="flex items-center"><i class="fas fa-star mr-4 text-galaxy-gold"></i> Chất lượng vàng bạc đạt chuẩn</li>
                    <li class="flex items-center"><i class="fas fa-shipping-fast mr-4 text-galaxy-gold"></i> Giao hàng toàn quốc</li>
                    <li class="flex items-center"><i class="fas fa-sync-alt mr-4 text-galaxy-gold"></i> Đổi trả dễ dàng trong 48h</li>
                    <li class="flex items-center"><i class="fas fa-hand-holding-heart mr-4 text-galaxy-gold"></i> Bảo hành trọn đời sản phẩm</li>
                </ul>
                <p class="italic text-sm leading-relaxed max-w-[95%] opacity-90">
                    Hãy khám phá bộ sưu tập trang sức mới nhất của TVT – tôn vinh vẻ đẹp và đẳng cấp của bạn!
                </p>
            </div>


            <body class="bg-white text-[#4a3a23]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
                    <div class="text-center mb-14">
                        <p class="text-sm text-gray-500 mb-1">
                            Top các bài viết xu hướng hiện nay
                        </p>
                        <div class="flex items-center justify-center space-x-3">
                            <div class="h-[1px] w-14 bg-black">
                            </div>
                            <h2 class="title-font text-[#4a3a23] text-3xl font-semibold tracking-wide" style="letter-spacing: 0.1em">
                                XU HƯỚNG TRANG SỨC
                            </h2>
                            <img alt="Diamond ring jewelry icon" class="w-10 h-10 object-contain" height="40" src="https://storage.googleapis.com/a1aa/image/0a90993a-7d83-46ec-81f0-98f35ddea69d.jpg" width="40" />
                            <div class="h-[1px] w-14 bg-black">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10 max-w-[1200px] mx-auto">
                        <!-- Card 1 -->
                        <article class="flex flex-col">
                            <img alt="Silver ring with diamonds on white surface with green leaves background" class="w-full object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/771fb70b-1f97-43cb-e6e5-9ca550c33b63.jpg" width="600" />
                            <h3 class="bg-white text-center text-[#4a3a23] text-lg font-normal py-2 rounded-t-md -mt-8 relative z-10" style="font-family: 'Times New Roman', serif">
                                Khám Phá Vẻ Đẹp Tinh Tế của Ngọc Trai
                            </h3>
                            <div class="px-6 pt-4 flex flex-col items-center text-sm text-[#4a3a23]">
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-calendar-alt text-[#b87f3a]">
                                    </i>
                                    <span class="font-semibold text-[#b87f3a]">
                                        05.07.2024
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-pen-nib text-[#2a7f7f]">
                                    </i>
                                    <a class="font-semibold text-[#2a7f7f] hover:underline" href="#">
                                        Công Ty TNHH KTCN F1GENZ
                                    </a>
                                </div>
                                <div class="flex items-center space-x-1 mb-3">
                                    <i class="fas fa-comments text-[#2a7f7f]">
                                    </i>
                                    <span class="font-semibold text-[#2a7f7f]">
                                        0 Comments
                                    </span>
                                </div>
                                <p class="text-justify text-xs leading-5 max-h-[5.5rem] overflow-hidden">
                                    Chào mừng bạn đến với bộ sưu tập trang sức độc đáo và tinh tế của chúng tôi! Tất cả các sản phẩm đều được thiết kế với sự kết hợp hoàn hảo giữa hình ảnh và mã HTML, mang để…
                                </p>
                                <button class="mt-6 bg-[#b87f3a] text-white font-semibold text-base px-8 py-2 rounded-md hover:bg-[#a06f2e] transition">
                                    Xem thêm
                                </button>
                            </div>
                        </article>
                        <!-- Card 2 -->
                        <article class="flex flex-col">
                            <img alt="Gold ring in a jewelry box with blurred Christmas lights background" class="w-full object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/98300606-5967-4a8e-4dab-8b4e82a917e6.jpg" width="600" />
                            <h3 class="bg-white text-center text-[#4a3a23] text-lg font-normal py-2 rounded-t-md -mt-8 relative z-10" style="font-family: 'Times New Roman', serif">
                                Lộng Lẫy Với Trang Sức Vàng
                            </h3>
                            <div class="px-6 pt-4 flex flex-col items-center text-sm text-[#4a3a23]">
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-calendar-alt text-[#b87f3a]">
                                    </i>
                                    <span class="font-semibold text-[#b87f3a]">
                                        05.07.2024
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-pen-nib text-[#2a7f7f]">
                                    </i>
                                    <a class="font-semibold text-[#2a7f7f] hover:underline" href="#">
                                        Công Ty TNHH KTCN F1GENZ
                                    </a>
                                </div>
                                <div class="flex items-center space-x-1 mb-3">
                                    <i class="fas fa-comments text-[#2a7f7f]">
                                    </i>
                                    <span class="font-semibold text-[#2a7f7f]">
                                        0 Comments
                                    </span>
                                </div>
                                <p class="text-justify text-xs leading-5 max-h-[5.5rem] overflow-hidden">
                                    Chào mừng bạn đến với bộ sưu tập trang sức độc đáo và tinh tế của chúng tôi! Tất cả các sản phẩm đều được thiết kế với sự kết hợp hoàn hảo giữa hình ảnh và mã HTML, mang để…
                                </p>
                                <button class="mt-6 bg-[#b87f3a] text-white font-semibold text-base px-8 py-2 rounded-md hover:bg-[#a06f2e] transition">
                                    Xem thêm
                                </button>
                            </div>
                        </article>
                        <!-- Card 3 -->
                        <article class="flex flex-col">
                            <img alt="Gold ring with diamonds in white velvet box held by hand" class="w-full object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/fa642c1b-1371-4716-2955-4be227008a55.jpg" width="600" />
                            <h3 class="bg-white text-center text-[#4a3a23] text-lg font-normal py-2 rounded-t-md -mt-8 relative z-10" style="font-family: 'Times New Roman', serif">
                                Tỏa Sáng Cùng Đá Quý
                            </h3>
                            <div class="px-6 pt-4 flex flex-col items-center text-sm text-[#4a3a23]">
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-calendar-alt text-[#b87f3a]">
                                    </i>
                                    <span class="font-semibold text-[#b87f3a]">
                                        05.07.2024
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1 mb-1">
                                    <i class="fas fa-pen-nib text-[#2a7f7f]">
                                    </i>
                                    <a class="font-semibold text-[#2a7f7f] hover:underline" href="#">
                                        Công Ty TNHH KTCN F1GENZ
                                    </a>
                                </div>
                                <div class="flex items-center space-x-1 mb-3">
                                    <i class="fas fa-comments text-[#2a7f7f]">
                                    </i>
                                    <span class="font-semibold text-[#2a7f7f]">
                                        0 Comments
                                    </span>
                                </div>
                                <p class="text-justify text-xs leading-5 max-h-[5.5rem] overflow-hidden">
                                    Chào mừng bạn đến với bộ sưu tập trang sức độc đáo và tinh tế của chúng tôi! Tất cả các sản phẩm đều được thiết kế với sự kết hợp hoàn hảo giữa hình ảnh và mã HTML, mang để…
                                </p>
                                <button class="mt-6 bg-[#b87f3a] text-white font-semibold text-base px-8 py-2 rounded-md hover:bg-[#a06f2e] transition">
                                    Xem thêm
                                </button>
                            </div>
                        </article>
                    </div>
                </div>
                <button aria-label="Notification bell" class="fixed bottom-6 left-6 bg-[#b87f3a] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-[#a06f2e] transition">
                    <i class="fas fa-bell text-xl">
                    </i>
                </button>
            </body>




            <script>
                const bellBtn = document.getElementById("bellBtn");
                const popup = document.getElementById("notificationPopup");
                const closeBtn = document.getElementById("closePopup");

                let autoHideTimer = null;

                // Hiện popup
                function showPopup() {
                    popup.classList.remove("hidden");

                    // Đặt hẹn giờ tự ẩn sau 5 giây
                    clearTimeout(autoHideTimer);
                    autoHideTimer = setTimeout(() => {
                        popup.classList.add("hidden");
                    }, 5000);
                }

                // Ẩn popup
                function hidePopup() {
                    popup.classList.add("hidden");
                    clearTimeout(autoHideTimer);
                }

                // Sự kiện
                bellBtn.addEventListener("click", showPopup);
                closeBtn.addEventListener("click", hidePopup);

                // Click ngoài popup sẽ ẩn
                document.addEventListener("click", function(e) {
                    if (
                        !popup.contains(e.target) &&
                        !bellBtn.contains(e.target) &&
                        !popup.classList.contains("hidden")
                    ) {
                        hidePopup();
                    }
                });
            </script>

            <!-- Enhanced Banner Carousel Script -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const wrapper = document.getElementById("bannerWrapper");
                    const dots = document.querySelectorAll(".dot");
                    const children = wrapper.children;
                    let index = 0;

                    function updateDots(i) {
                        dots.forEach((dot, idx) => {
                            if (idx === i) {
                                dot.classList.remove("opacity-60");
                                dot.classList.add("opacity-100", "scale-125");
                            } else {
                                dot.classList.remove("opacity-100", "scale-125");
                                dot.classList.add("opacity-60");
                            }
                        });
                    }

                    function scrollToIndex(i) {
                        wrapper.scrollTo({
                            left: children[0].clientWidth * i,
                            behavior: "smooth"
                        });
                        updateDots(i);
                    }

                    setInterval(() => {
                        index = (index + 1) % children.length;
                        scrollToIndex(index);
                    }, 4000);

                    wrapper.addEventListener("scroll", () => {
                        const scrollLeft = wrapper.scrollLeft;
                        const childWidth = children[0].clientWidth;
                        index = Math.round(scrollLeft / childWidth);
                        updateDots(index);
                    });

                    dots.forEach((dot, i) => {
                        dot.addEventListener("click", () => {
                            index = i;
                            scrollToIndex(i);
                        });
                    });

                    updateDots(index);
                });
            </script>
        </div>

        @endsection