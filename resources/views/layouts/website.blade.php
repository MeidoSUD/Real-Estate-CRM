<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', app()->getLocale() === 'ar' ? 'صفران العقارية | عقارات وفلل فاخرة في جدة' : 'Safran for Real Estate | Luxury Properties in Jeddah')</title>
    <meta name="description" content="شركة صفران العقارية: فلل سكنية فاخرة، شقق وبنتهاوس بإطلالات بحرية مباشرة على كورنيش جدة، واستثمارات عقارية تجارية موثقة عبر الهيئة العامة للعقار (فال).">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/luxury-brown.css') }}">
    <style>
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(27, 18, 12, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(200, 155, 83, 0.25);
            transition: all 0.3s ease;
        }
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            color: #ffffff;
            font-weight: 700;
        }
        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent-bronze) 0%, var(--accent-gold) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.25rem;
            box-shadow: 0 4px 15px rgba(200, 155, 83, 0.35);
        }
        .brand-text h1 {
            font-size: 1.35rem;
            color: #ffffff;
            line-height: 1.2;
        }
        .brand-text span {
            font-size: 0.74rem;
            color: var(--accent-gold-light);
            letter-spacing: 0.05em;
            display: block;
        }
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            font-size: 0.98rem;
            padding: 0.5rem 0.2rem;
            position: relative;
            transition: color 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--accent-gold-light);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-bronze), var(--accent-gold));
            border-radius: 2px;
        }
        .btn-crm-login {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, var(--accent-bronze) 0%, var(--accent-gold) 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.65rem 1.4rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 18px rgba(163, 105, 57, 0.35);
            transition: all 0.25s ease;
        }
        .btn-crm-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(200, 155, 83, 0.5);
            color: #ffffff;
        }
        .site-footer {
            background: var(--primary-950);
            color: rgba(255, 255, 255, 0.7);
            padding: 4.5rem 1.5rem 2rem;
            border-top: 1px solid rgba(200, 155, 83, 0.2);
        }
        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
        }
        .footer-bottom {
            max-width: 1280px;
            margin: 3.5rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
        }
        @media (max-width: 900px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .nav-menu {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- LUXURY NAVBAR -->
    <header class="site-header">
        <div class="nav-container">
            <a href="{{ route('website.home') }}" class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}" style="height: 50px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.3));">
                <div class="brand-text">
                    <h1 style="font-size: 1.25rem; font-weight: 800; color: #ffffff; margin: 0; line-height: 1.2;">{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'SAFRAN REAL ESTATE' }}</h1>
                    <span style="font-size: 0.72rem; color: var(--accent-gold-light); letter-spacing: 0.05em;">{{ app()->getLocale() === 'ar' ? 'للعقارات الفاخرة • المملكة العربية السعودية' : 'Luxury Real Estate • KSA' }}</span>
                </div>
            </a>

            <nav>
                <ul class="nav-menu">
                    <li>
                        <a href="{{ route('website.home') }}" class="nav-link {{ request()->routeIs('website.home') ? 'active' : '' }}">
                            {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.offers') }}" class="nav-link {{ request()->routeIs('website.offers*') ? 'active' : '' }}">
                            {{ app()->getLocale() === 'ar' ? 'العروض والوحدات' : 'Offers & Properties' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.contact') }}" class="nav-link {{ request()->routeIs('website.contact') ? 'active' : '' }}">
                            {{ app()->getLocale() === 'ar' ? 'اتصل بنا' : 'Contact Us' }}
                        </a>
                    </li>
                </ul>
            </nav>

            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <!-- LANGUAGE SWITCHER -->
                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('lang.switch', 'en') }}" class="lang-switcher" title="Switch to English">
                        <i class="fa-solid fa-globe"></i>
                        <span>English</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'ar') }}" class="lang-switcher" title="التحويل للغة العربية">
                        <i class="fa-solid fa-globe"></i>
                        <span>العربية</span>
                    </a>
                @endif

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-crm-login">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'لوحة تحكم CRM' : 'CRM Portal' }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-crm-login" id="header-login-btn">
                        <i class="fa-solid fa-lock"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'دخول النظام CRM' : 'Login to CRM' }}</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- LUXURY FOOTER -->
    <footer class="site-footer">
        <div class="footer-container">
            <div>
                <div class="brand-logo" style="margin-bottom: 1.25rem;">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}" style="height: 56px; width: auto; object-fit: contain;">
                    <div class="brand-text">
                        <h2 style="font-size: 1.35rem; color: #ffffff; margin: 0;">{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'SAFRAN REAL ESTATE' }}</h2>
                        <span style="color: var(--accent-gold-light);">{{ app()->getLocale() === 'ar' ? 'الوساطة والاستشارات العقارية المعتمدة' : 'Premier Real Estate Advisory' }}</span>
                    </div>
                </div>
                <p style="font-size: 0.92rem; line-height: 1.7; max-width: 380px; margin-bottom: 1.5rem;">
                    {{ app()->getLocale() === 'ar' ? 'نخبة الفلل السكنية الفارهة، والشقق المطلة على البحر الأحمر، والاستثمارات التجارية الواعدة في مدينة جدة. مرخصون ومعتمدون من الهيئة العامة للعقار (فال).' : 'Curating elite residential villas, waterfront penthouses, and high-yield commercial investments across Jeddah, Saudi Arabia. Certified by REGA.' }}
                </p>
                <div style="display: flex; gap: 1rem;">
                    <a href="https://wa.me/966501234567" target="_blank" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; color: var(--accent-gold-light);"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; color: var(--accent-gold-light);"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; color: var(--accent-gold-light);"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; color: var(--accent-gold-light);"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 1.25rem;">{{ app()->getLocale() === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.92rem;">
                    <li><a href="{{ route('website.home') }}">{{ app()->getLocale() === 'ar' ? 'الصفحة الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route('website.offers') }}">{{ app()->getLocale() === 'ar' ? 'العروض العقارية' : 'Property Offers' }}</a></li>
                    <li><a href="{{ route('website.contact') }}">{{ app()->getLocale() === 'ar' ? 'فريق خدمة العملاء' : 'Customer Service' }}</a></li>
                    <li><a href="{{ route('login') }}" style="color: var(--accent-gold-light); font-weight: 700;"><i class="fa-solid fa-lock" style="font-size: 0.75rem; margin-inline-end: 0.4rem;"></i>{{ app()->getLocale() === 'ar' ? 'دخول موظفي النظام' : 'Staff CRM Login' }}</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 1.25rem;">{{ app()->getLocale() === 'ar' ? 'أحياء جدة المميزة' : 'Prime Districts' }}</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.92rem;">
                    <li><a href="{{ route('website.offers', ['district' => 'Al-Shati']) }}">{{ app()->getLocale() === 'ar' ? 'حي الشاطئ الساحلي' : 'Al-Shati Coast' }}</a></li>
                    <li><a href="{{ route('website.offers', ['district' => 'Al-Rawdah']) }}">{{ app()->getLocale() === 'ar' ? 'حي الروضة الراقي' : 'Al-Rawdah' }}</a></li>
                    <li><a href="{{ route('website.offers', ['district' => 'Al-Hamra']) }}">{{ app()->getLocale() === 'ar' ? 'حي الحمراء والكورنيش' : 'Al-Hamra Corniche' }}</a></li>
                    <li><a href="{{ route('website.offers', ['district' => 'Obhur Al-Shamaliyah']) }}">{{ app()->getLocale() === 'ar' ? 'أبحر الشمالية والواجهة البحرية' : 'Obhur Waterfront' }}</a></li>
                    <li><a href="{{ route('website.offers', ['district' => 'Al-Salama']) }}">{{ app()->getLocale() === 'ar' ? 'طريق الملك وحي السلامة' : 'King Road District' }}</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 1.25rem;">{{ app()->getLocale() === 'ar' ? 'المقر الرئيسي بجدة' : 'Jeddah Headquarters' }}</h4>
                <p style="font-size: 0.92rem; margin-bottom: 0.85rem; line-height: 1.6;">
                    <i class="fa-solid fa-location-dot text-gold" style="margin-inline-end: 0.5rem;"></i>
                    {{ app()->getLocale() === 'ar' ? 'برج طريق الملك، الدور 18، طريق الملك عبدالعزيز الفرعي، جدة، المملكة العربية السعودية' : 'King Road Tower, 18th Floor, King Abdulaziz Branch Rd, Jeddah, Saudi Arabia' }}
                </p>
                <p style="font-size: 0.92rem; margin-bottom: 0.85rem;">
                    <i class="fa-solid fa-phone text-gold" style="margin-inline-end: 0.5rem;"></i>
                    +966 12 609 8888 / +966 50 123 4567
                </p>
                <p style="font-size: 0.92rem;">
                    <i class="fa-solid fa-envelope text-gold" style="margin-inline-end: 0.5rem;"></i>
                    inquiries@safran-realestate.sa
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ app()->getLocale() === 'ar' ? 'شركة صفران العقارية. جميع الحقوق محفوظة.' : 'Safran for Real Estate. All rights reserved.' }}</p>
            <p>{{ app()->getLocale() === 'ar' ? 'رخصة الوساطة والتسويق العقاري (فال): 1200019482' : 'REGA Brokerage License No. 1200019482' }}</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
