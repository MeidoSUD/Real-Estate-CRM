@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة موظف جديد' : 'Add New Staff Member')
@section('page_title', app()->getLocale() === 'ar' ? 'إدارة الموظفين / إضافة حساب جديد' : 'Staff Management / Add User')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'إضافة موظف جديد للمنظومة' : 'Add New Staff Member' }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                {{ app()->getLocale() === 'ar' ? 'إنشاء حساب لفريق التسويق أو خدمة العملاء أو مسؤولي الإدارة وتحديد صلاحياتهم.' : 'Provision a new account for the Marketing, Customer Service, or Admin team.' }}
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-outline-luxury">
            <i class="fa-solid fa-arrow-right"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'العودة لقائمة الموظفين' : 'Back to Staff List' }}</span>
        </a>
    </div>

    <div class="luxury-card" style="padding: 2.5rem;">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.25rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-light);">
                <i class="fa-solid fa-user-circle text-gold" style="margin-inline-end: 0.5rem;"></i>
                {{ app()->getLocale() === 'ar' ? 'البيانات الشخصية ومعلومات الدخول' : 'Personal & Login Information' }}
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الأول *' : 'First Name *' }}</label>
                    <input type="text" name="first_name" required value="{{ old('first_name') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: سلطان' : 'e.g. Sultan' }}">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم العائلة / اللقب *' : 'Last Name *' }}</label>
                    <input type="text" name="last_name" required value="{{ old('last_name') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: الغامدي' : 'e.g. Al-Ghamdi' }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1.2fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الرقم الوظيفي (اختياري)' : 'Employee ID (Optional)' }}</label>
                    <input type="text" name="employee_number" value="{{ old('employee_number') }}" class="form-input" placeholder="EMP-1004">
                    <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 2px;">{{ app()->getLocale() === 'ar' ? 'يُولد تلقائياً إن تُرك فارغاً' : 'Auto-generated if left blank' }}</span>
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني (لتسجيل الدخول وOTP) *' : 'Email Address (Login & OTP) *' }}</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="form-input" placeholder="name@realestate.sa">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور *' : 'Password *' }}</label>
                    <input type="password" name="password" required class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? '8 خانات كحد أدنى' : 'Minimum 8 characters' }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المسمى الوظيفي' : 'Job Title' }}</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: أخصائي تسويق عقاري، منسق خدمة عملاء' : 'e.g. Marketing Specialist, Customer Care Lead' }}">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الجوال (المملكة)' : 'Phone Number' }}</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+966 5X XXX XXXX">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الجنس *' : 'Gender *' }}</label>
                    <select name="gender" required class="form-select">
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'إسناد الدور الوظيفي والصلاحيات *' : 'Assign Role *' }}</label>
                    <select name="role_id" required class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? 'اختر الدور الوظيفي' : 'Select Role' }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }} ({{ $role->description }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان السكني أو الفرع بجدة' : 'Address in Jeddah' }}</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: حي الروضة، طريق الأمير سعود الفيصل، جدة' : 'e.g. Al-Rawdah District, Jeddah' }}">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الصورة الشخصية (اختياري)' : 'Profile Photo' }}</label>
                <input type="file" name="profile_photo" accept="image/*" class="form-input">
                <span style="font-size: 0.8rem; color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'الامتدادات المقبولة: JPEG, PNG, WEBP (الحجم الأقصى: 3MB)' : 'Accepted formats: JPEG, PNG, WEBP (Max: 3MB)' }}</span>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: var(--accent-bronze); width: 18px; height: 18px;">
                    <span style="font-weight: 700; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'حساب نشط ومفعل (السماح للموظف بتسجيل الدخول للنظام)' : 'Active Account (Allow user to log in)' }}
                    </span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.users.index') }}" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</a>
                <button type="submit" class="btn-luxury" style="padding: 0.85rem 2rem;">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'إنشاء حساب الموظف' : 'Create Staff Member' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
