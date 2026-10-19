@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'مصفوفة الأدوار والصلاحيات' : 'Roles & Permissions Matrix')
@section('page_title', app()->getLocale() === 'ar' ? 'التحكم بالوصول / الأدوار ومصفوفة الصلاحيات' : 'Access Control / Roles & Permissions')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
            {{ app()->getLocale() === 'ar' ? 'أدوار النظام وفئات الصلاحيات' : 'Roles & Permission Categories' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'إسناد صلاحيات دقيقة ومخصصة لفريق التسويق، خدمة العملاء، ومسؤولي النظام.' : 'Assign granular permissions to roles: Marketing Team, Customer Service, and Admins.' }}
        </p>
    </div>

    @if(auth()->user()->hasPermission('roles.create') || auth()->user()->isAdmin())
        <a href="{{ route('admin.roles.create') }}" class="btn-luxury">
            <i class="fa-solid fa-shield-plus"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة دور جديد' : 'Create New Role' }}</span>
        </a>
    @endif
</div>

<!-- ROLES GRID -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    @foreach($roles as $role)
        <div class="luxury-card" style="padding: 1.75rem; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-size: 1.35rem; color: var(--primary-900); font-weight: 800;">
                            @if(app()->getLocale() === 'ar')
                                @if($role->slug === 'admin')
                                    المدير العام
                                @elseif($role->slug === 'marketing')
                                    فريق التسويق
                                @elseif($role->slug === 'customer-service')
                                    خدمة العملاء
                                @else
                                    {{ $role->name }}
                                @endif
                            @else
                                {{ $role->name }}
                            @endif
                        </h4>
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-family: monospace;">slug: {{ $role->slug }}</span>
                    </div>
                    @if($role->is_system)
                        <span class="badge-dark"><i class="fa-solid fa-lock text-gold"></i> {{ app()->getLocale() === 'ar' ? 'أساسي' : 'System' }}</span>
                    @else
                        <span class="badge-gold">{{ app()->getLocale() === 'ar' ? 'مخصص' : 'Custom' }}</span>
                    @endif
                </div>

                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.5rem;">
                    {{ $role->description }}
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div style="background: var(--primary-50); padding: 0.75rem; border-radius: 10px; text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 900; color: var(--primary-900);">{{ $role->users_count }}</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'موظفين بهذا الدور' : 'Staff Users' }}</div>
                    </div>
                    <div style="background: var(--primary-50); padding: 0.75rem; border-radius: 10px; text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 900; color: var(--accent-bronze);">
                            {{ $role->slug === 'admin' ? (app()->getLocale() === 'ar' ? 'شامل' : 'All') : $role->permissions->count() }}
                        </div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'صلاحيات ممنوحة' : 'Permissions' }}</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; border-top: 1px solid var(--border-light); padding-top: 1.25rem;">
                @if(auth()->user()->hasPermission('roles.edit') || auth()->user()->isAdmin())
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn-luxury" style="flex-grow: 1; text-align: center; font-size: 0.88rem; padding: 0.6rem 1rem;">
                        <i class="fa-solid fa-sliders"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'تعديل الصلاحيات' : 'Configure Permissions' }}</span>
                    </a>
                @endif

                @if(! $role->is_system && (auth()->user()->hasPermission('roles.delete') || auth()->user()->isAdmin()))
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا الدور؟' : 'Delete this role?' }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline-luxury" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3); padding: 0.6rem 0.85rem;" title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- PERMISSION CATEGORIES REFERENCE OVERVIEW -->
<div class="luxury-card" style="padding: 2rem;">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.35rem; color: var(--primary-900); font-weight: 800;">
            <i class="fa-solid fa-list-check text-gold" style="margin-inline-end: 0.5rem;"></i>
            {{ app()->getLocale() === 'ar' ? 'فئات ومستويات الصلاحيات في النظام' : 'Permission Categories & Scope Breakdown' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.88rem;">
            {{ app()->getLocale() === 'ar' ? 'دليل الصلاحيات الموزعة على فئات العمل التخصصية.' : 'All system permissions categorized by functional module.' }}
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        @foreach($categories as $cat)
            @php
                $catTitle = (app()->getLocale() === 'ar' && !empty($cat->name_ar)) ? $cat->name_ar : $cat->name;
            @endphp
            <div style="background: var(--primary-50); border-radius: var(--radius-md); padding: 1.25rem; border: 1px solid var(--border-light);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-{{ $cat->icon }} text-bronze"></i>
                        <strong style="color: var(--primary-900); font-size: 1.05rem;">{{ $catTitle }}</strong>
                    </div>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">
                        {{ $cat->permissions->count() }} {{ app()->getLocale() === 'ar' ? 'صلاحيات' : 'permissions' }}
                    </span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    @foreach($cat->permissions as $p)
                        @php
                            $pTitle = (app()->getLocale() === 'ar' && !empty($p->name_ar)) ? $p->name_ar : $p->name;
                        @endphp
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding: 0.4rem 0.65rem; background: #ffffff; border-radius: 6px; border: 1px solid rgba(163, 105, 57, 0.1);">
                            <span style="font-weight: 700; color: var(--primary-800);">{{ $pTitle }}</span>
                            <code style="color: var(--accent-bronze); font-size: 0.78rem; direction: ltr;">{{ $p->slug }}</code>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
