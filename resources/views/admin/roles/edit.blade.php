@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل صلاحيات الدور' : 'Edit Role Permissions')
@section('page_title', app()->getLocale() === 'ar' ? 'التحكم بالوصول / تعديل صلاحيات الدور' : 'Access Control / Edit Role')

@section('content')
<div style="max-width: 960px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'تعديل صلاحيات الدور: ' . $role->name : 'Edit Permissions: ' . $role->name }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                {{ app()->getLocale() === 'ar' ? 'تعديل وتحديث مصفوفة الصلاحيات الممنوحة للمستخدمين المسندين لهذا الدور.' : 'Modify access privileges and capabilities assigned to this role.' }}
            </p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn-outline-luxury">
            <i class="fa-solid fa-arrow-right"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'العودة لقائمة الأدوار' : 'Back to Roles' }}</span>
        </a>
    </div>

    <div class="luxury-card" style="padding: 2.5rem;">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم الدور الوظيفي *' : 'Role Name *' }}</label>
                    <input type="text" name="name" required value="{{ old('name', $role->name) }}" class="form-input">
                    @if($role->is_system)
                        <span style="font-size: 0.78rem; color: var(--accent-bronze); margin-top: 0.25rem; display: block; font-weight: 600;">
                            <i class="fa-solid fa-shield"></i> {{ app()->getLocale() === 'ar' ? 'دور أساسي محمي بالنظام' : 'Protected Core Role' }}
                        </span>
                    @endif
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الوصف' : 'Description' }}</label>
                    <input type="text" name="description" value="{{ old('description', $role->description) }}" class="form-input">
                </div>
            </div>

            <h4 style="font-size: 1.2rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-light);">
                <i class="fa-solid fa-layer-group text-gold" style="margin-inline-end: 0.5rem;"></i>
                {{ app()->getLocale() === 'ar' ? 'الصلاحيات حسب الفئات الوظيفية' : 'Permissions by Functional Category' }}
            </h4>

            @if($role->slug === 'admin')
                <div class="alert-success" style="margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-crown text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'يمتلك دور المدير العام صلاحيات كاملة وشاملة لكافة أقسام النظام الحالية والمستقبلية.' : 'The Administrator role holds universal access across all current and future system modules.' }}</span>
                </div>
            @endif

            <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2.5rem;">
                @foreach($categories as $category)
                    @php
                        $catTitle = (app()->getLocale() === 'ar' && !empty($category->name_ar)) ? $category->name_ar : $category->name;
                    @endphp
                    <div style="background: var(--bg-cream); border-radius: var(--radius-md); border: 1px solid var(--border-light); padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px dashed var(--border-light); padding-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <i class="fa-solid fa-{{ $category->icon }} text-bronze" style="font-size: 1.1rem;"></i>
                                <strong style="color: var(--primary-900); font-size: 1.1rem;">{{ $catTitle }}</strong>
                            </div>
                            <button type="button" class="btn-outline-luxury btn-sm" onclick="toggleCategory('cat-{{ $category->id }}')">
                                {{ app()->getLocale() === 'ar' ? 'تحديد / إلغاء الفئة' : 'Toggle Category' }}
                            </button>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;" id="cat-{{ $category->id }}">
                            @foreach($category->permissions as $permission)
                                @php
                                    $isChecked = in_array($permission->id, $rolePermissionIds) || $role->slug === 'admin';
                                    $pTitle = (app()->getLocale() === 'ar' && !empty($permission->name_ar)) ? $permission->name_ar : $permission->name;
                                @endphp
                                <label style="display: flex; align-items: flex-start; gap: 0.65rem; background: #ffffff; padding: 0.85rem; border-radius: 10px; border: 1px solid var(--border-light); cursor: pointer;">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $isChecked ? 'checked' : '' }} class="perm-checkbox" style="margin-top: 0.25rem; accent-color: var(--accent-bronze); width: 17px; height: 17px;">
                                    <div>
                                        <div style="font-weight: 700; color: var(--primary-900); font-size: 0.95rem;">{{ $pTitle }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">{{ $permission->description }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.roles.index') }}" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</a>
                <button type="submit" class="btn-luxury" style="padding: 0.85rem 2rem;">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ الصلاحيات المحدثة' : 'Update Role Permissions' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCategory(containerId) {
    const container = document.getElementById(containerId);
    const checkboxes = container.querySelectorAll('.perm-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endsection
