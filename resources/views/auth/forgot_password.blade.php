<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'ar' ? 'استعادة الحساب والدخول برمز OTP | صفران العقارية' : 'Account Recovery & OTP Login | Safran Real Estate' }}</title>
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
            <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--accent-gold-light); font-size: 0.92rem; font-weight: 700;">
                <i class="fa-solid fa-arrow-right"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'العودة لتسجيل الدخول' : 'Back to Login' }}</span>
            </a>
            <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" style="color: #ffffff; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.25); padding: 0.35rem 0.75rem; border-radius: 6px;">
                <i class="fa-solid fa-globe"></i> {{ app()->getLocale() === 'ar' ? 'English' : 'عربي' }}
            </a>
        </div>

        <div style="max-width: 520px;">
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(200, 155, 83, 0.2); border: 1px solid var(--accent-gold); padding: 0.4rem 1rem; border-radius: 999px; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-shield-halved text-gold"></i>
                <span style="color: var(--accent-gold-light); font-size: 0.82rem; font-weight: 700; letter-spacing: 0.5px;">
                    {{ app()->getLocale() === 'ar' ? 'نظام التحقق الآمن - OTP' : 'Secure OTP Verification' }}
                </span>
            </div>

            <h1 style="font-size: 2.3rem; font-weight: 800; line-height: 1.3; margin-bottom: 1rem; color: #ffffff;">
                {{ app()->getLocale() === 'ar' ? 'استعادة كلمة المرور وتسجيل الدخول السريع' : 'Password Recovery & Quick OTP Sign-in' }}
            </h1>

            <p style="color: #cbd5e1; font-size: 1rem; line-height: 1.7; margin-bottom: 2rem;">
                {{ app()->getLocale() === 'ar' ? 'أدخل بريدك الإلكتروني المسجل أو رقمك الوظيفي، وسنرسل لك رمز تحقق مؤقت (OTP) مباشرة عبر البريد الإلكتروني للوصول إلى حسابك.' : 'Enter your registered email address or employee number, and we will send a temporary one-time passcode (OTP) directly to your inbox.' }}
            </p>
        </div>

        <div style="font-size: 0.8rem; color: #94a3b8; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.5rem;">
            &copy; {{ date('Y') }} {{ app()->getLocale() === 'ar' ? 'شركة عقارات صفران. جميع الحقوق محفوظة.' : 'Safran Real Estate. All rights reserved.' }}
        </div>
    </div>

    <!-- FORM SIDE -->
    <div class="login-form-side">
        <div class="login-box">
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 68px; height: 68px; margin: 0 auto 1.25rem; background: #faf4ed; border: 1px solid rgba(163, 105, 57, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-envelope-open-text text-gold" style="font-size: 1.8rem;"></i>
                </div>
                <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--primary-900); margin-bottom: 0.5rem;">
                    {{ app()->getLocale() === 'ar' ? 'إرسال رمز التحقق (OTP)' : 'Request Login OTP' }}
                </h2>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6;">
                    {{ app()->getLocale() === 'ar' ? 'أدخل البريد الإلكتروني أو الرقم الوظيفي لاستلام رمز الدخول.' : 'Enter your email or employee number to receive your code.' }}
                </p>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 0.85rem 1rem; border-radius: var(--radius-md); font-size: 0.88rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1rem; border-radius: var(--radius-md); font-size: 0.88rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1rem; border-radius: var(--radius-md); font-size: 0.88rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-top: 3px;"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني أو الرقم الوظيفي' : 'Email or Employee Number' }}</label>
                    <div class="form-input-with-icon" style="position: relative;">
                        <input type="text" id="login" name="login" required autofocus value="{{ old('login') }}" class="form-input" style="padding-inline-start: 2.75rem;" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: 1001 أو staff@realestate.sa' : 'e.g. 1001 or staff@realestate.sa' }}">
                        <i class="fa-solid fa-id-badge" style="position: absolute; inset-inline-start: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    </div>
                </div>

                <button type="submit" class="btn-luxury" style="width: 100%; height: 48px; font-size: 1rem;">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'إرسال رمز التحقق إلى بريدي الإلكتروني' : 'Send OTP to My Email' }}</span>
                </button>
            </form>

            <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 1.75rem;">
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: var(--accent-bronze); text-decoration: none; font-size: 0.9rem; font-weight: 700;">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تذكرت كلمة المرور؟ تسجيل الدخول' : 'Back to password sign-in' }}</span>
                </a>
            </div>

            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
                <p style="margin: 0; font-size: 0.82rem; color: var(--text-muted); line-height: 1.6;">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    {{ app()->getLocale() === 'ar' ? 'يتم إرسال رمز التحقق عبر خادم البريد المعتمد من شركة صفران العقارية.' : 'OTP passcodes are dispatched via the verified Safran Real Estate mail service.' }}
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
