@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة العروض العقارية' : 'Manage Property Offers')
@section('page_title', app()->getLocale() === 'ar' ? 'العروض العقارية / محفظة الوحدات' : 'Real Estate Offers & Portfolio')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800;">
            {{ app()->getLocale() === 'ar' ? 'محفظة العروض والوحدات العقارية' : 'Property Offers & Catalog' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'إدارة شاملة لجميع العروض، عقود الوساطة، وتراخيص الإعلانات الصادرة من الهيئة العامة للعقار.' : 'Comprehensive management of all listings, brokerage contracts, and REGA licenses.' }}
        </p>
    </div>

    @if(auth()->user()->hasPermission('offers.create') || auth()->user()->isAdmin())
        <a href="{{ route('admin.offers.create') }}" class="btn-luxury">
            <i class="fa-solid fa-plus"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'إنشاء عرض عقاري جديد' : 'Create New Offer' }}</span>
        </a>
    @endif
</div>

<!-- ADVANCED FILTER BAR -->
<div class="luxury-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form action="{{ route('admin.offers.index') }}" method="GET" style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'البحث بالاسم، الحي، رقم الصك، أو ترخيص الإعلان...' : 'Search by title, district, deed no., or ad license...' }}">
            </div>

            <div>
                <select name="property_category" class="form-select">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'كافة التصنيفات' : 'All Categories' }}</option>
                    @foreach($propertyCategories as $cat)
                        <option value="{{ $cat->value ?: $cat->name_en }}" {{ request('property_category') === ($cat->value ?: $cat->name_en) ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="property_type" class="form-select">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الأنواع' : 'All Types' }}</option>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->value ?: $pt->name_en }}" {{ request('property_type') === ($pt->value ?: $pt->name_en) ? 'selected' : '' }}>
                            {{ $pt->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="district" class="form-select">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الأحياء' : 'All Districts' }}</option>
                    @foreach($districts as $dst)
                        <option value="{{ $dst->name_en }}" {{ request('district') === $dst->name_en || request('district') === $dst->name_ar ? 'selected' : '' }}>
                            {{ $dst->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="status" class="form-select">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الحالات' : 'All Statuses' }}</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'متاح' : 'Available' }}</option>
                    <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'محجوز' : 'Reserved' }}</option>
                    <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مباع' : 'Sold' }}</option>
                    <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مؤجر' : 'Rented' }}</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 0.5rem; border-top: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">
                    <input type="checkbox" name="hide_sold" value="1" {{ request('hide_sold') ? 'checked' : '' }} style="width: 17px; height: 17px; accent-color: var(--accent-bronze);">
                    <span>{{ app()->getLocale() === 'ar' ? 'إخفاء العقارات المباعة والمؤجرة' : 'Hide Sold & Rented Properties' }}</span>
                </label>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button type="submit" class="btn-luxury" style="padding: 0.65rem 1.4rem;">
                    <i class="fa-solid fa-filter"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تطبيق التصفية' : 'Apply Filters' }}</span>
                </button>

                @if(request()->hasAny(['search', 'status', 'district', 'property_type', 'property_category', 'hide_sold']))
                    <a href="{{ route('admin.offers.index') }}" class="btn-outline-luxury" style="padding: 0.65rem 1rem;" title="{{ app()->getLocale() === 'ar' ? 'إلغاء التصفية' : 'Clear Filters' }}">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'إعادة تعيين' : 'Reset' }}</span>
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- OFFERS TABLE -->
<div class="luxury-table-container">
    <table class="luxury-table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'ar' ? 'العقار والرمز' : 'Property & Code' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'التصنيف / النوع' : 'Category / Type' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الصك / ترخيص الإعلان' : 'Deed / REGA License' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الحي (جدة)' : 'District' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'السعر المطلوب' : 'Price (SAR)' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'المسوق المسؤول' : 'Listing Agent' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'مالك العقار' : 'Property Owner' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($offers as $offer)
                @php
                    $displayTitle = (app()->getLocale() === 'ar' && !empty($offer->title_ar)) ? $offer->title_ar : $offer->title;
                    $photoCount = is_array($offer->categorized_images) ? count($offer->categorized_images) : 0;
                    $canViewOwner = auth()->user()->canViewOwnerContact();
                @endphp
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.85rem;">
                            <div style="position: relative;">
                                <img src="{{ asset(str_starts_with($offer->main_image, 'properties/') ? 'storage/' . $offer->main_image : $offer->main_image) }}" alt="" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--border-light); flex-shrink: 0;" onerror="this.src='{{ asset('images/properties/villa_alshati.jpg') }}'">
                                @if($photoCount > 0)
                                    <span style="position: absolute; bottom: 3px; {{ app()->getLocale() === 'ar' ? 'left: 3px;' : 'right: 3px;' }} background: rgba(0,0,0,0.7); color: #fff; font-size: 0.65rem; padding: 1px 4px; border-radius: 4px; font-weight: 700;">
                                        <i class="fa-solid fa-camera"></i> {{ $photoCount }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.offers.show', $offer->id) }}" style="text-decoration: none; color: inherit;">
                                    <strong style="color: var(--primary-900); font-size: 0.95rem; display: block;">{{ $displayTitle }}</strong>
                                </a>
                                <span style="font-size: 0.78rem; color: var(--text-muted);">
                                    #{{ $offer->id }} • {{ number_format($offer->area_sqm) }} م² • {{ $offer->bedrooms ?? 0 }} {{ app()->getLocale() === 'ar' ? 'غرف' : 'Beds' }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge-dark" style="font-size: 0.78rem;">
                            {{ $offer->property_type }}
                        </span>
                        <div style="font-size: 0.75rem; color: var(--accent-bronze); margin-top: 0.25rem; font-weight: 700;">
                            {{ app()->getLocale() === 'ar' ? ($offer->purpose === 'sale' ? 'للبيع' : 'للإيجار') : 'For ' . ucfirst($offer->purpose) }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 0.82rem; font-weight: 700; color: var(--primary-900);">
                            <i class="fa-solid fa-file-contract text-gold" style="font-size: 0.75rem;"></i>
                            {{ $offer->deed_number ?: (app()->getLocale() === 'ar' ? 'غير مسجل' : 'N/A') }}
                        </div>
                        @if($offer->ad_license_number)
                            <div style="font-size: 0.74rem; color: #15803d; font-weight: 700; margin-top: 2px;">
                                <i class="fa-solid fa-certificate"></i> {{ $offer->ad_license_number }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <i class="fa-solid fa-location-dot text-gold" style="font-size: 0.8rem;"></i>
                        <span style="font-weight: 700;">{{ $offer->district }}</span>
                    </td>
                    <td>
                        <div style="font-size: 1.15rem; font-weight: 900; color: var(--primary-900);">
                            {{ number_format($offer->price) }}
                        </div>
                        <span style="font-size: 0.75rem; color: var(--accent-bronze); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
                    </td>
                    <td>
                        @if($offer->status === 'available')
                            <span class="badge-success">{{ app()->getLocale() === 'ar' ? 'متاح' : 'Available' }}</span>
                        @elseif($offer->status === 'reserved')
                            <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'محجوز' : 'Reserved' }}</span>
                        @elseif($offer->status === 'sold')
                            <span class="badge-dark" style="background: #991b1b; color: #fff;">{{ app()->getLocale() === 'ar' ? 'تم البيع' : 'Sold' }}</span>
                        @else
                            <span class="badge-dark">{{ ucfirst($offer->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">
                            <i class="fa-solid fa-user-tie text-gold" style="font-size: 0.8rem;"></i>
                            {{ $offer->creator ? $offer->creator->name : (app()->getLocale() === 'ar' ? 'فريق التسويق' : 'Marketing Team') }}
                        </div>
                        @if($offer->creator && $offer->creator->phone)
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; direction: ltr; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <a href="tel:{{ $offer->creator->phone }}" style="color: var(--accent-bronze); text-decoration: none;" title="{{ app()->getLocale() === 'ar' ? 'اتصال بالمسوق' : 'Call Agent' }}">
                                    <i class="fa-solid fa-phone"></i> {{ $offer->creator->phone }}
                                </a>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($canViewOwner)
                            <div style="font-size: 0.86rem; font-weight: 700; color: #15803d;">
                                <i class="fa-solid fa-key text-gold"></i>
                                {{ $offer->owner_name ?: (app()->getLocale() === 'ar' ? 'المالك بالعقد' : 'Owner on deed') }}
                            </div>
                            @if($offer->owner_phone)
                                <div style="margin-top: 3px; display: flex; align-items: center; gap: 0.35rem;">
                                    <a href="tel:{{ $offer->owner_phone }}" class="badge-gold" style="text-decoration: none; font-size: 0.72rem; padding: 2px 6px;" title="{{ app()->getLocale() === 'ar' ? 'اتصال بالمالك' : 'Call Owner' }}">
                                        <i class="fa-solid fa-phone"></i> {{ $offer->owner_phone }}
                                    </a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $offer->owner_phone) }}" target="_blank" style="color: #25D366; font-size: 0.85rem;" title="واتساب المالك">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </div>
                            @endif
                        @else
                            <span class="badge-dark" style="background: #f1f5f9; color: #64748b; font-size: 0.72rem; border: 1px solid #cbd5e1; font-weight: 600;" title="{{ app()->getLocale() === 'ar' ? 'بيانات المالك مخصصة حصرياً لفريق خدمة العملاء والإدارة' : 'Owner contact is restricted to Customer Service & Admin' }}">
                                <i class="fa-solid fa-lock text-gold"></i> {{ app()->getLocale() === 'ar' ? 'محمي لخدمة العملاء' : 'Protected' }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.35rem;">
                            <a href="{{ route('admin.offers.show', $offer->id) }}" class="btn-outline-luxury btn-sm" title="{{ app()->getLocale() === 'ar' ? 'تفاصيل العرض وبيانات الوساطة بالـ CRM' : 'View CRM Details' }}" style="background: var(--primary-50); color: var(--primary-900);">
                                <i class="fa-solid fa-file-invoice"></i>
                            </a>

                            <a href="{{ route('website.offers.show', $offer->slug) }}" target="_blank" class="btn-outline-luxury btn-sm" title="{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع العام' : 'View Public Listing' }}">
                                <i class="fa-solid fa-globe"></i>
                            </a>

                            @if(auth()->user()->hasPermission('offers.edit') || auth()->user()->isAdmin())
                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn-outline-luxury btn-sm" title="{{ app()->getLocale() === 'ar' ? 'تعديل بيانات العرض' : 'Edit Offer' }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(auth()->user()->hasPermission('offers.delete') || auth()->user()->isAdmin())
                                <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا العرض العقاري نهائياً؟' : 'Delete this property offer?' }}');">
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
                    <td colspan="9" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على عروض عقارية مطابقة للتصفية.' : 'No property offers found matching the filters.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem;">
    {{ $offers->links() }}
</div>
@endsection
