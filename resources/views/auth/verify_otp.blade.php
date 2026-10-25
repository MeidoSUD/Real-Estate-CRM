<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'ar' ? 'إدخال رمز التحقق OTP | صفران العقارية' : 'Verify OTP Code | Safran Real Estate' }}</title>
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
            max-width: 460px;
        }
        .otp-input-field {
            font-size: 2rem;
            letter-spacing: 0.5rem;
            text-align: center;
            font-family: monospace;
            font-weight: 700;
            color: var(--primary-950);
            background: #faf8f5;
            border: 2px solid #e2d9cf;
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.2s ease;
        }
        .otp-input-field:focus {
            border-color: var(--accent-bronze);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(163, 105, 57, 0.15);
            outline: none;
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
            <a href="{{ route('password.request') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--accent-gold-light); font-size: 0.92rem; font-weight: 700;">
                <i class="fa-solid fa-arrow-right"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'طلب رمز آخر أو تغيير البريد' : 'Change account / request another code' }}</span>
            </a>
            <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" style="color: #ffffff; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.25); padding: 0.35rem 0.75rem; border-radius: 6px;">
                <i class="fa-solid fa-globe"></i> {{ app()->getLocale() === 'ar' ? 'English' : 'عربي' }}
            </a>
        </div>

        <div style="max-width: 520px;">
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(200, 155, 83, 0.2); border: 1px solid var(--accent-gold); padding: 0.4rem 1rem; border-radius: 999px; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-shield-check text-gold"></i>
                <span style="color: var(--accent-gold-light); font-size: 0.82rem; font-weight: 700; letter-spacing: 0.5px;">
                    {{ app()->getLocale() === 'ar' ? 'خطوة التحقق من الهوية' : 'Identity Verification' }}
                </span>
            </div>

            <h1 style="font-size: 2.3rem; font-weight: 800; line-height: 1.3; margin-bottom: 1rem; color: #ffffff;">
                {{ app()->getLocale() === 'ar' ? 'أدخل رمز التحقق (OTP) لإتمام الدخول' : 'Enter One-Time Passcode (OTP)' }}
            </h1>

            <p style="color: #cbd5e1; font-size: 1rem; line-height: 1.7; margin-bottom: 2rem;">
                {{ app()->getLocale() === 'ar' ? 'تم إرسال رمز سري مؤلف من 6 أرقام إلى بريدك الإلكتروني المسجل. الرمز صالح لمدة 15 دقيقة.' : 'A 6-digit confidential passcode has been dispatched to your email. It remains active for 15 minutes.' }}
            </p>
        </div>

        <div style="font-size: 0.8rem; color: #94a3b8; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.5rem;">
            &copy; {{ date('Y') }} {{ app()->getLocale() === 'ar' ? 'شركة عقارات صفران. جميع الحقوق محفوظة.' : 'Safran Real Estate. All rights reserved.' }}
        </div>
    </div>

    <!-- FORM SIDE -->
    <div class="login-form-side">
        <div class="login-box">
            
            <div style="text-align: center; margin-bottom: 1.75rem;">
                <div style="width: 68px; height: 68px; margin: 0 auto 1.25rem; background: #faf4ed; border: 1px solid rgba(163, 105, 57, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-key text-gold" style="font-size: 1.8rem;"></i>
                </div>
                <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--primary-900); margin-bottom: 0.35rem;">
                    {{ app()->getLocale() === 'ar' ? 'التحقق وتسجيل الدخول' : 'Verify & Enter' }}
                </h2>
                
                <!-- Account Badge -->
                <div style="display: inline-block; background: var(--bg-cream); border: 1px solid var(--border-light); border-radius: 10px; padding: 0.6rem 1rem; margin-top: 0.5rem; font-size: 0.85rem; color: var(--primary-900);">
                    <i class="fa-solid fa-user-circle text-gold"></i>
                    <strong>{{ $user->name }}</strong>
                    <span style="color: var(--text-muted); margin: 0 4px;">|</span>
                    <span style="font-family: monospace; color: var(--accent-bronze); font-weight: 700;">{{ $user->employee_number ?? 'EMP-' . $user->id }}</span>
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 3px;">
                        <i class="fa-solid fa-envelope"></i> {{ $maskedEmail }}
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 0.85rem 1rem; border-radius: var(--radius-md); font-size: 0.88rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
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

            <form action="{{ route('auth.otp.verify.post') }}" method="POST">
                @csrf

                <!-- OTP Input -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="text-align: center; display: block; font-size: 0.95rem; font-weight: 700; color: var(--primary-900); margin-bottom: 0.65rem;">
                        {{ app()->getLocale() === 'ar' ? 'أدخل رمز التحقق (6 أرقام)' : 'Enter 6-Digit Passcode' }}
                    </label>
                    <input type="text" id="otp" name="otp" required autofocus maxlength="6" inputmode="numeric" autocomplete="one-time-code" class="otp-input-field" placeholder="••••••">
                    <span style="display: block; text-align: center; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.4rem;">
                        {{ app()->getLocale() === 'ar' ? 'تفقد بريدك الوارد ومجلد الرسائل غير المرغوب فيها (Spam)' : 'Check inbox and spam folders' }}
                    </span>
                </div>

                <!-- Reset Password Option (Collapsible or Optional) -->
                <div style="background: #faf8f5; border: 1px solid var(--border-light); border-radius: var(--radius-md); padding: 1rem 1.15rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span style="font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">
                            <i class="fa-solid fa-lock text-gold"></i>
                            {{ app()->getLocale() === 'ar' ? 'تعيين كلمة مرور جديدة (اختياري)' : 'Set New Password (Optional)' }}
                        </span>
                        <span style="font-size: 0.75rem; color: var(--text-muted); background: #eee5db; padding: 2px 8px; border-radius: 4px;">
                            {{ app()->getLocale() === 'ar' ? 'إذا رغبت بتغييرها' : 'If desired' }}
                        </span>
                    </div>

                    <div style="margin-bottom: 0.85rem;">
                        <input type="password" name="new_password" class="form-input" style="font-size: 0.9rem;" placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة (8 خانات على الأقل)' : 'New password (min 8 chars)' }}">
                    </div>

                    <div>
                        <input type="password" name="new_password_confirmation" class="form-input" style="font-size: 0.9rem;" placeholder="{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور الجديدة' : 'Confirm new password' }}">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-luxury" style="width: 100%; height: 48px; font-size: 1rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'التحقق والدخول إلى النظام' : 'Verify & Enter CRM' }}</span>
                </button>
            </form>

            <!-- Resend OTP Form -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                <form action="{{ route('auth.otp.resend') }}" method="POST" id="resendForm">
                    @csrf
                    <button type="submit" id="resendBtn" style="background: none; border: none; padding: 0; color: var(--accent-bronze); font-size: 0.86rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span id="resendText">{{ app()->getLocale() === 'ar' ? 'إعادة إرسال رمز جديد' : 'Resend OTP' }}</span>
                    </button>
                </form>

                <a href="{{ route('login') }}" style="color: var(--text-muted); font-size: 0.86rem; text-decoration: none;">
                    {{ app()->getLocale() === 'ar' ? 'العودة لتسجيل الدخول' : 'Back to login' }}
                </a>
            </div>

            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
                <p style="margin: 0; font-size: 0.82rem; color: var(--text-muted); line-height: 1.6;">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    {{ app()->getLocale() === 'ar' ? 'خوادم شركة عقارات صفران محمية بأحدث بروتوكولات الأمان والتشفير.' : 'Protected by Safran Real Estate modern security protocols.' }}
                </p>
            </div>

        </div>
    </div>
</div>

<script>
// Auto-focus and numeric only filter for OTP
const otpInput = document.getElementById('otp');
if (otpInput) {
    otpInput.addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });
}

// 60-second countdown for Resend button
let countdown = 60;
const resendBtn = document.getElementById('resendBtn');
const resendText = document.getElementById('resendText');
const originalText = resendText.innerText;

resendBtn.disabled = true;
resendBtn.style.opacity = '0.6';
resendBtn.style.cursor = 'not-allowed';

const timer = setInterval(() => {
    countdown--;
    if (countdown > 0) {
        resendText.innerText = `${originalText} (${countdown}s)`;
    } else {
        clearInterval(timer);
        resendBtn.disabled = false;
        resendBtn.style.opacity = '1';
        resendBtn.style.cursor = 'pointer';
        resendText.innerText = originalText;
    }
}, 1000);
</script>

</body>
</html>
