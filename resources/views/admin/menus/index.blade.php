@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة القائمة الجانبية الديناميكية' : 'Sidebar Navigation Management')
@section('page_title', app()->getLocale() === 'ar' ? 'إعدادات النظام / القوائم الجانبية والفرعية' : 'System Settings / Dynamic Sidebar Menus')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-family: 'Playfair Display', serif;">
            {{ app()->getLocale() === 'ar' ? 'القوائم الجانبية والفرعية الديناميكية' : 'Dynamic Sidebar & Sub-Sidebar Menus' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'هيكل التنقل بالنظام مدعوم ومخزن بقاعدة البيانات. تتكيف القوائم تلقائياً مع دور المستخدم وصلاحياته المحددة.' : 'Database-driven navigation structure. Menus automatically adapt to the user\'s assigned role and permissions.' }}
        </p>
    </div>
</div>

<!-- SYSTEM NAVIGATION TABS (SIDEBAR MENUS VS DROPDOWN OPTIONS) -->
<div style="display: flex; gap: 0.75rem; margin-bottom: 1.75rem;">
    <a href="{{ route('admin.menus.index') }}" style="text-decoration: none;">
        <div style="padding: 0.65rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--accent-bronze), var(--accent-gold)); color: #fff; box-shadow: 0 4px 12px rgba(163, 105, 57, 0.25);">
            <i class="fa-solid fa-bars-staggered"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'القوائم الجانبية والفرعية' : 'Sidebar Navigation Menus' }}</span>
        </div>
    </a>

    <a href="{{ route('admin.dropdown-options.index') }}" style="text-decoration: none;">
        <div style="padding: 0.65rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: var(--primary-900); border: 1px solid var(--border-light);">
            <i class="fa-solid fa-list-ul text-gold"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'خيارات القوائم المنسدلة للعروض (10 أقسام)' : 'Offer Dropdown Options (10 Catalogs)' }}</span>
        </div>
    </a>
</div>

<div class="luxury-card" style="padding: 2rem;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @foreach($menus as $menu)
            <div style="border: 1px solid var(--border-light); border-radius: var(--radius-md); overflow: hidden; background: #ffffff;">
                <!-- MAIN MENU ROW -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; background: var(--primary-50); border-bottom: 1px solid var(--border-light);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span class="badge-dark" style="font-size: 0.72rem;">
                            {{ app()->getLocale() === 'ar' ? 'الترتيب #' . $menu->order : 'Order #' . $menu->order }}
                        </span>
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: var(--accent-bronze); border: 1px solid var(--border-light);">
                            <i class="fa-solid fa-{{ $menu->icon ?: 'folder' }}"></i>
                        </div>
                        <div>
                            <strong style="color: var(--primary-900); font-size: 1.05rem;">
                                {{ app()->getLocale() === 'ar' && $menu->title_ar ? $menu->title_ar : $menu->title }}
                            </strong>
                            @if(app()->getLocale() === 'ar' && $menu->title_ar)
                                <span style="font-size: 0.85rem; color: var(--text-muted); margin-inline-start: 0.5rem; direction: ltr; display: inline-block;">({{ $menu->title }})</span>
                            @elseif($menu->title_ar)
                                <span style="font-size: 0.85rem; color: var(--text-muted); margin-inline-start: 0.5rem;">({{ $menu->title_ar }})</span>
                            @endif
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.15rem; direction: ltr; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">
                                Route: <code>{{ $menu->route ?: 'Parent Dropdown' }}</code> •
                                Required Permission: <code>{{ $menu->permission_slug ?: 'Any Authenticated' }}</code>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($menu->is_active)
                            <span class="badge-success">{{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                        @else
                            <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'مخفي' : 'Hidden' }}</span>
                        @endif

                        <form action="{{ route('admin.menus.toggle', $menu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-outline-luxury btn-sm">
                                @if($menu->is_active)
                                    {{ app()->getLocale() === 'ar' ? 'تعطيل' : 'Deactivate' }}
                                @else
                                    {{ app()->getLocale() === 'ar' ? 'تفعيل' : 'Activate' }}
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SUB-MENUS IF ANY -->
                @if($menu->allSubMenus->isNotEmpty())
                    <div style="padding: 0.75rem 1.25rem 0.75rem {{ app()->getLocale() === 'ar' ? '1.25rem' : '3.5rem' }}; {{ app()->getLocale() === 'ar' ? 'padding-right: 3.5rem;' : '' }} background: #ffffff;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">
                            {{ app()->getLocale() === 'ar' ? 'عناصر القائمة الفرعية:' : 'Sub-Sidebar Menu Items:' }}
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @foreach($menu->allSubMenus as $sub)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0.85rem; background: var(--bg-cream); border-radius: 8px; border: 1px solid var(--border-light);">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <i class="fa-solid fa-turn-up" style="transform: {{ app()->getLocale() === 'ar' ? 'rotate(-90deg)' : 'rotate(90deg)' }}; color: var(--accent-bronze); font-size: 0.75rem;"></i>
                                        <span style="font-weight: 600; font-size: 0.9rem; color: var(--primary-900);">
                                            {{ app()->getLocale() === 'ar' && $sub->title_ar ? $sub->title_ar : $sub->title }}
                                        </span>
                                        <code style="font-size: 0.78rem; color: var(--text-muted); direction: ltr;">{{ $sub->route }}</code>
                                        @if($sub->permission_slug)
                                            <span class="badge-gold" style="font-size: 0.68rem; padding: 0.1rem 0.4rem; direction: ltr;">
                                                Requires: {{ $sub->permission_slug }}
                                            </span>
                                        @endif
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        @if($sub->is_active)
                                            <span class="badge-success" style="font-size: 0.7rem;">{{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                                        @else
                                            <span class="badge-warning" style="font-size: 0.7rem;">{{ app()->getLocale() === 'ar' ? 'مخفي' : 'Hidden' }}</span>
                                        @endif

                                        <form action="{{ route('admin.submenus.toggle', $sub->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-outline-luxury btn-sm" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;">
                                                @if($sub->is_active)
                                                    {{ app()->getLocale() === 'ar' ? 'تعطيل' : 'Disable' }}
                                                @else
                                                    {{ app()->getLocale() === 'ar' ? 'تفعيل' : 'Enable' }}
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
