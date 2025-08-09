@extends('user.layout')
@section('title', 'Giới thiệu')

@section('content')
<style>
    :root {
        --galaxy-blue: #2E4F99;
        --galaxy-blue-light: #4A6BB8;
        --galaxy-blue-dark: #1E3A73;
        --galaxy-accent: #7B94D9;
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --text-dark: #2D3748;
        --text-light: #718096;
        --shadow-light: rgba(46, 79, 153, 0.1);
        --shadow-medium: rgba(46, 79, 153, 0.2);
        --gradient-primary: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
        --gradient-overlay: linear-gradient(135deg, rgba(46, 79, 153, 0.8) 0%, rgba(74, 107, 184, 0.6) 100%);
    }

    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: var(--text-dark);
        background-color: var(--white);
    }

    /* Hero Section */
    .hero {
        background-image: url('https://locphuc.com.vn/Content/Images/Event/SlideBanner2_PC.jpg');
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 70vh;
        display: flex;
        align-items: center;
        color: var(--white);
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--gradient-overlay);
        backdrop-filter: blur(1px);
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(transparent, var(--white));
    }

    .hero .container {
        position: relative;
        z-index: 3;
    }

    .hero h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        letter-spacing: -0.02em;
    }

    .hero p.lead {
        font-size: 1.3rem;
        font-weight: 300;
        margin-bottom: 2rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-galaxy {
        background: var(--gradient-primary);
        border: none;
        color: var(--white);
        padding: 16px 32px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px var(--shadow-medium);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }

    .btn-galaxy::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--galaxy-blue-light) 0%, var(--galaxy-blue-dark) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-galaxy:hover::before {
        opacity: 1;
    }

    .btn-galaxy:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px var(--shadow-medium);
        color: var(--white);
    }

    .btn-galaxy span {
        position: relative;
        z-index: 1;
    }

    /* About Section */
    .about-section {
        padding: 100px 0;
        background: linear-gradient(135deg, var(--light-gray) 0%, var(--white) 100%);
        position: relative;
    }

    .about-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--gradient-primary);
    }

    .section-title {
        font-size: 3rem;
        font-weight: 700;
        color: var(--galaxy-blue-dark);
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--gradient-primary);
        border-radius: 2px;
    }

    .lead-text {
        font-size: 1.2rem;
        color: var(--text-light);
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
        font-weight: 400;
    }

    /* Products Section */
    .products-section {
        padding: 100px 0;
        background: var(--white);
    }

    .card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--white);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 20px;
        padding: 2px;
        background: var(--gradient-primary);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: subtract;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: subtract;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card:hover::before {
        opacity: 1;
    }

    .card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 60px var(--shadow-medium);
    }

    .card-img-top {
        height: 280px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.1);
    }

    .card-body {
        padding: 2rem;
        background: var(--white);
        position: relative;
        z-index: 2;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--galaxy-blue-dark);
        margin-bottom: 1rem;
        letter-spacing: -0.01em;
    }

    .card-text {
        font-size: 1rem;
        color: var(--text-light);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .btn-outline-galaxy {
        border: 2px solid var(--galaxy-blue);
        color: var(--galaxy-blue);
        background: transparent;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
        position: relative;
        overflow: hidden;
    }

    .btn-outline-galaxy::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--gradient-primary);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .btn-outline-galaxy span {
        position: relative;
        z-index: 1;
    }

    .btn-outline-galaxy:hover::before {
        transform: translateX(0);
    }

    .btn-outline-galaxy:hover {
        color: var(--white);
        border-color: var(--galaxy-blue-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-light);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero {
            height: 60vh;
            background-attachment: scroll;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .section-title {
            font-size: 2.2rem;
        }

        .about-section,
        .products-section {
            padding: 60px 0;
        }

        .card-body {
            padding: 1.5rem;
        }
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-gray);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--galaxy-blue);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--galaxy-blue-dark);
    }
</style>

<!-- Hero Section -->
<section class="hero text-center">
    <div class="container">
        <h1 class="mb-4">Trang Sức Sang Trọng</h1>
        <p class="lead mb-5">Tỏa sáng mọi lúc, khẳng định đẳng cấp với những thiết kế độc đáo và tinh tế nhất.</p>
        <a href="#about" class="btn btn-galaxy btn-lg">
            <span>Khám Phá Ngay</span>
        </a>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Về Chúng Tôi</h2>
            <p class="lead-text mt-4">
                Website bán trang sức hàng đầu giúp bạn dễ dàng chọn lựa các sản phẩm đẳng cấp quốc tế. 
                Chúng tôi mang đến trải nghiệm mua sắm hiện đại, an toàn và đầy cảm hứng với những thiết kế 
                độc đáo từ các nhà thiết kế tài năng trên khắp thế giới.
            </p>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
            <p class="lead-text mt-4">
                Khám phá bộ sưu tập trang sức cao cấp với những thiết kế tinh xảo và chất lượng hoàn hảo
            </p>
        </div>
        <div class="row g-4">
            @foreach ($products as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <img src="{{ $item['img'] }}" class="card-img-top" alt="{{ $item['name'] }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $item['desc'] }}</p>
                            <a href="#" class="btn btn-outline-galaxy mt-auto align-self-start">
                                <span>Xem Chi Tiết</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection