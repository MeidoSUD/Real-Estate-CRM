@extends('layouts.admin')

@php
    $displayTitle = (app()->getLocale() === 'ar' && !empty($offer->title_ar)) ? $offer->title_ar : $offer->title;
    $photoCount = is_array($offer->categorized_images) ? count($offer->categorized_images) : 0;
    $canViewOwner = $offer->canViewOwnerInfo();
@endphp

@section('title', $displayTitle . ' | ' . (app()->getLocale() === 'ar' ? 'تفاصيل العرض الداخلي' : 'Offer Details'))
@section('page_title', app()->getLocale() === 'ar' ? 'العروض العقارية / تفاصيل العرض والوساطة' : 'Offers & Portfolio / Listing Details')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .offer-details-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .contact-card-owner {
        background: linear-gradient(145deg, #ffffff 0%, #fdfbf7 100%);
        border: 1.5px solid rgba(200, 155, 83, 0.4);
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: var(--shadow-card);
    }
    .contact-card-agent {
        background: linear-gradient(145deg, #1b263b 0%, #0d1b2a 100%);
        color: #ffffff;
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: 0 10px 25px rgba(13, 27, 42, 0.25);
    }
    .contact-card-restricted {
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        text-align: center;
    }
    .spec-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.92rem;
    }
    .spec-item:last-child {
        border-bottom: none;
    }
    .spec-item-label {
        color: var(--text-muted);
        font-weight: 600;
    }
    .spec-item-val {
        color: var(--primary-900);
        font-weight: 800;
    }
    .amenity-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--primary-50);
        color: var(--primary-900);
        border: 1px solid var(--border-light);
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.84rem;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<!-- TOP HEADER / ACTION BAR -->
<div class="offer-details-header">
    <div>
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('admin.offers.index') }}" class="btn-outline-luxury btn-sm">
                <i class="fa-solid fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'العودة للقائمة' : 'Back to Offers' }}</span>
            </a>

            @if($offer->status === 'available')
                <span class="badge-success">{{ app()->getLocale() === 'ar' ? 'متاح للعرض والتسويق' : 'Available' }}</span>
            @elseif($offer->status === 'reserved')
                <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'محجوز مؤقتاً' : 'Reserved' }}</span>
            @elseif($offer->status === 'sold')
                <span class="badge-dark" style="background: #991b1b; color: #fff;">{{ app()->getLocale() === 'ar' ? 'تم البيع بنجاح' : 'Sold' }}</span>
            @else
                <span class="badge-dark">{{ ucfirst($offer->status) }}</span>
            @endif

            <span class="badge-dark" style="font-size: 0.75rem;">
                {{ $offer->property_type }} • {{ app()->getLocale() === 'ar' ? ($offer->purpose === 'sale' ? 'للبيع' : 'للإيجار') : 'For ' . ucfirst($offer->purpose) }}
            </span>

            @if($offer->is_featured)
                <span class="badge-gold">
                    <i class="fa-solid fa-star"></i> {{ app()->getLocale() === 'ar' ? 'عرض مميز بالموقع' : 'Featured' }}
                </span>
            @endif
        </div>

        <h2 style="font-size: 1.65rem; color: var(--primary-900); font-weight: 900; margin-bottom: 0.25rem;">
            {{ $displayTitle }}
        </h2>
        <div style="color: var(--text-muted); font-size: 0.9rem; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <span><i class="fa-solid fa-hashtag text-gold"></i> ID: #{{ $offer->id }}</span>
            <span>•</span>
            <span><i class="fa-solid fa-location-dot text-gold"></i> {{ $offer->district }}، {{ $offer->city }}</span>
            <span>•</span>
            <span><i class="fa-solid fa-calendar-days text-gold"></i> {{ $offer->created_at->format('Y-m-d') }}</span>
        </div>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
        <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}; margin-inline-end: 1rem;">
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'السعر المطلوب' : 'Asking Price' }}</div>
            <div style="font-size: 1.75rem; font-weight: 900; color: var(--primary-900); font-family: 'Playfair Display', serif;">
                {{ number_format($offer->price) }} <span style="font-size: 0.9rem; color: var(--accent-bronze);">{{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
            </div>
        </div>

        <a href="{{ route('website.offers.show', $offer->slug) }}" target="_blank" class="btn-outline-luxury" title="{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع العام' : 'View on Website' }}">
            <i class="fa-solid fa-globe"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Page' }}</span>
        </a>

        @if(auth()->user()->hasPermission('offers.edit') || auth()->user()->isAdmin())
            <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn-luxury">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'تعديل العرض' : 'Edit Offer' }}</span>
            </a>
        @endif
    </div>
</div>

<!-- TWO-COLUMN LAYOUT -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 3rem;">
    <!-- LEFT MAIN COLUMN: SPECS, GALLERY, LOCATION -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">

        <!-- MAIN IMAGE & CATEGORIZED GALLERY -->
        <div class="luxury-card" style="padding: 1.5rem; overflow: hidden;">
            <div style="position: relative; border-radius: 14px; overflow: hidden; height: 420px; background: #000; margin-bottom: 1rem;">
                <img id="mainGalleryViewer" src="{{ asset(str_starts_with($offer->main_image, 'properties/') ? 'storage/' . $offer->main_image : $offer->main_image) }}" alt="{{ $displayTitle }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/properties/villa_alshati.jpg') }}'">
                <div style="position: absolute; bottom: 12px; {{ app()->getLocale() === 'ar' ? 'right: 12px;' : 'left: 12px;' }} background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); color: #fff; padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">
                    <i class="fa-solid fa-camera"></i> {{ $photoCount + 1 }} {{ app()->getLocale() === 'ar' ? 'صور مرفقة' : 'Photos' }}
                </div>
            </div>

            @if(is_array($offer->categorized_images) && count($offer->categorized_images) > 0)
                <div style="display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 0.5rem;">
                    <div style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; border: 2px solid var(--accent-gold); cursor: pointer; flex-shrink: 0;" onclick="switchMainImage('{{ asset(str_starts_with($offer->main_image, 'properties/') ? 'storage/' . $offer->main_image : $offer->main_image) }}')">
                        <img src="{{ asset(str_starts_with($offer->main_image, 'properties/') ? 'storage/' . $offer->main_image : $offer->main_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @foreach($offer->categorized_images as $slot => $path)
                        <div style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; border: 2px solid var(--border-light); cursor: pointer; flex-shrink: 0; position: relative;" onclick="switchMainImage('{{ asset('storage/' . $path) }}')">
                            <img src="{{ asset('storage/' . $path) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; bottom: 0; inset-inline: 0; background: rgba(0,0,0,0.6); color: #fff; font-size: 0.6rem; text-align: center; padding: 1px;">
                                {{ ucfirst(str_replace('_', ' ', $slot)) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- SPECIFICATIONS & REGA OFFICIAL DETAILS -->
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.2rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
                <i class="fa-solid fa-list-check text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'المواصفات والبيانات العقارية' : 'Property Specifications & Data' }}</span>
            </h4>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'المساحة الإجمالية:' : 'Total Area:' }}</span>
                        <span class="spec-item-val">{{ number_format($offer->area_sqm) }} م² (SQM)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'تصنيف العقار:' : 'Category:' }}</span>
                        <span class="spec-item-val">{{ $offer->property_category ?: 'سكني (Residential)' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار بالصك:' : 'Deed Type:' }}</span>
                        <span class="spec-item-val">{{ $offer->deed_property_type ?: $offer->property_type }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'فئة العقار / الدرجة:' : 'Property Grade:' }}</span>
                        <span class="spec-item-val">{{ $offer->property_grade ?: (app()->getLocale() === 'ar' ? 'فاخر' : 'Luxury') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'نوع التشطيب:' : 'Finishing:' }}</span>
                        <span class="spec-item-val">{{ $offer->finishing_type ?: (app()->getLocale() === 'ar' ? 'ديلوكس' : 'Deluxe') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'عمر العقار:' : 'Property Age:' }}</span>
                        <span class="spec-item-val">{{ $offer->property_age ?: (app()->getLocale() === 'ar' ? 'جديد (أول ساكن)' : 'Brand New') }}</span>
                    </div>
                </div>

                <div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'عدد غرف النوم:' : 'Bedrooms:' }}</span>
                        <span class="spec-item-val">{{ $offer->bedrooms ?? '—' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'دورات المياه:' : 'Bathrooms:' }}</span>
                        <span class="spec-item-val">{{ $offer->bathrooms ?? '—' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'عدد الأدوار:' : 'Floors Count:' }}</span>
                        <span class="spec-item-val">{{ $offer->floors_count ? $offer->floors_count . ' أدوار' : (app()->getLocale() === 'ar' ? 'طابق واحد' : '1 Floor') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'موضع الوحدة:' : 'Unit Position:' }}</span>
                        <span class="spec-item-val">{{ $offer->unit_position ?: (app()->getLocale() === 'ar' ? 'واجهة أمامية' : 'Front Facade') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'استخدام العقار:' : 'Usage:' }}</span>
                        <span class="spec-item-val">{{ $offer->property_usage ?: (app()->getLocale() === 'ar' ? 'سكني' : 'Residential') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-item-label">{{ app()->getLocale() === 'ar' ? 'ترخيص الهيئة العامة للعقار (فال):' : 'REGA License:' }}</span>
                        <span class="spec-item-val text-gold">{{ $offer->ad_license_number ?: (app()->getLocale() === 'ar' ? 'قيد الترخيص' : 'Pending') }}</span>
                    </div>
                </div>
            </div>

            <!-- FEATURES & LUXURY AMENITIES -->
            @if(!empty($offer->features) && count($offer->features) > 0)
                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border-light);">
                    <div style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700; margin-bottom: 0.75rem;">
                        {{ app()->getLocale() === 'ar' ? 'المرافق والخدمات المميزة:' : 'Amenities & Features:' }}
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.6rem;">
                        @foreach($offer->features as $feature)
                            <span class="amenity-badge">
                                <i class="fa-solid fa-check text-gold"></i>
                                <span>{{ $feature }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- UTILITIES CONNECTED -->
            @if(!empty($offer->utilities_services) && count($offer->utilities_services) > 0)
                <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--border-light);">
                    <div style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700; margin-bottom: 0.75rem;">
                        {{ app()->getLocale() === 'ar' ? 'شبكات البنية التحتية والخدمات المتصلة:' : 'Connected Utilities:' }}
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.6rem;">
                        @foreach($offer->utilities_services as $util)
                            <span class="amenity-badge" style="background: var(--bg-cream);">
                                <i class="fa-solid fa-bolt text-gold"></i>
                                <span>{{ $util }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- DESCRIPTION -->
        @if($offer->description)
            <div class="luxury-card" style="padding: 2rem;">
                <h4 style="font-size: 1.2rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1rem;">
                    {{ app()->getLocale() === 'ar' ? 'الوصف التسويقي العام' : 'Public Marketing Description' }}
                </h4>
                <p style="color: var(--text-muted); line-height: 1.8; font-size: 0.95rem; white-space: pre-line;">
                    {{ $offer->description }}
                </p>
            </div>
        @endif

        <!-- LOCATION & LEAFLET MAP -->
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-size: 1.2rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-map-location-dot text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'الموقع الجغرافي والعنوان الوطني' : 'Location & National Address' }}</span>
                </h4>

                @if($offer->map_link)
                    <a href="{{ $offer->map_link }}" target="_blank" class="btn-outline-luxury btn-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'خرائط جوجل' : 'Google Maps' }}</span>
                    </a>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.25rem; font-size: 0.88rem;">
                <div style="background: var(--primary-50); padding: 0.75rem 1rem; border-radius: 8px;">
                    <span style="color: var(--text-muted); font-size: 0.75rem; display: block;">{{ app()->getLocale() === 'ar' ? 'المدينة والحي' : 'City & District' }}</span>
                    <strong style="color: var(--primary-900);">{{ $offer->city }} - {{ $offer->district }}</strong>
                </div>
                <div style="background: var(--primary-50); padding: 0.75rem 1rem; border-radius: 8px;">
                    <span style="color: var(--text-muted); font-size: 0.75rem; display: block;">{{ app()->getLocale() === 'ar' ? 'الشارع' : 'Street' }}</span>
                    <strong style="color: var(--primary-900);">{{ $offer->street_name ?: 'شارع رئيسي' }}</strong>
                </div>
                <div style="background: var(--primary-50); padding: 0.75rem 1rem; border-radius: 8px;">
                    <span style="color: var(--text-muted); font-size: 0.75rem; display: block;">{{ app()->getLocale() === 'ar' ? 'رقم المبنى والرمز' : 'Building & Postal' }}</span>
                    <strong style="color: var(--primary-900);">{{ $offer->building_number ?: '—' }} ({{ $offer->postal_code ?: '—' }})</strong>
                </div>
            </div>

            <div id="offerMap" style="height: 320px; border-radius: 12px; border: 1px solid var(--border-light);"></div>
        </div>

    </div>

    <!-- RIGHT SIDEBAR: CONTACTS & PERMISSION-GATED DATA -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">

        <!-- 1. RESPONSIBLE MARKETING OFFICER CARD (VISIBLE TO ALL STAFF) -->
        <div class="contact-card-agent">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 0.75rem;">
                <i class="fa-solid fa-bullhorn" style="color: var(--accent-gold); font-size: 1.2rem;"></i>
                <h4 style="font-size: 1.15rem; font-weight: 800; color: #ffffff;">
                    {{ app()->getLocale() === 'ar' ? 'المسوق المسؤول عن العرض' : 'Listing Marketing Officer' }}
                </h4>
            </div>

            @php
                $agent = $offer->creator;
            @endphp

            @if($agent)
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <img src="{{ $agent->profile_photo_url }}" alt="{{ $agent->name }}" style="width: 58px; height: 58px; border-radius: 12px; object-fit: cover; border: 2px solid var(--accent-gold); flex-shrink: 0;">
                    <div>
                        <div style="font-weight: 800; font-size: 1.1rem; color: #ffffff;">{{ $agent->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--accent-gold-light); font-weight: 600;">
                            {{ $agent->job_title ?: (app()->getLocale() === 'ar' ? 'أخصائي تسويق عقاري' : 'Marketing Specialist') }}
                        </div>
                        <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); margin-top: 2px;">
                            {{ $agent->role ? $agent->role->name : 'Staff' }}
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.88rem; margin-bottom: 1.5rem; background: rgba(255,255,255,0.06); padding: 1rem; border-radius: 10px;">
                    @if($agent->phone)
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: rgba(255,255,255,0.7);"><i class="fa-solid fa-phone text-gold"></i> {{ app()->getLocale() === 'ar' ? 'جوال المسوق:' : 'Phone:' }}</span>
                            <strong style="direction: ltr; color: #fff;">{{ $agent->phone }}</strong>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: rgba(255,255,255,0.7);"><i class="fa-solid fa-envelope text-gold"></i> {{ app()->getLocale() === 'ar' ? 'البريد:' : 'Email:' }}</span>
                        <span style="color: #fff; font-size: 0.82rem;">{{ $agent->email }}</span>
                    </div>
                </div>

                @if($agent->phone)
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <a href="tel:{{ $agent->phone }}" class="btn-luxury" style="padding: 0.6rem; font-size: 0.85rem; text-align: center; justify-content: center;">
                            <i class="fa-solid fa-phone"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'اتصال داخلي' : 'Call Agent' }}</span>
                        </a>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->phone) }}?text={{ urlencode('مرحباً أخي ' . $agent->name . '، أود الاستفسار والتنسيق معك بخصوص العرض العقاري #' . $offer->id . ' - ' . $displayTitle) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: #25D366; color: #fff; font-weight: 700; border-radius: 8px; text-decoration: none; padding: 0.6rem; font-size: 0.85rem;">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>واتساب المسوق</span>
                        </a>
                    </div>
                @endif
            @else
                <div style="padding: 1rem; background: rgba(255,255,255,0.06); border-radius: 8px; text-align: center; color: rgba(255,255,255,0.8); font-size: 0.9rem;">
                    {{ app()->getLocale() === 'ar' ? 'تمت إضافة هذا العرض بواسطة الإدارة العامة / قسم التسويق المركزي.' : 'Added by General Administration / Central Marketing.' }}
                </div>
            @endif

            <p style="font-size: 0.78rem; color: rgba(255,255,255,0.65); margin-top: 1rem; line-height: 1.5; text-align: center;">
                {{ app()->getLocale() === 'ar' ? 'للتنسيق الداخلي بين فريق التسويق وفريق خدمة العملاء بخصوص هذا العرض.' : 'For internal collaboration between Marketing and Customer Service teams.' }}
            </p>
        </div>

        <!-- 2. OWNER CONTACT CARD (PERMISSION RESTRICTED: CREATOR & ADMIN ONLY) -->
        @if($canViewOwner)
            <!-- AUTHORIZED VIEW: CREATOR & ADMIN -->
            <div class="contact-card-owner">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-lock-open"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 1.15rem; font-weight: 800; color: var(--primary-900);">
                                {{ app()->getLocale() === 'ar' ? 'بيانات مالك العقار وعقد الوساطة' : 'Owner Contact & Deed Info' }}
                            </h4>
                            <span style="font-size: 0.75rem; color: #15803d; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'ar' ? 'متاح لمنشئ العرض والإدارة' : 'Authorized (Offer Creator & Admin)' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- OWNER NAME & PHONE -->
                <div style="background: #ffffff; border: 1px solid var(--border-light); border-radius: 12px; padding: 1.25rem; margin-bottom: 1.25rem;">
                    <div style="margin-bottom: 0.85rem;">
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; display: block;">
                            {{ app()->getLocale() === 'ar' ? 'اسم مالك العقار / صاحب الصك:' : 'Property Owner Name:' }}
                        </span>
                        <strong style="font-size: 1.1rem; color: var(--primary-900);">
                            {{ $offer->owner_name ?: (app()->getLocale() === 'ar' ? 'المالك مسجل بعقد الوساطة' : 'Owner on contract') }}
                        </strong>
                    </div>

                    @if($offer->owner_phone)
                        <div style="margin-bottom: 1rem;">
                            <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; display: block;">
                                {{ app()->getLocale() === 'ar' ? 'رقم هاتف المالك المباشر:' : 'Direct Owner Phone:' }}
                            </span>
                            <div style="font-size: 1.25rem; font-weight: 900; color: var(--accent-bronze); direction: ltr; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">
                                <i class="fa-solid fa-phone text-gold" style="font-size: 1rem;"></i> {{ $offer->owner_phone }}
                            </div>
                        </div>

                        <!-- QUICK CALL & WHATSAPP BUTTONS TO OWNER -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.5rem;">
                            <a href="tel:{{ $offer->owner_phone }}" class="btn-luxury" style="padding: 0.65rem; font-size: 0.85rem; justify-content: center;">
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ app()->getLocale() === 'ar' ? 'اتصال بالمالك' : 'Call Owner' }}</span>
                            </a>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $offer->owner_phone) }}?text={{ urlencode('السلام عليكم ورحمة الله وبركاته، نتواصل مع سعادتكم من مكتب خدمة العملاء بشركة صفران العقارية بخصوص عرضكم العقاري: ' . $displayTitle . ' لتنسيق معاينة أحد المشترين المهتمين.') }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: #25D366; color: #fff; font-weight: 700; border-radius: 8px; text-decoration: none; padding: 0.65rem; font-size: 0.85rem;">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>واتساب المالك</span>
                            </a>
                        </div>
                    @else
                        <div style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">
                            {{ app()->getLocale() === 'ar' ? 'لم يتم إدخال رقم جوال المالك مباشرة بهذا السجل.' : 'No direct phone number entered.' }}
                        </div>
                    @endif
                </div>

                <!-- BROKERAGE CONTRACT & DEED DETAILS -->
                <div style="background: var(--bg-cream); border: 1px solid var(--border-light); border-radius: 10px; padding: 1rem; font-size: 0.85rem; margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'رقم صك الملكية:' : 'Deed Number:' }}</span>
                        <strong>{{ $offer->deed_number ?: (app()->getLocale() === 'ar' ? 'غير مسجل' : 'N/A') }}</strong>
                    </div>

                    @if($offer->owner_national_id)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                            <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'الهوية / السجل:' : 'Owner ID / CR:' }}</span>
                            <strong>{{ $offer->owner_national_id }}</strong>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'صفة صاحب الإعلان:' : 'Ownership / POA:' }}</span>
                        <strong>{{ $offer->has_agency_poa === 'yes' ? (app()->getLocale() === 'ar' ? 'وكيل شرعي' : 'Power of Attorney') : (app()->getLocale() === 'ar' ? 'المالك الأصيل' : 'Direct Owner') }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'نوع عقد الوساطة:' : 'Contract Type:' }}</span>
                        <strong>{{ $offer->contract_type ?: (app()->getLocale() === 'ar' ? 'وساطة حصرية' : 'Exclusive') }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'مدة العقد:' : 'Duration:' }}</span>
                        <strong>{{ $offer->contract_duration_months ? $offer->contract_duration_months . ' أشهر' : '3 أشهر' }}</strong>
                    </div>

                    @if($offer->deed_image)
                        <div style="margin-top: 0.85rem; padding-top: 0.75rem; border-top: 1px dashed var(--border-light); text-align: center;">
                            <a href="{{ asset('storage/' . $offer->deed_image) }}" target="_blank" class="btn-outline-luxury btn-sm" style="width: 100%; justify-content: center;">
                                <i class="fa-solid fa-file-pdf text-gold"></i>
                                <span>{{ app()->getLocale() === 'ar' ? 'معاينة وثيقة / صورة الصك المرفقة' : 'View Attached Deed' }}</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- PRIVATE INTERNAL NOTES -->
                @if($offer->internal_notes)
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 1rem;">
                        <div style="font-weight: 800; color: #92400e; font-size: 0.85rem; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'الملاحظات الداخلية السرية (خدمة العملاء والإدارة):' : 'Private Confidential Notes:' }}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: #78350f; line-height: 1.6; margin: 0; white-space: pre-line;">
                            {{ $offer->internal_notes }}
                        </p>
                    </div>
                @endif
            </div>
        @else
            <!-- RESTRICTED VIEW: MARKETING TEAM & GENERAL STAFF -->
            <div class="contact-card-restricted">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.4rem;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <h4 style="font-size: 1.15rem; font-weight: 800; color: var(--primary-900); margin-bottom: 0.5rem;">
                    {{ app()->getLocale() === 'ar' ? 'بيانات مالك العقار سرية ومحمية' : 'Owner Contact Information Protected' }}
                </h4>

                <p style="font-size: 0.86rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem;">
                    {{ app()->getLocale() === 'ar' ? 'أرقام وهوية مالك العقار ووثائق الصك مخصصة ومتاحة حصرياً للمستخدم الذي أضاف هذا العرض ولإدارة النظام فقط.' : 'Property owner contact details and legal deeds are confidential and restricted strictly to the user who created this offer and system administration.' }}
                </p>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem; margin-bottom: 1.25rem; font-size: 0.85rem; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'مالك العقار:' : 'Owner:' }}</span>
                        <strong style="color: #64748b;">{{ $offer->masked_owner_name }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'هاتف المالك:' : 'Phone:' }}</span>
                        <span style="color: #64748b; font-family: monospace; font-size: 0.95rem;">••••••••••••</span>
                    </div>
                </div>

                <div style="font-size: 0.82rem; color: var(--primary-900); background: #f1f5f9; padding: 0.75rem; border-radius: 8px; font-weight: 600;">
                    <i class="fa-solid fa-circle-info text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'لترتيب معاينة لمشتري، يرجى مراجعة المسوق المعتمد أعلاه أو تحويل الطلب لخدمة العملاء.' : 'To arrange a viewing, connect with the listing marketing agent above or forward the request to Customer Care.' }}</span>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function switchMainImage(src) {
    const mainImg = document.getElementById('mainGalleryViewer');
    if (mainImg) {
        mainImg.src = src;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $offer->latitude ?: 21.543333 }};
    const lng = {{ $offer->longitude ?: 39.172778 }};

    const map = L.map('offerMap').setView([lat, lng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('<b>{{ addslashes($displayTitle) }}</b><br>{{ addslashes($offer->district) }}')
        .openPopup();
});
</script>
@endsection
