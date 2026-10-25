<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول لنظام إدارة العقارات | صفران العقارية' : 'CRM Portal Login | Safran Real Estate' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/luxury-brown.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: var(--primary-950);
            background: linear-gradient(135deg, #140d08 0%, #241810 50%, #342217 100%);
            color: #ffffff;
        }
        .login-layout {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            width: 100%;
            min-height: 100vh;
        }
        .login-brand-side {
            position: relative;
            background: linear-gradient(180deg, rgba(20, 13, 8, 0.72) 0%, rgba(35, 23, 14, 0.94) 100%),
                        url('{{ asset('images/properties/villa_alshati.jpg') }}') center/cover no-repeat;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-inline-end: 1px solid rgba(200, 155, 83, 0.25);
        }
        .login-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            background: #ffffff;
            color: var(--primary-900);
            position: relative;
        }
        .login-box {
            width: 100%;
            max-width: 440px;
        }
        @media (max-width: 900px) {
            .login-layout { grid-template-columns: 1fr; }
            .login-brand-side { display: none; }
        }
    </style>
</head>
<body>

<div class="login-layout">
    <!-- HERO BRAND SIDE -->
    <div class="login-brand-side">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('website.home') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--accent-gold-light); font-size: 0.92rem; font-weight: 700;">
                <i class="fa-solid fa-arrow-right"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'العودة للموقع العام' : 'Return to Website' }}</span>
            </a>

            @if(app()->getLocale() === 'ar')
                <a href="{{ route('lang.switch', 'en') }}" class="lang-switcher">
                    <i class="fa-solid fa-globe"></i> English
                </a>
            @else
                <a href="{{ route('lang.switch', 'ar') }}" class="lang-switcher">
                    <i class="fa-solid fa-globe"></i> العربية
                </a>
            @endif
        </div>

        <div>
            <img src="{{ asset('images/logo.png') }}" alt="{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}" style="height: 72px; width: auto; object-fit: contain; margin-bottom: 1.5rem; filter: drop-shadow(0 4px 15px rgba(0,0,0,0.5));">
            <span class="badge-gold" style="margin-bottom: 1rem;"><i class="fa-solid fa-shield-halved"></i> {{ app()->getLocale() === 'ar' ? 'نظام إدارة العقارات المتكامل' : 'Enterprise Real Estate CRM' }}</span>
            <h1 style="color: #ffffff; font-size: 2.6rem; line-height: 1.3; margin-bottom: 1.25rem;">
                {{ app()->getLocale() === 'ar' ? 'منظومة صفران العقارية' : 'Safran Real Estate System' }}
            </h1>
            <p style="color: rgba(255, 255, 255, 0.85); font-size: 1.05rem; line-height: 1.8; max-width: 480px;">
                {{ app()->getLocale() === 'ar' ? 'منصة عقارية متكاملة لشركة صفران العقارية تربط بين فريق التسويق (تجميع وعرض الوحدات)، وفريق خدمة العملاء (التواصل مع الملاك والمشترين)، والإدارة التنفيذية.' : 'Unified real estate platform coordinating between the Marketing Team, Customer Care, and Executive Management.' }}
            </p>
        </div>

        <div style="display: flex; gap: 2rem; color: rgba(255, 255, 255, 0.7); font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 1.5rem;">
            <div><i class="fa-solid fa-city text-gold" style="margin-inline-end: 0.35rem;"></i> {{ app()->getLocale() === 'ar' ? 'جدة، المملكة' : 'Jeddah, KSA' }}</div>
            <div><i class="fa-solid fa-lock text-gold" style="margin-inline-end: 0.35rem;"></i> {{ app()->getLocale() === 'ar' ? 'صلاحيات حسب الدور' : 'Role-Based Access' }}</div>
            <div><i class="fa-solid fa-user-shield text-gold" style="margin-inline-end: 0.35rem;"></i> {{ app()->getLocale() === 'ar' ? 'دخول موثق للموظفين' : 'Staff Authenticated' }}</div>
        </div>
    </div>

    <!-- LOGIN FORM SIDE -->
    <div class="login-form-side">
        <div class="login-box">
            <div style="margin-bottom: 2rem; text-align: center;">
                <img src="{{ asset('images/logo.png') }}" alt="{{ app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate' }}" style="height: 64px; width: auto; object-fit: contain; margin-bottom: 0.85rem;">
                <h2 style="font-size: 2.1rem; color: var(--primary-900); font-weight: 800; margin-bottom: 0.5rem;">
                    {{ app()->getLocale() === 'ar' ? 'تسجيل دخول الموظفين' : 'Sign In to CRM' }}
                </h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    {{ app()->getLocale() === 'ar' ? 'أدخل بيانات الاعتماد الرسمية للوصول لنظام إدارة عقارات صفران.' : 'Enter your official staff credentials to access Safran Real Estate CRM.' }}
                </p>
            </div>

            @if(session('info'))
                <div class="badge-info" style="display: block; padding: 0.75rem 1rem; margin-bottom: 1.25rem; border-radius: 10px;">
                    <i class="fa-solid fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error" style="margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني أو الرقم الوظيفي' : 'Email or Employee Number' }}</label>
                    <div class="form-input-with-icon" style="position: relative;">
                        <input type="text" id="login" name="login" required autofocus value="{{ old('login') }}" class="form-input" style="padding-inline-start: 2.75rem;" placeholder="{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني أو الرقم الوظيفي (مثال: 1001)' : 'Email or Employee ID (e.g. 1001 or staff@realestate.sa)' }}">
                        <i class="fa-solid fa-id-badge" style="position: absolute; inset-inline-start: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <label class="form-label" style="margin-bottom: 0;">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}</label>
                        <a href="{{ route('password.request') }}" style="font-size: 0.82rem; color: var(--accent-bronze); text-decoration: none; font-weight: 600;">
                            {{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}
                        </a>
                    </div>
                    <div class="form-input-with-icon" style="position: relative;">
                        <input type="password" id="password" name="password" required class="form-input" style="padding-inline-start: 2.75rem;" placeholder="••••••••">
                        <i class="fa-solid fa-lock" style="position: absolute; inset-inline-start: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.88rem; cursor: pointer; color: var(--text-muted);">
                        <input type="checkbox" name="remember" style="accent-color: var(--accent-bronze);">
                        <span>{{ app()->getLocale() === 'ar' ? 'تذكر تسجيل دخولي' : 'Keep me signed in' }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.82rem; color: var(--primary-900); background: #f4ede6; padding: 4px 10px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                        <i class="fa-solid fa-envelope-circle-check text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'دخول عبر رمز OTP' : 'Login with OTP' }}</span>
                    </a>
                </div>

                <button type="submit" class="btn-luxury" style="width: 100%; height: 48px; font-size: 1rem;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول والمتابعة' : 'Sign In & Enter' }}</span>
                </button>
            </form>

            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
                <p style="margin: 0; font-size: 0.82rem; color: var(--text-muted); line-height: 1.6;">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    {{ app()->getLocale() === 'ar' ? 'بوابة دخول آمنة لموظفي شركة صفران العقارية. يمكنك الدخول ببريدك أو رقمك الوظيفي، أو طلب رمز تحقق OTP على بريدك.' : 'Secure portal for Safran Real Estate staff. Sign in with email or employee number, or request an email OTP.' }}
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
