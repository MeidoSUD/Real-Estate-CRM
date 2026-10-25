<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Authenticate staff using Email OR Employee Number + Password.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => app()->getLocale() === 'ar'
                ? 'يرجى إدخال البريد الإلكتروني أو الرقم الوظيفي.'
                : 'Please enter your email or employee number.',
            'password.required' => app()->getLocale() === 'ar'
                ? 'يرجى إدخال كلمة المرور.'
                : 'Please enter your password.',
        ]);

        $loginInput = $validated['login'];
        $user = User::findByLoginIdentifier($loginInput);

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'البيانات المدخلة غير صحيحة، يرجى التأكد من البريد الإلكتروني/الرقم الوظيفي وكلمة المرور.'
                    : 'The provided credentials do not match our records.',
            ])->onlyInput('login');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'تم تعطيل هذا الحساب. يرجى التواصل مع مسؤول النظام.'
                    : 'This account has been deactivated. Please contact the administrator.',
            ])->onlyInput('login');
        }

        $remember = $request->boolean('remember');
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', app()->getLocale() === 'ar'
                ? 'مرحباً بك مجدداً، ' . $user->name . '!'
                : 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Show Forgot Password / OTP Request Page.
     */
    public function showForgotPassword(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.forgot_password');
    }

    /**
     * Generate & Send OTP Code to the user's email.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
        ], [
            'login.required' => app()->getLocale() === 'ar'
                ? 'يرجى إدخال البريد الإلكتروني أو الرقم الوظيفي.'
                : 'Please enter your email or employee number.',
        ]);

        $user = User::findByLoginIdentifier($request->input('login'));

        if (!$user) {
            return back()->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'لم يتم العثور على أي حساب مسجل بهذا البريد الإلكتروني أو الرقم الوظيفي.'
                    : 'No account was found with this email or employee number.',
            ])->onlyInput('login');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'تم تعطيل هذا الحساب. يرجى مراجعة الإدارة.'
                    : 'This account has been deactivated. Please contact the administrator.',
            ])->onlyInput('login');
        }

        try {
            $otp = $user->generateOtp();
            Mail::to($user->email)->send(new SendOtpMail($user, $otp));

            session(['otp_user_id' => $user->id]);

            return redirect()->route('auth.otp.verify')->with('success', app()->getLocale() === 'ar'
                ? 'تم إرسال رمز التحقق (OTP) بنجاح إلى بريدك الإلكتروني.'
                : 'A 6-digit OTP code has been sent to your registered email address.');
        } catch (\Throwable $e) {
            Log::error('OTP Mail Error: ' . $e->getMessage());

            return back()->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'تعذر إرسال رمز التحقق حالياً. يرجى مراجعة إعدادات البريد أو المحاولة لاحقاً.'
                    : 'Failed to send OTP email. Please verify mailer settings or try again later.',
            ])->onlyInput('login');
        }
    }

    /**
     * Show OTP Verification & Password Reset Page.
     */
    public function showVerifyOtp(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('password.request')
                ->with('error', app()->getLocale() === 'ar'
                    ? 'يرجى طلب رمز تحقق جديد للمتابعة.'
                    : 'Please request an OTP code to continue.');
        }

        $user = User::find($userId);
        if (!$user) {
            session()->forget('otp_user_id');
            return redirect()->route('login');
        }

        // Mask email for privacy display: e.g. ad***@realestate.sa
        $parts = explode('@', $user->email);
        $namePart = $parts[0];
        $domain = $parts[1] ?? '';
        $maskedEmail = substr($namePart, 0, 2) . '••••' . (strlen($namePart) > 2 ? substr($namePart, -1) : '') . '@' . $domain;

        return view('auth.verify_otp', compact('user', 'maskedEmail'));
    }

    /**
     * Verify OTP and optionally reset password / log into CRM.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);
        if (!$user) {
            session()->forget('otp_user_id');
            return redirect()->route('login');
        }

        $request->validate([
            'otp' => ['required', 'string', 'digits:6'],
            'new_password' => ['nullable', 'string', Password::min(8), 'confirmed'],
        ], [
            'otp.required' => app()->getLocale() === 'ar' ? 'يرجى إدخال رمز التحقق المكون من 6 أرقام.' : 'Please enter the 6-digit OTP code.',
            'otp.digits' => app()->getLocale() === 'ar' ? 'رمز التحقق يجب أن يتكون من 6 أرقام.' : 'The OTP code must be 6 digits.',
            'new_password.confirmed' => app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور غير متطابق.' : 'Password confirmation does not match.',
            'new_password.min' => app()->getLocale() === 'ar' ? 'كلمة المرور يجب ألا تقل عن 8 خانات.' : 'Password must be at least 8 characters.',
        ]);

        $otpInput = $request->input('otp');

        if (!$user->verifyOtp($otpInput)) {
            return back()->withErrors([
                'otp' => app()->getLocale() === 'ar'
                    ? 'رمز التحقق غير صحيح أو انتهت صلاحيته (الصلاحية 15 دقيقة). يرجى التأكد أو طلب رمز جديد.'
                    : 'Invalid or expired OTP code (valid for 15 minutes). Please try again or request a new code.',
            ])->withInput();
        }

        // If new password is provided, update user's password
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        // Clear OTP fields
        $user->clearOtp();
        session()->forget('otp_user_id');

        // Log user into the CRM
        Auth::login($user, true);
        $request->session()->regenerate();

        $message = $request->filled('new_password')
            ? (app()->getLocale() === 'ar' ? 'تم تعيين كلمة المرور الجديدة وتسجيل دخولك بنجاح!' : 'Your new password has been set and you are now signed in!')
            : (app()->getLocale() === 'ar' ? 'تم التحقق بنجاح! مرحباً بك في لوحة تحكم صفران.' : 'OTP verified successfully! Welcome to Safran CRM.');

        return redirect()->route('admin.dashboard')->with('success', $message);
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        try {
            $otp = $user->generateOtp();
            Mail::to($user->email)->send(new SendOtpMail($user, $otp));

            return back()->with('success', app()->getLocale() === 'ar'
                ? 'تمت إعادة إرسال رمز التحقق الجديد إلى بريدك الإلكتروني.'
                : 'A fresh OTP code has been re-sent to your email.');
        } catch (\Throwable $e) {
            Log::error('Resend OTP Error: ' . $e->getMessage());

            return back()->withErrors([
                'otp' => app()->getLocale() === 'ar'
                    ? 'تعذر إعادة إرسال الرمز حالياً. يرجى المحاولة لاحقاً.'
                    : 'Could not resend OTP email right now.',
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', app()->getLocale() === 'ar'
            ? 'تم تسجيل الخروج بأمان.'
            : 'You have been safely signed out.');
    }
}
