@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة خيارات القوائم المنسدلة' : 'Dropdown Options Control')
@section('page_title', app()->getLocale() === 'ar' ? 'إعدادات النظام / خيارات القوائم المنسدلة' : 'System Settings / Dropdown Options Control')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-family: 'Playfair Display', serif;">
            {{ app()->getLocale() === 'ar' ? 'التحكم في خيارات القوائم المنسدلة' : 'Dropdown Menus & Lookups Control' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'إدارة خيارات نموذج إضافة العروض العقارية والبحث باللغتين العربية والإنجليزية ديناميكياً.' : 'Manage real estate dropdown values in both Arabic and English without code changes.' }}
        </p>
    </div>

    <button type="button" class="btn-luxury" onclick="openAddModal()">
        <i class="fa-solid fa-plus"></i>
        <span>{{ app()->getLocale() === 'ar' ? 'إضافة خيار جديد' : 'Add New Option' }}</span>
    </button>
</div>

<!-- SYSTEM NAVIGATION TABS (SIDEBAR MENUS VS DROPDOWN OPTIONS) -->
<div style="display: flex; gap: 0.75rem; margin-bottom: 1.75rem;">
    <a href="{{ route('admin.menus.index') }}" style="text-decoration: none;">
        <div style="padding: 0.65rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: var(--primary-900); border: 1px solid var(--border-light);">
            <i class="fa-solid fa-bars-staggered text-gold"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'القوائم الجانبية والفرعية' : 'Sidebar Navigation Menus' }}</span>
        </div>
    </a>

    <a href="{{ route('admin.dropdown-options.index') }}" style="text-decoration: none;">
        <div style="padding: 0.65rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--accent-bronze), var(--accent-gold)); color: #fff; box-shadow: 0 4px 12px rgba(163, 105, 57, 0.25);">
            <i class="fa-solid fa-list-ul"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'خيارات القوائم المنسدلة للعروض (10 أقسام)' : 'Offer Dropdown Options (10 Catalogs)' }}</span>
        </div>
    </a>
</div>

<!-- CATEGORY TABS - WRAP IN SIZE OF SCREEN -->
<div style="display: flex; flex-wrap: wrap; gap: 0.5rem; padding-bottom: 1rem; margin-bottom: 1.5rem; width: 100%;">
    @foreach($typesCatalog as $key => $meta)
        @php
            $isSelected = $selectedType === $key;
            $count = $countsByType[$key] ?? 0;
            $title = app()->getLocale() === 'ar' ? $meta['name_ar'] : $meta['name_en'];
        @endphp
        <a href="{{ route('admin.dropdown-options.index', ['type' => $key]) }}" style="text-decoration: none; flex-shrink: 0;">
            <div style="padding: 0.65rem 1rem; border-radius: 12px; font-size: 0.88rem; font-weight: 700; display: flex; align-items: center; gap: 0.65rem; transition: all 0.2s ease; {{ $isSelected ? 'background: linear-gradient(135deg, var(--accent-bronze), var(--accent-gold)); color: #fff; box-shadow: 0 4px 15px rgba(163, 105, 57, 0.35);' : 'background: #fff; color: var(--primary-800); border: 1px solid var(--border-light);' }}">
                <i class="fa-solid fa-{{ $meta['icon'] }}"></i>
                <span>{{ $title }}</span>
                <span style="font-size: 0.72rem; padding: 0.15rem 0.45rem; border-radius: 999px; {{ $isSelected ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: var(--primary-50); color: var(--accent-bronze);' }}">
                    {{ $count }}
                </span>
            </div>
        </a>
    @endforeach
</div>

