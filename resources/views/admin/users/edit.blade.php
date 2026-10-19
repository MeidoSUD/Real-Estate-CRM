@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل بيانات الموظف' : 'Edit Staff Member')
@section('page_title', app()->getLocale() === 'ar' ? 'إدارة الموظفين / تعديل الحساب' : 'Staff Management / Edit User')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'تعديل بيانات الموظف: ' . $user->name : 'Edit Staff: ' . $user->name }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                {{ app()->getLocale() === 'ar' ? 'تحديث الدور المسند، بيانات الاتصال، أو حالة تفعيل الحساب.' : 'Update contact info, role assignments, or active status.' }}
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-outline-luxury">
            <i class="fa-solid fa-arrow-right"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'العودة لقائمة الموظفين' : 'Back to Staff List' }}</span>
        </a>
    </div>

    <div class="luxury-card" style="padding: 2.5rem;">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-light);">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" style="width: 72px; height: 72px; border-radius: 16px; object-fit: cover; border: 2px solid var(--accent-bronze); flex-shrink: 0;">
                <div>
                    <h4 style="font-size: 1.25rem; color: var(--primary-900); font-weight: 800;">{{ $user->name }}</h4>
                    <span class="badge-gold">{{ $user->role ? $user->role->name : (app()->getLocale() === 'ar' ? 'دون دور' : 'No Role') }}</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الأول *' : 'First Name *' }}</label>
                    <input type="text" name="first_name" required value="{{ old('first_name', $user->first_name) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم العائلة / اللقب *' : 'Last Name *' }}</label>
                    <input type="text" name="last_name" required value="{{ old('last_name', $user->last_name) }}" class="form-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني *' : 'Email Address *' }}</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تعيين كلمة مرور جديدة (اتركه فارغاً للإبقاء على الحالية)' : 'Reset Password (Leave blank to keep)' }}</label>
                    <input type="password" name="password" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة مرور جديدة (اختياري)' : 'New password (optional)' }}">
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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الجنس *' : 'Gender *' }}</label>
                    <select name="gender" required class="form-select">
                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}</option>
                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الدور الوظيفي المسند *' : 'Assigned Role *' }}</label>
                    <select name="role_id" required class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان بمدينة جدة' : 'Address in Jeddah' }}</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-input">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تحديث الصورة الشخصية' : 'Change Profile Photo' }}</label>
                <input type="file" name="profile_photo" accept="image/*" class="form-input">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} style="accent-color: var(--accent-bronze); width: 18px; height: 18px;">
                    <span style="font-weight: 700; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'حساب نشط ومفعل' : 'Active Account' }}
                    </span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.users.index') }}" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</a>
                <button type="submit" class="btn-luxury" style="padding: 0.85rem 2rem;">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
