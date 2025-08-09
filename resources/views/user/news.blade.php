@extends('user.layout')



@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức - Trang Sức Cao Cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'galaxy-blue': '#1e40af',
                        'galaxy-dark': '#1e3a8a',
                        'galaxy-light': '#3b82f6',
                        'galaxy-accent': '#60a5fa'
                    }
                }
            }
        }
    </script>
    <style>
        .galaxy-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #312e81 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.2);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Hero Banner -->
    <div class="relative h-80 galaxy-gradient overflow-hidden">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
            <div class="text-center space-y-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Tin Tức Trang Sức</h1>
                <p class="text-lg opacity-90">Cập nhật xu hướng trang sức mới nhất</p>
                <div class="flex space-x-6 mt-6">
                    <i class="fab fa-facebook-f text-2xl hover:text-galaxy-accent cursor-pointer transition-colors"></i>
                    <i class="fab fa-twitter text-2xl hover:text-galaxy-accent cursor-pointer transition-colors"></i>
                    <i class="fab fa-instagram text-2xl hover:text-galaxy-accent cursor-pointer transition-colors"></i>
                </div>
                <div class="mt-6 flex items-center space-x-2 text-sm">
                    <a href="#" class="hover:text-galaxy-accent transition-colors">Trang Chủ</a>
                    <span class="text-galaxy-accent">•</span>
                    <span>Tin Tức</span>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-10 left-10 w-20 h-20 border border-white border-opacity-20 rounded-full"></div>
        <div class="absolute bottom-20 right-20 w-16 h-16 border border-white border-opacity-30 rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-6">
                <!-- Navigation Card -->
<div class="glass-effect rounded-xl p-6 shadow-lg border border-galaxy-blue border-opacity-20">
    <h3 class="text-galaxy-dark font-bold text-lg mb-4 flex items-center">
        <i class="fas fa-bars mr-2"></i>
        Danh Mục
    </h3>
    <nav class="space-y-3">
        <a href="{{ url('/') }}" 
           class="flex items-center text-gray-700 hover:text-galaxy-blue transition-colors py-2 px-3 rounded-lg hover:bg-galaxy-blue hover:bg-opacity-10">
            <i class="fas fa-home w-5 mr-3"></i>Trang chủ
        </a>
        <a href="{{ url('/san-pham') }}" 
           class="flex items-center text-gray-700 hover:text-galaxy-blue transition-colors py-2 px-3 rounded-lg hover:bg-galaxy-blue hover:bg-opacity-10">
            <i class="fas fa-gem w-5 mr-3"></i>Sản phẩm
        </a>
        <a href="{{ url('/gioi-thieu') }}" 
           class="flex items-center text-gray-700 hover:text-galaxy-blue transition-colors py-2 px-3 rounded-lg hover:bg-galaxy-blue hover:bg-opacity-10">
            <i class="fas fa-info-circle w-5 mr-3"></i>Giới thiệu
        </a>
        <a href="{{ route('news.index') }}" 
           class="flex items-center text-galaxy-blue font-semibold py-2 px-3 rounded-lg bg-galaxy-blue bg-opacity-10">
            <i class="fas fa-newspaper w-5 mr-3"></i>Tin tức
        </a>
        <a href="{{ url('/lien-he') }}" 
           class="flex items-center text-gray-700 hover:text-galaxy-blue transition-colors py-2 px-3 rounded-lg hover:bg-galaxy-blue hover:bg-opacity-10">
            <i class="fas fa-envelope w-5 mr-3"></i>Liên hệ
        </a>
    </nav>
