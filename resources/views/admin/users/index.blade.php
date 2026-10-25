@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة الموظفين وفريق العمل' : 'Staff & User Management')
@section('page_title', app()->getLocale() === 'ar' ? 'فريق العمل ومستخدمي النظام CRM' : 'Staff Members & CRM Users')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
            {{ app()->getLocale() === 'ar' ? 'دليل موظفي شركة العقارات' : 'Company Staff Directory' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'إدارة أعضاء فريق التسويق، منسقي خدمة العملاء، ومسؤولي الإدارة العامة.' : 'Manage marketing team, customer service coordinators, and administrators.' }}
        </p>
    </div>

    @if(auth()->user()->hasPermission('users.create') || auth()->user()->isAdmin())
        <a href="{{ route('admin.users.create') }}" class="btn-luxury">
            <i class="fa-solid fa-user-plus"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة موظف جديد' : 'Add New Staff Member' }}</span>
        </a>
    @endif
</div>

<!-- FILTER BAR -->
<div class="luxury-card" style="padding: 1.25rem; margin-bottom: 2rem;">
    <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <div style="flex-grow: 1; min-width: 250px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'البحث بالاسم، البريد الإلكتروني، الجوال، أو المسمى الوظيفي...' : 'Search by name, email, phone, or job title...' }}">
        </div>

        <div style="width: 200px;">
            <select name="role" class="form-select">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الأدوار' : 'All Roles' }}</option>
                @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="width: 150px;">
            <select name="status" class="form-select">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الحالات' : 'All Statuses' }}</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'غير نشط' : 'Inactive' }}</option>
            </select>
        </div>

        <button type="submit" class="btn-luxury" style="padding: 0.75rem 1.25rem;">
            <i class="fa-solid fa-filter"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'تصفية' : 'Filter' }}</span>
        </button>

        @if(request()->hasAny(['search', 'role', 'status']))
            <a href="{{ route('admin.users.index') }}" class="btn-outline-luxury" style="padding: 0.75rem 1rem;">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>
</div>

<!-- USERS TABLE -->
<div class="luxury-table-container">
    <table class="luxury-table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'ar' ? 'الموظف' : 'Staff Member' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'المسمى الوظيفي' : 'Job Title' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الدور المسند' : 'Assigned Role' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'معلومات الاتصال' : 'Contact Details' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الجنس' : 'Gender' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'العنوان بجدة' : 'Address (Jeddah)' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.85rem;">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" style="width: 44px; height: 44px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--accent-bronze); flex-shrink: 0;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.4rem;">
                                    <strong style="color: var(--primary-900); font-size: 0.95rem;">{{ $user->name }}</strong>
                                    <span style="font-family: monospace; font-size: 0.72rem; background: #faf4ed; border: 1px solid var(--accent-bronze); color: var(--accent-bronze); padding: 1px 6px; border-radius: 4px; font-weight: 700;">
                                        {{ $user->employee_number ?? 'EMP-' . $user->id }}
                                    </span>
                                </div>
                                <div style="font-size: 0.78rem; color: var(--text-muted);">
                                    {{ app()->getLocale() === 'ar' ? 'انضم في ' . $user->created_at->locale('ar')->translatedFormat('F Y') : 'Joined ' . $user->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 700; color: var(--primary-800);">{{ $user->job_title ?: '—' }}</span>
                    </td>
                    <td>
                        @if($user->role)
                            @if($user->role->slug === 'admin')
                                <span class="badge-dark"><i class="fa-solid fa-crown text-gold"></i> {{ app()->getLocale() === 'ar' ? 'المدير العام' : $user->role->name }}</span>
                            @elseif($user->role->slug === 'marketing')
                                <span class="badge-gold"><i class="fa-solid fa-bullhorn"></i> {{ app()->getLocale() === 'ar' ? 'فريق التسويق' : $user->role->name }}</span>
                            @else
                                <span class="badge-info"><i class="fa-solid fa-headset"></i> {{ app()->getLocale() === 'ar' ? 'خدمة العملاء' : $user->role->name }}</span>
                            @endif
                        @else
                            <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'دون دور' : 'No Role' }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size: 0.88rem; color: var(--primary-900); font-weight: 600;">
                            <i class="fa-solid fa-envelope text-bronze" style="font-size: 0.8rem; margin-inline-end: 0.35rem;"></i>{{ $user->email }}
                        </div>
                        @if($user->phone)
                            <div style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.2rem; direction: ltr; display: inline-block;">
                                <i class="fa-solid fa-phone text-gold" style="font-size: 0.75rem; margin-inline-end: 0.35rem;"></i>{{ $user->phone }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; font-weight: 700;">
                            @if($user->gender === 'female')
                                <i class="fa-solid fa-venus" style="color: #ec4899;"></i> {{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}
                            @else
                                <i class="fa-solid fa-mars" style="color: #3b82f6;"></i> {{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}
                            @endif
                        </span>
                    </td>
                    <td style="font-size: 0.85rem; max-width: 200px; color: var(--text-muted); font-weight: 500;">
                        {{ $user->address ?: (app()->getLocale() === 'ar' ? 'جدة، المملكة' : 'Jeddah, KSA') }}
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge-success"><i class="fa-solid fa-circle" style="font-size: 0.45rem;"></i> {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                        @else
                            <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'معطل' : 'Inactive' }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            @if(auth()->user()->hasPermission('users.edit') || auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-outline-luxury btn-sm" title="{{ app()->getLocale() === 'ar' ? 'تعديل بيانات الموظف' : 'Edit' }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if((auth()->user()->hasPermission('users.delete') || auth()->user()->isAdmin()) && auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف حساب الموظف ' . $user->name . '؟' : 'Are you sure you want to delete user ' . $user->name . '?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline-luxury btn-sm" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);" title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على موظفين مطابقين للبحث.' : 'No staff members found matching your search.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem;">
    {{ $users->links() }}
</div>
@endsection
