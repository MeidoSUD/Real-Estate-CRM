@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'الملف الشخصي وإعدادات الحساب' : 'My Account Profile')
@section('page_title', app()->getLocale() === 'ar' ? 'إعدادات الحساب / الملف الشخصي' : 'Account Settings / My Profile')

@section('content')
<div style="max-width: 850px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
            {{ app()->getLocale() === 'ar' ? 'الملف الشخصي للوسيط والمستخدم' : 'My Account Profile' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'إدارة بياناتك الشخصية، رقم الاتصال، وتحديث كلمة المرور.' : 'Manage your personal real estate broker details and password.' }}
        </p>
    </div>

    <div class="luxury-card" style="padding: 2.5rem;">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-light);">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" style="width: 80px; height: 80px; border-radius: 18px; object-fit: cover; border: 2px solid var(--accent-bronze); flex-shrink: 0;">
                <div>
                    <h4 style="font-size: 1.3rem; color: var(--primary-900); font-weight: 800;">{{ $user->name }}</h4>
                    <div style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 0.35rem;">{{ $user->email }}</div>
                    <span class="badge-gold">{{ $user->role ? $user->role->name : (app()->getLocale() === 'ar' ? 'موظف' : 'Staff') }}</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الأول *' : 'First Name *' }}</label>
                    <input type="text" name="first_name" required value="{{ old('first_name', $user->first_name) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم العائلة *' : 'Last Name *' }}</label>
                    <input type="text" name="last_name" required value="{{ old('last_name', $user->last_name) }}" class="form-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المسمى الوظيفي' : 'Job Title' }}</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الجوال' : 'Phone Number' }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان المكتبي أو السكني بجدة' : 'Jeddah Office / Residential Address' }}</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-input">
            </div>

            <div style="margin-bottom: 2rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تحديث الصورة الشخصية' : 'Update Profile Photo' }}</label>
                <input type="file" name="profile_photo" accept="image/*" class="form-input">
            </div>

            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-light);">
                <i class="fa-solid fa-lock text-gold" style="margin-inline-end: 0.5rem;"></i>
                {{ app()->getLocale() === 'ar' ? 'تغيير كلمة المرور (اختياري)' : 'Change Password (Optional)' }}
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}</label>
                    <input type="password" name="current_password" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'الحالية' : 'Current password' }}">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                    <input type="password" name="new_password" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'الجديدة' : 'New password' }}">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm New Password' }}</label>
                    <input type="password" name="new_password_confirmation" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'تكرار الجديدة' : 'Repeat new password' }}">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-luxury" style="padding: 0.85rem 2.2rem;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ تعديلات الملف الشخصي' : 'Update My Profile' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