</div>


                <!-- Categories Card -->
                <div class="glass-effect rounded-xl p-6 shadow-lg border border-galaxy-blue border-opacity-20">
                    <button onclick="toggleSection('categoryList', 'categoryArrow')"
                        class="w-full flex justify-between items-center text-galaxy-dark font-semibold hover:text-galaxy-blue transition-colors">
                        <span class="flex items-center">
                            <i class="fas fa-tags mr-2"></i>
                            Danh mục sản phẩm
                        </span>
                        <i id="categoryArrow" class="fas fa-chevron-down transition-transform duration-300"></i>
                    </button>
                    <div id="categoryList" class="mt-4 space-y-2 hidden">
                        <a href="#" class="block text-sm text-gray-600 hover:text-galaxy-blue transition-colors py-2 px-3 rounded hover:bg-galaxy-blue hover:bg-opacity-5">Nhẫn kim cương</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-galaxy-blue transition-colors py-2 px-3 rounded hover:bg-galaxy-blue hover:bg-opacity-5">Dây chuyền vàng</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-galaxy-blue transition-colors py-2 px-3 rounded hover:bg-galaxy-blue hover:bg-opacity-5">Hoa tai bạc</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-galaxy-blue transition-colors py-2 px-3 rounded hover:bg-galaxy-blue hover:bg-opacity-5">Vòng tay cao cấp</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-galaxy-blue transition-colors py-2 px-3 rounded hover:bg-galaxy-blue hover:bg-opacity-5">Đồng hồ luxury</a>
                    </div>
                </div>

                <!-- Advertisement Card -->
                <div class="glass-effect rounded-xl p-6 shadow-lg border border-galaxy-blue border-opacity-20">
                    <h4 class="text-galaxy-dark font-semibold mb-4 text-center">Sản phẩm nổi bật</h4>
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="https://cdn.pnj.io/images/detailed/138/GBXMXMY004499-GMXMXMY004846-GNXMXMY006396.png"
                            class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300" alt="Advertisement" />
                        <div class="absolute inset-0 bg-gradient-to-t from-galaxy-dark from-0% to-transparent to-50% opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                            <button class="bg-white text-galaxy-dark px-4 py-2 rounded-full text-sm font-semibold hover:bg-galaxy-accent hover:text-white transition-colors">
                                Xem chi tiết
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-3">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-galaxy-dark mb-2">Tin Tức Mới Nhất</h2>
                    <div class="w-20 h-1 bg-galaxy-blue rounded"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Article 1 -->
                    <article class="glass-effect rounded-xl overflow-hidden shadow-lg card-hover border border-galaxy-blue border-opacity-10">
                        <div class="relative">
                            <img src="https://toplist.vn/images/800px/trang-suc-bac-cao-cap-tampn-478383.jpg"
                                class="w-full h-48 object-cover" alt="Trang sức bạc cao cấp" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-galaxy-blue text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Xu hướng
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>27/08/2024</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-comments mr-1"></i>
                                <span>3 bình luận</span>
                            </div>
                            <h3 class="font-bold text-galaxy-dark mb-3 hover:text-galaxy-blue cursor-pointer transition-colors">
                                Xu hướng trang sức bạc cao cấp 2024
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                Trang sức bạc cao cấp được chế tác tinh xảo từ bạc sterling 925, mang đến vẻ đẹp sang trọng và đẳng cấp cho phái đẹp hiện đại.
                            </p>
                            <a href="#" class="inline-flex items-center text-galaxy-blue hover:text-galaxy-dark font-semibold text-sm transition-colors">
                                Xem tiếp
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>

                    <!-- Article 2 -->
                    <article class="glass-effect rounded-xl overflow-hidden shadow-lg card-hover border border-galaxy-blue border-opacity-10">
                        <div class="relative">
                            <img src="https://www.elle.vn/wp-content/uploads/2021/02/10/424946/vong-co-trang-suc-cao-cap.jpg"
                                class="w-full h-48 object-cover" alt="Vòng cổ cao cấp" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-galaxy-accent text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Thời trang
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>25/08/2024</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-comments mr-1"></i>
                                <span>7 bình luận</span>
                            </div>
                            <h3 class="font-bold text-galaxy-dark mb-3 hover:text-galaxy-blue cursor-pointer transition-colors">
                                Bí quyết chọn vòng cổ phù hợp với từng dáng người
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                Chiếc vòng cổ trang sức cao cấp được thiết kế tinh xảo, nổi bật với các viên đá quý lấp lánh, tôn lên vẻ đẹp quyến rũ của người phụ nữ.
                            </p>
                            <a href="#" class="inline-flex items-center text-galaxy-blue hover:text-galaxy-dark font-semibold text-sm transition-colors">
                                Xem tiếp
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>

                    <!-- Article 3 -->
                    <article class="glass-effect rounded-xl overflow-hidden shadow-lg card-hover border border-galaxy-blue border-opacity-10">
                        <div class="relative">
                            <img src="https://phuclocthanh.com/wp-content/uploads/2023/06/nhung-mau-nhan-kim-cuong-dep-nhat.jpeg"
                                class="w-full h-48 object-cover" alt="Nhẫn kim cương" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Luxury
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>23/08/2024</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-comments mr-1"></i>
                                <span>12 bình luận</span>
                            </div>
                            <h3 class="font-bold text-galaxy-dark mb-3 hover:text-galaxy-blue cursor-pointer transition-colors">
                                Cách bảo quản nhẫn kim cương đúng cách
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                Những mẹo hay để giữ cho chiếc nhẫn kim cương của bạn luôn lấp lánh như mới, từ việc vệ sinh đến cách bảo quản an toàn.
                            </p>
                            <a href="#" class="inline-flex items-center text-galaxy-blue hover:text-galaxy-dark font-semibold text-sm transition-colors">
                                Xem tiếp
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>

                    <!-- Article 4 -->
                    <article class="glass-effect rounded-xl overflow-hidden shadow-lg card-hover border border-galaxy-blue border-opacity-10">
                        <div class="relative">
                            <img src="https://xuatnhapkhautheoyeucau.com/wp-content/uploads/2023/08/O1CN01vVQZKv2DGblV6PTF0_2212862698582-0-cib.jpg"
                                class="w-full h-48 object-cover" alt="Đồng hồ nữ" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Phụ kiện
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>20/08/2024</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-comments mr-1"></i>
                                <span>5 bình luận</span>
                            </div>
                            <h3 class="font-bold text-galaxy-dark mb-3 hover:text-galaxy-blue cursor-pointer transition-colors">
                                Top 10 mẫu đồng hồ nữ sang trọng nhất 2024
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                Khám phá bộ sưu tập đồng hồ nữ cao cấp với thiết kế tinh tế, chất liệu premium và tính năng vượt trội dành cho phụ nữ thành đạt.
                            </p>
                            <a href="#" class="inline-flex items-center text-galaxy-blue hover:text-galaxy-dark font-semibold text-sm transition-colors">
                                Xem tiếp
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <nav class="flex space-x-2">
                        <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-500 hover:bg-galaxy-blue hover:text-white transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-4 py-2 rounded-lg bg-galaxy-blue text-white">1</button>
                        <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-galaxy-blue hover:text-white transition-colors">2</button>
                        <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-galaxy-blue hover:text-white transition-colors">3</button>
                        <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-galaxy-blue hover:text-white transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSection(id, arrowId) {
            const element = document.getElementById(id);
            const arrow = document.getElementById(arrowId);
            
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                arrow.classList.add('fa-chevron-up');
                arrow.classList.remove('fa-chevron-down');
            } else {
                element.classList.add('hidden');
                arrow.classList.add('fa-chevron-down');
                arrow.classList.remove('fa-chevron-up');
            }
        }
    </script>
</body>
</html>
@endsection