@extends('user.layout')
@section('title', 'Trang chủ')
@section('content')

<style>
    @keyframes bounce-custom {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
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

    /* Ẩn thanh cuộn ngang */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    /* Custom shape for the side circles */
    .side-circle {
        width: 2.5rem;
        height: 5rem;
        background: white;
        border: 1.5px solid #d94e2a;
        border-radius: 9999px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        box-shadow: 0 0 6px rgb(217 78 42 / 0.3);
        transition: box-shadow 0.3s ease;
    }

    .side-circle.left {
        left: -1.25rem;
    }

    .side-circle.right {
        right: -1.25rem;
    }

    .card:hover .side-circle {
        box-shadow: 0 0 12px rgb(217 78 42 / 0.6);
    }

    body {
        font-family: 'Inter', sans-serif;
    }



    /* Custom scrollbar for color dots container */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<!-- Banner -->
<section class="max-w-[1200px] mx-auto mt-6 px-4">
    <div class="relative flex overflow-x-auto scroll-smooth rounded-2xl shadow-lg h-[300px] snap-x snap-mandatory"
        id="bannerWrapper">
        <img src="https://cdn.pnj.io/images/promo/252/tabsale-t6-25-1972x640CTA.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
        <img src="https://cdn.pnj.io/images/promo/177/nhancuoi-t8-1200x450ec.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
        <img src="https://cdn.pnj.io/images/promo/259/thang-trang-suc-t7-25-1972x640KPN.jpg"
            class="w-full flex-shrink-0 object-cover snap-start h-full" />
    </div>
    <div id="dotWrapper" class="flex justify-center gap-2 mt-2">
        <span class="dot w-3 h-3 rounded-full bg-gray-400 opacity-60"></span>
        <span class="dot w-3 h-3 rounded-full bg-gray-400 opacity-60"></span>
        <span class="dot w-3 h-3 rounded-full bg-gray-400 opacity-60"></span>
    </div>
</section>

<div class="w-full bg-white py-10 overflow-x-auto">
    <div class="max-w-[1200px] mx-auto px-4 flex flex-nowrap justify-center gap-x-10">
        <!-- Box 1 -->
        <div class="flex items-center gap-6 min-w-[260px] flex-shrink-0">
            <img alt="Miễn phí vận chuyển" class="w-16 h-16"
                src="https://storage.googleapis.com/a1aa/image/0f64c567-ab5c-487e-be65-c19052f60847.jpg" />
            <div>
                <p class="font-bold text-black text-lg">Miễn phí vận chuyển</p>
                <p class="text-gray-600 text-base">Đơn từ 399K</p>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="flex items-center gap-6 min-w-[260px] flex-shrink-0">
            <img alt="Đổi hàng tận nhà" class="w-16 h-16"
                src="https://storage.googleapis.com/a1aa/image/15ef9979-a470-4fc3-922f-e01908674837.jpg" />
            <div>
                <p class="font-bold text-black text-lg">Đổi hàng tận nhà</p>
                <p class="text-gray-600 text-base">Trong vòng 15 ngày</p>
            </div>
        </div>

        <!-- Box 3 -->
        <div class="flex items-center gap-6 min-w-[260px] flex-shrink-0">
            <img alt="Thanh toán COD" class="w-16 h-16"
                src="https://storage.googleapis.com/a1aa/image/1715c75c-bad8-4b9e-1607-1b6af07e7c0e.jpg" />
            <div>
                <p class="font-bold text-black text-lg">Thanh toán COD</p>
                <p class="text-gray-600 text-base">Yên tâm mua sắm</p>
            </div>
        </div>
    </div>
</div>

<body class="bg-white min-h-screen">

    <!-- Nút liên hệ nổi -->
    <button id="contactToggle"
        class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-[#d24e24] text-white text-2xl flex items-center justify-center shadow-lg z-50 hover:bg-[#b93b1f] transition">
        <i class="fas fa-headset"></i>
    </button>

    <!-- Khung liên hệ -->
    <div id="contactBox"
        class="fixed bottom-20 right-6 w-[280px] font-sans rounded-lg shadow-lg bg-white opacity-0 pointer-events-none translate-x-full transition-all duration-300 z-50">
        <div class="rounded-t-lg bg-[#d24e24] px-4 py-2 text-white text-sm flex items-center justify-between">
            <span>Liên hệ với chúng tôi</span>
            <button id="closeContact" class="text-white text-lg hover:text-gray-300 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 space-y-4 text-sm">
            <!-- Hotline -->
            <a href="tel:19006750" class="flex items-center gap-3 hover:bg-gray-100 p-2 rounded-md transition">
                <div class="w-8 h-8 rounded-full bg-[#5aa832] text-white flex items-center justify-center">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <p class="font-bold">Hotline:</p>
                    <p class="text-gray-500 text-xs">19006750</p>
                </div>
            </a>

            <!-- Zalo -->
            <a href="https://zalo.me/0123456789" target="_blank"
                class="flex items-center gap-3 hover:bg-gray-100 p-2 rounded-md transition">
                <div class="w-8 h-8 rounded-full bg-[#2d5ad9] flex items-center justify-center">
                    <img class="w-5 h-5"
                        src="https://storage.googleapis.com/a1aa/image/daaa21d5-525d-44ec-d6b9-97f49b6b8ddb.jpg" />
                </div>
                <div>
                    <p class="font-bold">Zalo chat:</p>
                    <p class="text-gray-500 text-xs">03981975690</p>
                </div>
            </a>

            <!-- Messenger -->
            <a href="https://m.me/sapowebvietnam" target="_blank"
                class="flex items-center gap-3 hover:bg-gray-100 p-2 rounded-md transition">
                <div class="w-8 h-8 rounded-full bg-[#4a90e2] flex items-center justify-center">
                    <img class="w-5 h-5"
                        src="https://storage.googleapis.com/a1aa/image/58bfe526-5483-456c-e647-25fad77c39e5.jpg" />
                </div>
                <div>
                    <p class="font-bold">Messenger:</p>
                    <p class="text-gray-500 text-xs">m.me/sapowebvietnam</p>
                </div>
            </a>

            <!-- Cửa hàng -->
            <a href="https://www.google.com/maps?q=Nguyễn+Huệ,+Cao+Lãnh,+Đồng+Tháp" target="_blank"
                class="flex items-center gap-3 hover:bg-gray-100 p-2 rounded-md transition">
                <div class="w-8 h-8 rounded-full bg-[#b94a3a] text-white flex items-center justify-center">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="font-bold">Hệ thống cửa hàng:</p>
                    <p class="text-gray-500 text-xs">Xem địa chỉ cửa hàng</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Nút trở lên đầu trang -->
    <button id="scrollTopBtn"
        class="hidden fixed bottom-24 right-6 w-12 h-12 rounded-full bg-[#d24e24] text-white text-xl flex items-center justify-center shadow-lg z-40 border-4 border-[#b23e1e] hover:bg-[#c13f17] transition-all duration-300 ease-in-out animate-bounce">
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





    <!-- Danh mục có thể click -->
    <section
        class="max-w-[1200px] mx-auto px-4 py-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 text-center text-[#3b4a6b]">
        @foreach($categories as $row)
        <a href="/jewelry/{{ $row->id }}"
            class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-4 block">
            <img src="{{ $row->image_url ?? 'https://via.placeholder.com/100x100?text=No+Image' }}"
                class="w-28 h-28 mx-auto object-cover rounded-xl mb-3" />
            <p class="text-base font-semibold">{{ $row->name }}</p>
        </a>
        @endforeach
    </section>

    <!-- Gợi ý -->
    <section class="flex justify-center mt-4">
        <div
            class="bg-[#fff8ef] text-[#3b4a6b] text-xl font-semibold px-5 py-3 rounded-full shadow flex items-center gap-3">
            <img src="https://storage.googleapis.com/a1aa/image/3b9f5989-997d-471c-3b74-05d4cc2a695f.jpg"
                class="w-8 h-8 rounded-full" />
            Bạn đang tìm quà cho người thân yêu?
        </div>
    </section>

    <!-- Sản phẩm nổi bật - FLASH SALE TRANG SỨC -->
    <section class="max-w-[1280px] mx-auto mt-12 px-4">
        <!-- Thanh tiêu đề -->
        <div class="mb-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-[#7a0057] tracking-wide uppercase">Ưu Đãi Vàng Cho Sản Phẩm
                Trang Sức</h1>
            <p class="text-[#4d4d4d] mt-2 text-base md:text-lg">Chỉ áp dụng trong thời gian giới hạn – Đừng bỏ lỡ!</p>
        </div>

        <div class="rounded-xl bg-gradient-to-r from-[#f8e1a0] to-[#fbd9c6] p-6 shadow-lg">
            <!-- Tiêu đề Flash Sale -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h2 class="flex items-center text-[#7a0057] font-extrabold text-xl md:text-2xl gap-2">
                    <i class="fas fa-gem text-yellow-500"></i> FLASH SALE TRANG SỨC
                </h2>
                <p class="text-[#7a0057] text-sm md:text-base mt-2 md:mt-0 font-semibold">
                    Giảm ngay 120.000đ cho đơn hàng từ 500.000đ
                </p>
                <div class="flex gap-2 mt-2 md:mt-0">
                    <!-- Thời gian đếm ngược -->
                    <div id="countdown" class="flex gap-2 mt-2 md:mt-0">
                        <div id="days"
                            class="border border-[#7a0057] rounded-md px-3 py-1 text-[#7a0057] font-semibold text-sm">0
                            Ngày</div>
                        <div id="hours"
                            class="border border-[#7a0057] rounded-md px-3 py-1 text-[#7a0057] font-semibold text-sm">00
                        </div>
                        <div id="minutes"
                            class="border border-[#7a0057] rounded-md px-3 py-1 text-[#7a0057] font-semibold text-sm">00
                        </div>
                        <div id="seconds"
                            class="border border-[#7a0057] rounded-md px-3 py-1 text-[#7a0057] font-semibold text-sm">00
                        </div>
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

            <!-- Slider Flash Sale -->
            <div class="flex overflow-x-auto gap-6 scrollbar-hide">
                @foreach($newProducts as $p)
                @php
                $imgUrl = !empty($p->path) ? asset('img/uploads/' . $p->path) : 'https://via.placeholder.com/160';
                $discount = $p->discount ?? 10;
                $sold = $p->sold ?? 100;
                $oldPrice = $p->price / (1 - $discount / 100);
                @endphp
                <a href="/detail/{{ $p->id }}"
                    class="flex-shrink-0 w-[220px] bg-white rounded-xl shadow-md overflow-hidden relative hover:shadow-xl transition-transform duration-200 hover:scale-105 block text-black no-underline border border-[#e1c5aa]">
                    <div class="p-3 flex flex-col gap-1">
                        <div class="flex gap-2 mb-1">
                            <div class="bg-[#f6c544] text-white text-xs font-semibold rounded-md px-2 py-[2px]">Hàng mới</div>
                            @if($discount >= 20)
                            <div class="bg-[#7a0057] text-white text-xs font-semibold rounded-md px-2 py-[2px]">Bán chạy</div>
                            @endif
                        </div>
                        <div class="relative">
                            <img src="{{ $imgUrl }}" class="rounded-lg w-full h-[170px] object-cover" />
                            <img src="https://storage.googleapis.com/a1aa/image/bf9bc4ca-91ad-4be6-f475-1fd291ccc31c.jpg"
                                class="absolute top-3 right-3 w-[35px] h-[35px] border border-[#f6c544] rounded-md"
                                alt="quà" />
                        </div>
                        <h3 class="text-sm mt-2 font-medium truncate">{{ $p->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[#b80068] font-extrabold text-base">{{ number_format($p->price, 0, ',', '.') }}đ</span>
                            <span class="bg-[#b80068] text-white text-xs font-semibold rounded-md px-2 py-[2px]">-{{ $discount }}%</span>
                        </div>
                        <div class="text-gray-400 line-through text-sm">{{ number_format($oldPrice, 0, ',', '.') }}đ</div>
                        <div class="mt-2 flex items-center gap-1">
                            <i class="fas fa-fire text-[#b80068]"></i>
                            <div class="flex-1 bg-[#f2e4de] rounded-full h-[18px] overflow-hidden">
                                <div class="bg-gradient-to-r from-[#b80068] to-[#f6c544] h-full text-white text-xs text-center font-semibold"
                                    style="width: <?php echo min(100, ($sold / 500) * 100); ?>%;">
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

    <!-- VOUCHER - MÃ GIẢM GIÁ -->
    <div class="max-w-[1200px] mx-auto px-4 mt-8">
        <div class="flex flex-wrap justify-center gap-6">
            <!-- Voucher 1 -->
            <div
                class="w-[250px] border border-[#d94e2a] rounded-xl shadow-md hover:shadow-lg transition duration-300 flex flex-col">
                <div class="flex justify-between items-center p-3">
                    <p class="text-[14px] font-medium text-black">Mã: <span class="font-bold">STYLE20</span></p>
                    <i class="far fa-info-circle text-[#d94e2a] text-[16px] cursor-pointer hover:text-[#b03a1f]"></i>
                </div>
                <div class="mx-4 mb-3">
                    <div
                        class="border border-[#d94e2a] rounded-xl py-3 flex justify-center items-center bg-white shadow-inner">
                        <p class="text-[#6b6b6b] text-[14px] mr-2">Giảm</p>
                        <p class="text-[#d94e2a] font-extrabold text-[28px] leading-7">10K</p>
                    </div>
                </div>
                <div class="bg-[#ffe6dc] rounded-b-xl p-4 flex flex-col gap-1 text-[13px]">
                    <p class="text-[#3a1d0a]">Giảm giá 10,000₫ cho đơn từ 350,000₫</p>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[#d94e2a]">HSD: <span class="font-semibold">12/12/2025</span></p>
                        <button
                            class="bg-[#d94e2a] hover:bg-[#b03a1f] text-white text-[13px] font-semibold px-4 py-1.5 rounded-lg copy-voucher"
                            data-code="STYLE20">Lấy mã</button>
                    </div>
                </div>
            </div>

            <!-- Voucher 2 -->
            <div
                class="w-[250px] border border-[#d94e2a] rounded-xl shadow-md hover:shadow-lg transition duration-300 flex flex-col">
                <div class="flex justify-between items-center p-3">
                    <p class="text-[14px] font-medium text-black">Mã: <span class="font-bold">STYLE30</span></p>
                    <i class="far fa-info-circle text-[#d94e2a] text-[16px] cursor-pointer hover:text-[#b03a1f]"></i>
                </div>
                <div class="mx-4 mb-3">
                    <div
                        class="border border-[#d94e2a] rounded-xl py-3 flex justify-center items-center bg-white shadow-inner">
                        <p class="text-[#6b6b6b] text-[14px] mr-2">Giảm</p>
                        <p class="text-[#d94e2a] font-extrabold text-[28px] leading-7">30K</p>
                    </div>
                </div>
                <div class="bg-[#ffe6dc] rounded-b-xl p-4 flex flex-col gap-1 text-[13px]">
                    <p class="text-[#3a1d0a]">Giảm giá 30,000₫ cho đơn từ 699,000₫</p>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[#d94e2a]">HSD: <span class="font-semibold">24/12/2025</span></p>
                        <button
                            class="copy-voucher bg-[#d94e2a] hover:bg-[#b03a1f] text-white text-[13px] font-semibold px-4 py-1.5 rounded-lg"
                            data-code="STYLE30">Lấy mã</button>

                    </div>
                </div>
            </div>

            <!-- Voucher 3 -->
            <div
                class="w-[250px] border border-[#d94e2a] rounded-xl shadow-md hover:shadow-lg transition duration-300 flex flex-col">
                <div class="flex justify-between items-center p-3">
                    <p class="text-[14px] font-medium text-black">Mã: <span class="font-bold">STYLE50</span></p>
                    <i class="far fa-info-circle text-[#d94e2a] text-[16px] cursor-pointer hover:text-[#b03a1f]"></i>
                </div>
                <div class="mx-4 mb-3">
                    <div
                        class="border border-[#d94e2a] rounded-xl py-3 flex justify-center items-center bg-white shadow-inner">
                        <p class="text-[#6b6b6b] text-[14px] mr-2">Giảm</p>
                        <p class="text-[#d94e2a] font-extrabold text-[28px] leading-7">50K</p>
                    </div>
                </div>
                <div class="bg-[#ffe6dc] rounded-b-xl p-4 flex flex-col gap-1 text-[13px]">
                    <p class="text-[#3a1d0a]">Giảm giá 50,000₫ cho đơn từ 1,199,000₫</p>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[#d94e2a]">HSD: <span class="font-semibold">25/12/2024</span></p>
                        <button
                            class="copy-voucher bg-[#d94e2a] hover:bg-[#b03a1f] text-white text-[13px] font-semibold px-4 py-1.5 rounded-lg"
                            data-code="STYLE50">Lấy mã</button>

                    </div>
                </div>
            </div>

            <!-- Voucher 4 -->
            <div
                class="w-[250px] border border-[#d94e2a] rounded-xl shadow-md hover:shadow-lg transition duration-300 flex flex-col">
                <div class="flex justify-between items-center p-3">
                    <p class="text-[14px] font-medium text-black">Mã: <span class="font-bold">FREESHIP</span></p>
                    <i class="far fa-info-circle text-[#d94e2a] text-[16px] cursor-pointer hover:text-[#b03a1f]"></i>
                </div>
                <div class="mx-4 mb-3">
                    <div
                        class="border border-[#d94e2a] rounded-xl py-3 flex justify-center items-center bg-white shadow-inner">
                        <p class="text-[#6b6b6b] text-[14px] mr-2">Giảm</p>
                        <p class="text-[#d94e2a] font-extrabold text-[28px] leading-7">40K</p>
                    </div>
                </div>
                <div class="bg-[#ffe6dc] rounded-b-xl p-4 flex flex-col gap-1 text-[13px]">
                    <p class="text-[#3a1d0a]">Giảm giá 40,000₫ cho đơn từ 2,000,000₫</p>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[#d94e2a]">HSD: <span class="font-semibold">25/12/2024</span></p>
                        <button
                            class="copy-voucher bg-[#d94e2a] hover:bg-[#b03a1f] text-white text-[13px] font-semibold px-4 py-1.5 rounded-lg"
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



    <div class="max-w-[1440px] mx-auto p-6 sm:p-10">
        <di class="flex flex-col md:flex-row items-center bg-white rounded-2xl overflow-hidden"
            style="box-shadow: none">
            <!-- Nội dung bên trái -->
            <div class="md:w-1/2 px-6 md:px-16 py-10 md:py-20">
                <p class="text-xs font-normal text-gray-700 mb-2 tracking-wide">
                    BỘ SƯU TẬP MỚI
                </p>
                <h1 class="font-extrabold text-3xl leading-[1.1] mb-4">
                    Trang Sức Cao Cấp
                    <br />
                    Thiết Kế Tinh Xảo
                    <br />
                    Tỏa Sáng Phong Cách
                </h1>
                <p class="text-gray-700 text-sm font-normal mb-8 max-w-md leading-relaxed">
                    Khám phá các mẫu trang sức thời thượng, mang phong cách hiện đại và sang trọng. Mỗi sản phẩm đều
                    được chế tác tỉ mỉ, tôn vinh vẻ đẹp của bạn.
                </p>
                <a href="gioi_thieu.php "
                    class="inline-block bg-[#d94a2a] text-white font-semibold rounded-md px-6 py-3 hover:bg-[#b03a1f] transition-colors">
                    Xem thêm
                </a>
            </div>

            <!-- Hình ảnh bên phải -->
            <div class="md:w-1/2">
                <img src="../images/trangsuc.jpg" alt="Trang sức cao cấp - nhẫn, vòng cổ, dây chuyền lấp lánh"
                    class="w-full h-auto object-cover rounded-tr-2xl rounded-br-2xl" width="900" height="400"
                    loading="lazy" />
            </div>

    </div>
    </div>





    <body class="relative min-h-screen bg-gray-100">

        <!-- Bell button bottom left -->
        <button id="bellBtn" aria-label="Notification bell"
            class="fixed bottom-4 left-4 w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#DD4B29] flex items-center justify-center text-white text-3xl md:text-4xl shadow-2xl z-40 hover:scale-105 transition-transform duration-200">
            <i class="fas fa-bell"></i>
        </button>

        <!-- Popup container -->
        <div id="notificationPopup"
            class="fixed bottom-24 left-4 w-[350px] md:w-[400px] bg-[#DD4B29] rounded-2xl p-8 text-white font-sans shadow-2xl z-30 hidden"
            role="dialog" aria-modal="true" aria-labelledby="popup-title">
            <div class="flex justify-between items-start mb-4">
                <h2 id="popup-title" class="font-extrabold text-xl leading-tight max-w-[80%]">
                    Ưu điểm nổi bật của TVT Jewelry
                </h2>
                <button id="closePopup" aria-label="Close popup"
                    class="text-white text-2xl leading-none hover:opacity-80">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul class="space-y-3 mb-5 text-base font-medium leading-relaxed">
                <li class="flex items-center"><i class="fas fa-gem mr-3"></i> Thiết kế tinh xảo, độc quyền</li>
                <li class="flex items-center"><i class="fas fa-star mr-3"></i> Chất lượng vàng bạc đạt chuẩn</li>
                <li class="flex items-center"><i class="fas fa-shipping-fast mr-3"></i> Giao hàng toàn quốc</li>
                <li class="flex items-center"><i class="fas fa-sync-alt mr-3"></i> Đổi trả dễ dàng trong 48h</li>
                <li class="flex items-center"><i class="fas fa-hand-holding-heart mr-3"></i> Bảo hành trọn đời sản phẩm
                </li>
            </ul>
            <p class="italic text-sm leading-relaxed max-w-[95%]">
                Hãy khám phá bộ sưu tập trang sức mới nhất của TVT – tôn vinh vẻ đẹp và đẳng cấp của bạn!
            </p>
        </div>



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




        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const wrapper = document.getElementById("bannerWrapper");
                const dots = document.querySelectorAll(".dot");
                const children = wrapper.children;
                let index = 0;

                function updateDots(i) {
                    dots.forEach((dot, idx) => {
                        dot.classList.toggle("bg-white", idx === i);
                        dot.classList.toggle("opacity-100", idx === i);
                        dot.classList.toggle("opacity-60", idx !== i);
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


        @endsection