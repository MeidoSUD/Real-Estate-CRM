<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', app()->getLocale() === 'ar' ? 'لوحة تحكم CRM' : 'CRM Management') | {{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/luxury-brown.css') }}">
    <style>
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            background-color: #f7f4ee;
            min-height: 100vh;
            display: flex;
            width: 100%;
            position: relative;
        }
        /* SIDEBAR */
        .crm-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #18100a 0%, #22160f 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .sidebar-user {
            padding: 1.25rem;
            margin: 1rem 1rem 0.5rem;
            background: rgba(255, 255, 255, 0.04);
            border-radius: var(--radius-md);
            border: 1px solid rgba(200, 155, 83, 0.2);
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .sidebar-nav {
            list-style: none;
            padding: 1rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex-grow: 1;
        }
        .nav-section-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.45);
            padding: 0.75rem 0.75rem 0.25rem;
            font-weight: 700;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0.95rem;
            color: rgba(255, 255, 255, 0.82);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(200, 155, 83, 0.15);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, var(--accent-bronze) 0%, var(--accent-gold) 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(163, 105, 57, 0.3);
        }
        .submenu-list {
            list-style: none;
            padding-top: 0.35rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .submenu-link {
            display: block;
            padding: 0.45rem 0.75rem;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 6px;
            transition: all 0.2s;
            font-weight: 500;
        }
        .submenu-link:hover, .submenu-link.active {
            color: var(--accent-gold-light);
            background: rgba(255, 255, 255, 0.06);
            font-weight: 700;
        }
        /* MAIN WRAPPER */
        .crm-main {
            flex: 1 1 auto;
            min-width: 0;
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        html[dir="rtl"] .crm-main {
            margin-right: var(--sidebar-width);
            margin-left: 0;
        }
        html[dir="ltr"] .crm-main {
            margin-left: var(--sidebar-width);
            margin-right: 0;
        }
        .crm-topbar {
            height: var(--topbar-height);
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 90;
            width: 100%;
            max-width: 100%;
            min-width: 0;
        }
        .crm-content {
            padding: 1.5rem;
            flex-grow: 1;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: hidden;
        }
        @media (max-width: 900px) {
            #sidebarToggleBtn {
                display: inline-block !important;
            }
            .crm-sidebar {
                transform: translateX(100%);
                box-shadow: -5px 0 25px rgba(0,0,0,0.3);
            }
            html[dir="ltr"] .crm-sidebar {
                transform: translateX(-100%);
                box-shadow: 5px 0 25px rgba(0,0,0,0.3);
            }
            .crm-sidebar.open {
                transform: translateX(0) !important;
            }
            .crm-main,
            html[dir="rtl"] .crm-main,
            html[dir="ltr"] .crm-main {
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .crm-content {
                padding: 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- SIDEBAR (RTL-ready) -->
    <aside class="crm-sidebar" id="crmSidebar">
        <!-- BRAND -->
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}" style="height: 48px; width: auto; object-fit: contain; flex-shrink: 0; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));">
            <div>
                <div style="font-weight: 800; font-size: 1.15rem; color: #fff; line-height: 1.1;">
                    {{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'SAFRAN CRM' }}
                </div>
                <div style="font-size: 0.7rem; color: var(--accent-gold-light); letter-spacing: 0.05em; margin-top: 0.2rem;">
                    {{ app()->getLocale() === 'ar' ? 'نظام إدارة العقارات المتكامل' : 'Real Estate Management' }}
                </div>
            </div>
        </div>

        <!-- LOGGED IN USER MINI CARD -->
        <div class="sidebar-user">
            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" style="width: 44px; height: 44px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--accent-gold); flex-shrink: 0;">
            <div style="overflow: hidden; flex-grow: 1;">
                <div style="font-weight: 700; font-size: 0.92rem; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <span class="badge-gold" style="font-size: 0.68rem; padding: 0.15rem 0.5rem; margin-top: 0.2rem;">
                    @if(app()->getLocale() === 'ar')
                        @if(auth()->user()->role && auth()->user()->role->slug === 'admin')
                            الإدارة العامة
                        @elseif(auth()->user()->role && auth()->user()->role->slug === 'marketing')
                            فريق التسويق
                        @elseif(auth()->user()->role && auth()->user()->role->slug === 'customer-service')
                            خدمة العملاء
                        @else
                            {{ auth()->user()->role ? auth()->user()->role->name : 'موظف' }}
                        @endif
                    @else
                        {{ auth()->user()->role ? auth()->user()->role->name : 'Staff' }}
                    @endif
                </span>
            </div>
        </div>

        <!-- DYNAMIC NAVIGATION FROM DATABASE -->
        <ul class="sidebar-nav">
            <li class="nav-section-title">{{ app()->getLocale() === 'ar' ? 'قائمة النظام' : 'Navigation Menu' }}</li>

            @if(isset($sidebarMenus))
                @foreach($sidebarMenus as $menu)
                    @if($menu->isAccessibleBy(auth()->user()))
                        @php
                            $hasSub = $menu->subMenus->isNotEmpty();
                            $accessibleSub = $menu->subMenus->filter(fn($sub) => $sub->isAccessibleBy(auth()->user()));
                            $menuRoute = $menu->route ? (Route::has($menu->route) ? route($menu->route) : '#') : '#';
                            $isActive = $menu->route && request()->routeIs($menu->route);
                            $menuTitle = (app()->getLocale() === 'ar' && !empty($menu->title_ar)) ? $menu->title_ar : $menu->title;
                        @endphp

                        @if($hasSub && $accessibleSub->isNotEmpty())
                            <li style="margin-bottom: 0.35rem;">
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0.95rem; color: rgba(255, 255, 255, 0.85); font-weight: 600; font-size: 0.9rem; cursor: pointer; border-radius: 10px;" onclick="toggleSubmenu('sub-{{ $menu->id }}')">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <i class="fa-solid fa-{{ $menu->icon ?: 'folder' }} text-gold" style="width: 18px; text-align: center;"></i>
                                        <span>{{ $menuTitle }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; color: rgba(255,255,255,0.4);"></i>
                                </div>

                                <ul class="submenu-list" id="sub-{{ $menu->id }}">
                                    @foreach($accessibleSub as $sub)
                                        @php
                                            $subRoute = Route::has($sub->route) ? route($sub->route) : '#';
                                            $subActive = request()->routeIs($sub->route . '*');
                                            $subTitle = (app()->getLocale() === 'ar' && !empty($sub->title_ar)) ? $sub->title_ar : $sub->title;
                                        @endphp
                                        <li>
                                            <a href="{{ $subRoute }}" class="submenu-link {{ $subActive ? 'active' : '' }}">
                                                <i class="fa-solid fa-circle" style="font-size: 0.4rem; margin-inline-end: 0.4rem; vertical-align: middle;"></i>
                                                {{ $subTitle }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ $menuRoute }}" class="sidebar-link {{ $isActive ? 'active' : '' }}">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <i class="fa-solid fa-{{ $menu->icon ?: 'circle' }} text-gold" style="width: 18px; text-align: center;"></i>
                                        <span>{{ $menuTitle }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif

            <li class="nav-section-title" style="margin-top: 1rem;">{{ app()->getLocale() === 'ar' ? 'الحساب والموقع' : 'System & Account' }}</li>
            <li>
                <a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fa-solid fa-user-gear text-gold" style="width: 18px; text-align: center;"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'My Profile' }}</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('website.home') }}" target="_blank" class="sidebar-link">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fa-solid fa-globe text-gold" style="width: 18px; text-align: center;"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Website' }}</span>
                    </div>
                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                </a>
            </li>
        </ul>

        <!-- LOGOUT FORM -->
        <div style="padding: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.6rem; padding: 0.7rem 1rem; background: rgba(239, 68, 68, 0.12); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 0.9rem; transition: all 0.2s;">
                    <i class="fa-solid fa-power-off"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Sign Out' }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN BODY -->
    <div class="crm-main">
        <!-- TOPBAR -->
        <header class="crm-topbar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button onclick="document.getElementById('crmSidebar').classList.toggle('open')" style="display: none; background: none; border: none; font-size: 1.25rem; color: var(--primary-900); cursor: pointer;" id="sidebarToggleBtn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h2 style="font-size: 1.25rem; color: var(--primary-900); font-weight: 800;">
                        @yield('page_title', app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard')
                    </h2>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">
                        {{ app()->getLocale() === 'ar' ? 'فرع جدة الرئيسي • ' . now()->locale('ar')->translatedFormat('l، j F Y') : 'Jeddah Operations • ' . now()->format('l, F j, Y') }}
                    </span>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <!-- LOCALE TOGGLE -->
                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('lang.switch', 'en') }}" class="lang-switcher" style="background: var(--primary-50); color: var(--primary-800); border-color: var(--border-light);" title="Switch to English">
                        <i class="fa-solid fa-globe text-gold"></i>
                        <span>English</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'ar') }}" class="lang-switcher" style="background: var(--primary-50); color: var(--primary-800); border-color: var(--border-light);" title="التحويل للغة العربية">
                        <i class="fa-solid fa-globe text-gold"></i>
                        <span>العربية</span>
                    </a>
                @endif

                <div class="badge-dark" style="display: flex; align-items: center; gap: 0.4rem;">
                    <i class="fa-solid fa-location-dot text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'جدة، المملكة' : 'Jeddah, KSA' }}</span>
                </div>

                <a href="{{ route('website.home') }}" target="_blank" class="btn-outline-luxury btn-sm">
                    <i class="fa-solid fa-earth-americas"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'عرض الموقع' : 'View Site' }}</span>
                </a>

                <div style="display: flex; align-items: center; gap: 0.75rem; padding-inline-start: 1rem; border-inline-start: 1px solid var(--border-light);">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--accent-bronze);">
                    <div style="text-align: start;">
                        <div style="font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">{{ auth()->user()->name }}</div>
                        <div style="font-size: 0.72rem; color: var(--text-muted);">{{ auth()->user()->job_title ?: (app()->getLocale() === 'ar' ? 'موظف النظام' : 'Staff Member') }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="crm-content">
            <!-- FLASH MESSAGES -->
            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>{{ app()->getLocale() === 'ar' ? 'يرجى مراجعة وتصحيح الملاحظات التالية:' : 'Please resolve the following:' }}</strong>
                        <ul style="margin-top: 0.35rem; padding-inline-start: 1.2rem;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function toggleSubmenu(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = el.style.display === 'none' ? 'flex' : 'none';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