<!-- CURRENT CATEGORY OVERVIEW & TABLE -->
<div class="luxury-card" style="padding: 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
        <div>
            <h4 style="font-size: 1.2rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-{{ $typesCatalog[$selectedType]['icon'] }} text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? $typesCatalog[$selectedType]['name_ar'] : $typesCatalog[$selectedType]['name_en'] }}</span>
                <span style="font-size: 0.8rem; font-weight: 500; color: var(--text-muted);">({{ $selectedType }})</span>
            </h4>
        </div>

        <span class="badge-gold">
            {{ count($options) }} {{ app()->getLocale() === 'ar' ? 'خيارات متاحة' : 'options found' }}
        </span>
    </div>

    <div class="luxury-table-container">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th style="width: 70px;">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاسم بالعربية' : 'Arabic Name' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاسم بالإنجليزية' : 'English Name' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'المعرف (Code / Value)' : 'Code / Value' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th style="width: 180px;">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($options as $opt)
                    <tr>
                        <td style="font-weight: 700; color: var(--text-muted); text-align: center;">
                            #{{ $opt->order }}
                        </td>
                        <td>
                            <strong style="color: var(--primary-900); font-size: 0.95rem;">{{ $opt->name_ar }}</strong>
                        </td>
                        <td>
                            <span style="color: var(--text-main); font-size: 0.92rem; font-weight: 600;">{{ $opt->name_en }}</span>
                        </td>
                        <td>
                            <code style="font-size: 0.8rem; background: var(--primary-50); padding: 0.2rem 0.5rem; border-radius: 6px; color: var(--accent-bronze);">
                                {{ $opt->value ?: '-' }}
                            </code>
                        </td>
                        <td>
                            @if($opt->is_active)
                                <span class="badge-success">{{ app()->getLocale() === 'ar' ? 'مفعل' : 'Active' }}</span>
                            @else
                                <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'معطل' : 'Disabled' }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <!-- TOGGLE -->
                                <form action="{{ route('admin.dropdown-options.toggle', $opt->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-outline-luxury btn-sm" title="{{ $opt->is_active ? 'تعطيل' : 'تفعيل' }}">
                                        <i class="fa-solid fa-{{ $opt->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                <!-- EDIT -->
                                <button type="button" class="btn-outline-luxury btn-sm" onclick="openEditModal({{ $opt->id }}, '{{ addslashes($opt->name_ar) }}', '{{ addslashes($opt->name_en) }}', '{{ addslashes($opt->value) }}', {{ $opt->order }})" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('admin.dropdown-options.destroy', $opt->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا الخيار؟' : 'Are you sure you want to delete this option?' }}');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline-luxury btn-sm" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);" title="حذف">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد خيارات مسجلة لهذا القسم حالياً.' : 'No options found in this category yet.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ADD MODAL -->
<div id="addModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="luxury-card" style="max-width: 520px; width: 100%; padding: 2rem; background: #ffffff; position: relative;">
        <button type="button" onclick="closeAddModal()" style="position: absolute; top: 1.25rem; {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1.25rem; background: none; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 1.35rem; color: var(--primary-900); margin-bottom: 0.25rem; font-family: 'Playfair Display', serif;">
            {{ app()->getLocale() === 'ar' ? 'إضافة خيار جديد إلى: ' . $typesCatalog[$selectedType]['name_ar'] : 'Add Option to: ' . $typesCatalog[$selectedType]['name_en'] }}
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            {{ app()->getLocale() === 'ar' ? 'سيتاح هذا الخيار تلقائياً في القوائم المنسدلة لجميع موظفي التسويق.' : 'This option will immediately appear in real estate forms.' }}
        </p>

        <form action="{{ route('admin.dropdown-options.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $selectedType }}">

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم باللغة العربية *' : 'Name in Arabic *' }}</label>
                <input type="text" name="name_ar" required class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: فيلا مودرن ذكية' : 'e.g. Smart Modern Villa' }}">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم باللغة الإنجليزية *' : 'Name in English *' }}</label>
                <input type="text" name="name_en" required class="form-input" placeholder="e.g. Smart Modern Villa">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المعرف (Code)' : 'Value / Code' }}</label>
                    <input type="text" name="value" class="form-input" placeholder="e.g. smart_villa">
                    <span style="font-size: 0.72rem; color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'اختياري (ينشأ تلقائياً إذا ترك فارغاً)' : 'Optional (auto-generated if empty)' }}</span>
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Display Order' }}</label>
                    <input type="number" name="order" value="{{ count($options) + 1 }}" class="form-input">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeAddModal()" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn-luxury">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ الخيار' : 'Save Option' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="luxury-card" style="max-width: 520px; width: 100%; padding: 2rem; background: #ffffff; position: relative;">
        <button type="button" onclick="closeEditModal()" style="position: absolute; top: 1.25rem; {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1.25rem; background: none; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 1.35rem; color: var(--primary-900); margin-bottom: 0.25rem; font-family: 'Playfair Display', serif;">
            {{ app()->getLocale() === 'ar' ? 'تعديل الخيار' : 'Edit Dropdown Option' }}
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            {{ app()->getLocale() === 'ar' ? 'تعديل التسمية بالعربية والإنجليزية وترتيب الظهور.' : 'Update option labels and sorting order.' }}
        </p>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم باللغة العربية *' : 'Name in Arabic *' }}</label>
                <input type="text" name="name_ar" id="edit_name_ar" required class="form-input">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم باللغة الإنجليزية *' : 'Name in English *' }}</label>
                <input type="text" name="name_en" id="edit_name_en" required class="form-input">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المعرف (Code)' : 'Value / Code' }}</label>
                    <input type="text" name="value" id="edit_value" class="form-input">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Display Order' }}</label>
                    <input type="number" name="order" id="edit_order" class="form-input">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeEditModal()" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn-luxury">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تحديث' : 'Update Option' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(id, nameAr, nameEn, value, order) {
    document.getElementById('edit_name_ar').value = nameAr;
    document.getElementById('edit_name_en').value = nameEn;
    document.getElementById('edit_value').value = value;
    document.getElementById('edit_order').value = order;
    document.getElementById('editForm').action = '{{ url('/admin/dropdown-options') }}/' + id;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
@endsection
