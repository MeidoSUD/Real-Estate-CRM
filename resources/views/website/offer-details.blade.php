@extends('layouts.website')

@php
    $displayTitle = (app()->getLocale() === 'ar' && !empty($offer->title_ar)) ? $offer->title_ar : $offer->title;
    $categorizedImages = $offer->categorized_images ?? [];
    $mainImgUrl = str_starts_with($offer->main_image, 'properties/') ? asset('storage/' . $offer->main_image) : asset($offer->main_image);
@endphp

@section('title', $displayTitle . ' | ' . (app()->getLocale() === 'ar' ? 'صفران العقارية' : 'Safran for Real Estate'))

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .details-hero {
        background: var(--primary-950);
        padding: 2.5rem 1.5rem;
        color: #ffffff;
        border-bottom: 1px solid rgba(200, 155, 83, 0.2);
    }
    .details-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .details-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2.5rem;
        margin-top: 2.5rem;
        margin-bottom: 5rem;
    }
    .property-main-img {
        width: 100%;
        height: 520px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: var(--shadow-card);
    }
    .specs-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        background: #ffffff;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-light);
        padding: 1.5rem;
        margin: 2rem 0;
    }
    .spec-box {
        text-align: center;
        padding: 0.5rem;
        border-inline-end: 1px solid var(--border-light);
    }
    .spec-box:last-child {
        border-inline-end: none;
    }
    .spec-box-icon {
        font-size: 1.35rem;
        color: var(--accent-gold);
        margin-bottom: 0.35rem;
    }
    .spec-box-val {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--primary-900);
    }
    .spec-box-lbl {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 700;
    }
    .amenities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .amenity-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-50);
        border: 1px solid rgba(163, 105, 57, 0.2);
        color: var(--primary-800);
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.9rem;
        font-weight: 700;
    }
    .inquiry-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1.5px solid rgba(200, 155, 83, 0.3);
        box-shadow: var(--shadow-hover);
        padding: 2rem;
        position: sticky;
        top: 90px;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .gallery-thumb {
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }
    .gallery-thumb:hover, .gallery-thumb.active {
        border-color: var(--accent-gold);
        transform: scale(1.03);
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-thumb-tag {
        position: absolute;
        bottom: 0;
        inset-inline: 0;
        background: rgba(0,0,0,0.65);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px;
        text-align: center;
    }
    @media (max-width: 992px) {
        .details-layout { grid-template-columns: 1fr; }
        .property-main-img { height: 360px; }
        .specs-grid { grid-template-columns: repeat(2, 1fr); }
        .spec-box { border-inline-end: none; border-bottom: 1px solid var(--border-light); }
    }
</style>
@endsection

@section('content')
<div class="details-hero">
    <div class="details-container">
        <a href="{{ route('website.offers') }}" style="color: var(--accent-gold-light); font-size: 0.92rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-weight: 700;">
            <i class="fa-solid fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'العودة لجميع العروض العقارية' : 'Back to Offers' }}</span>
        </a>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem; flex-wrap: wrap;">
                    <span class="badge-gold">
                        {{ $offer->property_type }}
                    </span>
                    <span class="badge-dark">
                        {{ app()->getLocale() === 'ar' ? ($offer->purpose === 'sale' ? 'للبيع' : 'للإيجار') : 'For ' . ucfirst($offer->purpose) }}
                    </span>
                    <span class="badge-success">
                        {{ app()->getLocale() === 'ar' ? ($offer->status === 'available' ? 'متاح حالياً' : $offer->status) : ucfirst($offer->status) }}
                    </span>
                    @if($offer->ad_license_number)
                        <span class="badge-gold" style="background: rgba(21, 128, 61, 0.2); color: #86efac; border: 1px solid #16a34a;">
                            <i class="fa-solid fa-certificate"></i> {{ app()->getLocale() === 'ar' ? 'ترخيص إعلاني فال: ' : 'REGA License: ' }}{{ $offer->ad_license_number }}
                        </span>
                    @endif
                </div>
                <h1 style="color: #ffffff; font-size: 2.2rem; font-weight: 800; line-height: 1.3;">
                    {{ $displayTitle }}
                </h1>
                <p style="color: rgba(255, 255, 255, 0.85); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600;">
                    <i class="fa-solid fa-location-dot text-gold"></i>
                    {{ app()->getLocale() === 'ar' ? ($offer->address ?: $offer->district . '، جدة، المملكة العربية السعودية') : ($offer->address ?: $offer->district . ', Jeddah, Saudi Arabia') }}
                </p>
            </div>
            <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                <div style="font-size: 0.85rem; color: var(--accent-gold-light); text-transform: uppercase; font-weight: 700;">
                    {{ app()->getLocale() === 'ar' ? 'السعر المطلوب' : 'Asking Price' }}
                </div>
                <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff;">
                    {{ number_format($offer->price) }}
                    <span style="font-size: 1.1rem; color: var(--accent-gold); font-weight: 700;">
                        {{ app()->getLocale() === 'ar' ? 'ريال سعودي' : 'SAR' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="details-container">
    <div class="details-layout">
        <!-- MAIN COLUMN -->
        <div>
            <!-- MAIN HERO IMAGE -->
            <img src="{{ $mainImgUrl }}" alt="{{ $displayTitle }}" id="mainGalleryImg" class="property-main-img" onerror="this.src='{{ asset('images/properties/villa_alshati.jpg') }}'">

            <!-- CATEGORIZED PHOTOS THUMBNAILS -->
            @if(!empty($categorizedImages) && count($categorizedImages) > 0)
                <div style="margin-top: 1rem;">
                    <div style="font-size: 0.9rem; font-weight: 800; color: var(--primary-900); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-images text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'صور الغرف والمرافق التابعة للعقار (' . count($categorizedImages) . ' صور):' : 'Room & Facility Photos (' . count($categorizedImages) . ' photos):' }}</span>
                    </div>
                    <div class="gallery-grid">
                        @foreach($categorizedImages as $slotKey => $imgPath)
                            @php
                                $slotNames = [
                                    'facade_main' => ['ar' => 'الواجهة الرئيسية', 'en' => 'Main Facade'],
                                    'facade_side' => ['ar' => 'الواجهة الجانبية', 'en' => 'Side Facade'],
                                    'entrance' => ['ar' => 'المدخل', 'en' => 'Entrance'],
                                    'living_room_1' => ['ar' => 'الصالة 1', 'en' => 'Living 1'],
                                    'living_room_2' => ['ar' => 'مجلس الضيوف', 'en' => 'Majlis'],
                                    'kitchen' => ['ar' => 'المطبخ', 'en' => 'Kitchen'],
                                    'bathroom_1' => ['ar' => 'الحمام 1', 'en' => 'Bath 1'],
                                    'bathroom_2' => ['ar' => 'الحمام 2', 'en' => 'Bath 2'],
                                    'bedroom_master' => ['ar' => 'غرفة الماستر', 'en' => 'Master Bed'],
                                    'bedroom_2' => ['ar' => 'غرفة نوم 2', 'en' => 'Bedroom 2'],
                                    'bedroom_3' => ['ar' => 'غرفة نوم 3', 'en' => 'Bedroom 3'],
                                    'internal_stairs' => ['ar' => 'الدرج الداخلي', 'en' => 'Stairs'],
                                    'upper_annex' => ['ar' => 'الملحق العلوي', 'en' => 'Annex'],
                                    'pool' => ['ar' => 'المسبح', 'en' => 'Pool'],
                                    'garden' => ['ar' => 'الحديقة', 'en' => 'Garden'],
                                    'laundry_room' => ['ar' => 'غرفة الغسيل', 'en' => 'Laundry'],
                                    'storage_room' => ['ar' => 'المستودع', 'en' => 'Storage'],
                                    'maid_room' => ['ar' => 'غرفة الخادمة', 'en' => 'Maid'],
                                    'external_stairs' => ['ar' => 'الدرج الخارجي', 'en' => 'Ext Stairs'],
                                    'driver_room' => ['ar' => 'غرفة السائق', 'en' => 'Driver'],
                                    'elevator' => ['ar' => 'المصعد', 'en' => 'Elevator'],
                                ];
                                $label = $slotNames[$slotKey] ?? ['ar' => $slotKey, 'en' => $slotKey];
                                $thumbSrc = asset('storage/' . $imgPath);
                            @endphp
                            <div class="gallery-thumb" onclick="swapMainImage('{{ $thumbSrc }}')">
                                <img src="{{ $thumbSrc }}" alt="{{ $label['ar'] }}">
                                <div class="gallery-thumb-tag">{{ app()->getLocale() === 'ar' ? $label['ar'] : $label['en'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- SPECS -->
            <div class="specs-grid">
                <div class="spec-box">
                    <div class="spec-box-icon"><i class="fa-solid fa-ruler-combined"></i></div>
                    <div class="spec-box-val">{{ number_format($offer->area_sqm) }} م²</div>
                    <div class="spec-box-lbl">{{ app()->getLocale() === 'ar' ? 'إجمالي المساحة' : 'Total Area' }}</div>
                </div>
                <div class="spec-box">
                    <div class="spec-box-icon"><i class="fa-solid fa-bed"></i></div>
                    <div class="spec-box-val">{{ $offer->bedrooms ?? '—' }}</div>
                    <div class="spec-box-lbl">{{ app()->getLocale() === 'ar' ? 'غرف النوم' : 'Bedrooms' }}</div>
                </div>
                <div class="spec-box">
                    <div class="spec-box-icon"><i class="fa-solid fa-bath"></i></div>
                    <div class="spec-box-val">{{ $offer->bathrooms ?? '—' }}</div>
                    <div class="spec-box-lbl">{{ app()->getLocale() === 'ar' ? 'دورات المياه' : 'Bathrooms' }}</div>
                </div>
                <div class="spec-box">
                    <div class="spec-box-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="spec-box-val">{{ $offer->floors_count ? $offer->floors_count . ' ' . (app()->getLocale() === 'ar' ? 'أدوار' : 'Floors') : (app()->getLocale() === 'ar' ? 'طابق واحد' : '1 Floor') }}</div>
                    <div class="spec-box-lbl">{{ app()->getLocale() === 'ar' ? 'عدد الأدوار' : 'Floors Count' }}</div>
                </div>
            </div>

            <!-- DETAILED SPECIFICATIONS TABLE -->
            <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light); padding: 1.75rem; margin-bottom: 2rem;">
                <h3 style="font-size: 1.35rem; margin-bottom: 1.25rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-circle-info text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'البيانات والمواصفات الرسمية' : 'Official Property Specifications' }}</span>
                </h3>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.95rem;">
                    @if($offer->ad_license_number)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'رقم ترخيص الإعلان (فال):' : 'Ad License No (REGA):' }}</span>
                            <span style="font-weight: 800; color: #15803d;"><i class="fa-solid fa-certificate"></i> {{ $offer->ad_license_number }}</span>
                        </div>
                    @endif

                    @if($offer->plan_number)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'رقم المخطط:' : 'Plan Number:' }}</span>
                            <span style="font-weight: 800; color: var(--primary-900);">{{ $offer->plan_number }}</span>
                        </div>
                    @endif

                    @if($offer->parcel_number)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'رقم القطعة:' : 'Parcel Number:' }}</span>
                            <span style="font-weight: 800; color: var(--primary-900);">{{ $offer->parcel_number }}</span>
                        </div>
                    @endif

                    @if($offer->property_age)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'عمر العقار:' : 'Property Age:' }}</span>
                            <span style="font-weight: 800; color: var(--primary-900);">{{ $offer->property_age }}</span>
                        </div>
                    @endif

                    @if($offer->finishing_type)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'نوع التشطيب:' : 'Finishing:' }}</span>
                            <span style="font-weight: 800; color: var(--primary-900);">{{ $offer->finishing_type }}</span>
                        </div>
                    @endif

                    @if($offer->property_usage)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border-light);">
                            <span style="color: var(--text-muted); font-weight: 600;">{{ app()->getLocale() === 'ar' ? 'الاستخدام:' : 'Usage:' }}</span>
                            <span style="font-weight: 800; color: var(--primary-900);">{{ $offer->property_usage }}</span>
                        </div>
                    @endif
                </div>

                <!-- Utilities -->
                @if(!empty($offer->utilities_services) && count($offer->utilities_services) > 0)
                    <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                        <span style="color: var(--text-muted); font-size: 0.88rem; font-weight: 700; display: block; margin-bottom: 0.5rem;">
                            {{ app()->getLocale() === 'ar' ? 'شبكات البنية التحتية والخدمات المتصلة:' : 'Connected Infrastructure:' }}
                        </span>
                        <div style="display: flex; gap: 0.6rem; flex-wrap: wrap;">
                            @foreach($offer->utilities_services as $util)
                                <span style="background: var(--primary-50); border: 1px solid var(--border-light); padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.82rem; font-weight: 700; color: var(--primary-900);">
                                    <i class="fa-solid fa-bolt text-gold"></i> {{ $util }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- DESCRIPTION -->
            <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light); padding: 2rem; margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-900); font-weight: 800;">
                    {{ app()->getLocale() === 'ar' ? 'نظرة عامة على العقار' : 'Property Overview' }}
                </h3>
                <p style="color: var(--text-muted); line-height: 1.9; font-size: 1.05rem; white-space: pre-line;">
                    {{ $offer->description ?: (app()->getLocale() === 'ar' ? 'عقار متميز يقع في موقع استراتيجي بمدينة جدة بمواصفات بناء عالية وجودة تشطيب استثنائية توفر أقصى درجات الراحة والفخامة.' : 'Premium property strategically located in Jeddah featuring high-end architectural finishings.') }}
                </p>
            </div>

            <!-- AMENITIES / FEATURES -->
            @if(!empty($offer->features) && count($offer->features) > 0)
                <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light); padding: 2rem; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--primary-900); font-weight: 800;">
                        {{ app()->getLocale() === 'ar' ? 'المزايا والمرافق الفارهة' : 'Features & Luxury Amenities' }}
                    </h3>
                    <div class="amenities-list">
                        @foreach($offer->features as $feature)
                            <div class="amenity-chip">
                                <i class="fa-solid fa-check text-gold"></i>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- VIDEO TOUR (IF AVAILABLE) -->
            @if($offer->video_url)
                <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light); padding: 2rem; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-video text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'فيديو الجولة الافتراضية' : 'Virtual Video Tour' }}</span>
                    </h3>
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 14px;">
                        @php
                            $embedUrl = $offer->video_url;
                            if (str_contains($embedUrl, 'watch?v=')) {
                                $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                            } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $embedUrl);
                            }
                        @endphp
                        <iframe src="{{ $embedUrl }}" style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            <!-- NATIONAL ADDRESS & LOCATION MAP -->
            <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light); padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                    <h3 style="font-size: 1.5rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-map-location-dot text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'العنوان الوطني والموقع الجغرافي' : 'National Address & Location' }}</span>
                    </h3>

                    @if($offer->map_link)
                        <a href="{{ $offer->map_link }}" target="_blank" class="btn-outline-luxury" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'فتح في خرائط جوجل' : 'Open in Google Maps' }}</span>
                        </a>
                    @endif
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; font-size: 0.9rem;">
                    <div style="background: var(--bg-cream); padding: 0.6rem 1rem; border-radius: 8px;">
                        <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">{{ app()->getLocale() === 'ar' ? 'الحي والمدينة:' : 'District / City:' }}</span>
                        <strong style="color: var(--primary-900);">{{ $offer->district }}، {{ $offer->city }}</strong>
                    </div>
                    @if($offer->street_name)
                        <div style="background: var(--bg-cream); padding: 0.6rem 1rem; border-radius: 8px;">
                            <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">{{ app()->getLocale() === 'ar' ? 'الشارع:' : 'Street:' }}</span>
                            <strong style="color: var(--primary-900);">{{ $offer->street_name }}</strong>
                        </div>
                    @endif
                    @if($offer->building_number)
                        <div style="background: var(--bg-cream); padding: 0.6rem 1rem; border-radius: 8px;">
                            <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">{{ app()->getLocale() === 'ar' ? 'رقم المبنى:' : 'Building No:' }}</span>
                            <strong style="color: var(--primary-900);">{{ $offer->building_number }}</strong>
                        </div>
                    @endif
                    @if($offer->postal_code)
                        <div style="background: var(--bg-cream); padding: 0.6rem 1rem; border-radius: 8px;">
                            <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">{{ app()->getLocale() === 'ar' ? 'الرمز البريدي:' : 'Postal Code:' }}</span>
                            <strong style="color: var(--primary-900);">{{ $offer->postal_code }}</strong>
                        </div>
                    @endif
                </div>

                <div id="publicPropertyMap" style="width: 100%; height: 350px; border-radius: 14px; border: 1px solid var(--border-light);"></div>
            </div>
        </div>

        @php
            $agent = $offer->creator;
            $agentName = $agent ? $agent->name : (app()->getLocale() === 'ar' ? 'المسوق العقاري المعتمد' : 'Authorized Listing Agent');
            $agentPhone = $agent && $agent->phone ? $agent->phone : null;
            $cleanPhone = $agentPhone ? preg_replace('/[^0-9]/', '', $agentPhone) : '966501234567';
            if ($agentPhone && str_starts_with($cleanPhone, '05')) {
                $cleanPhone = '966' . substr($cleanPhone, 1);
            } elseif ($agentPhone && str_starts_with($cleanPhone, '5') && strlen($cleanPhone) === 9) {
                $cleanPhone = '966' . $cleanPhone;
            }
        @endphp

        <!-- SIDEBAR / AGENT CONTACT & INQUIRY FORM -->
        <div>
            <div class="inquiry-card">
                <!-- AGENT / CREATOR PROFILE -->
                <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-light);">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, var(--primary-900), var(--primary-800)); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); font-size: 1.35rem; flex-shrink: 0; box-shadow: 0 4px 12px rgba(10, 25, 47, 0.15);">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div style="flex-grow: 1;">
                        <span style="font-size: 0.72rem; color: var(--accent-bronze); font-weight: 800; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ app()->getLocale() === 'ar' ? 'المسوق المعتمد للعقار' : 'Authorized Listing Agent' }}
                        </span>
                        <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin: 2px 0 0;">
                            {{ $agentName }}
                        </h4>
                        @if($agentPhone)
                            <div style="font-size: 0.88rem; color: var(--text-muted); direction: ltr; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-weight: 700; margin-top: 3px;">
                                <i class="fa-solid fa-phone text-gold" style="font-size: 0.75rem;"></i> {{ $agentPhone }}
                            </div>
                        @endif
                    </div>
                </div>

                @if($agentPhone)
                    <!-- DIRECT CALL & WHATSAPP TO THE USER WHO ADDED THE OFFER -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1.25rem;">
                        <a href="tel:{{ $agentPhone }}" class="btn-luxury" style="padding: 0.65rem 0.5rem; font-size: 0.88rem; justify-content: center; text-decoration: none; border-radius: 8px;">
                            <i class="fa-solid fa-phone"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'اتصال بالمسوق' : 'Call Agent' }}</span>
                        </a>

                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('السلام عليكم ورحمة الله، أود الاستفسار بخصوص العرض العقاري: ' . $displayTitle) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: #25D366; color: #fff; font-weight: 700; border-radius: 8px; text-decoration: none; padding: 0.65rem 0.5rem; font-size: 0.88rem;">
                            <i class="fa-brands fa-whatsapp" style="font-size: 1.15rem;"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        </a>
                    </div>
                @endif

                @if(session('inquiry_success'))
                    <div class="alert-success" style="margin-bottom: 1rem; padding: 0.75rem 1rem; border-radius: 8px; background: #dcfce7; color: #15803d; font-size: 0.9rem;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('inquiry_success') }}</span>
                    </div>
                @endif

                <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1.25rem; line-height: 1.6;">
                    {{ app()->getLocale() === 'ar' ? 'هل ترغب في حجز موعد لمعاينة هذا العقار؟ املأ بياناتك وسيتواصل معك المسوق مباشرة.' : 'Interested in this property? Send an inquiry directly to the listing agent to arrange an on-site viewing.' }}
                </p>

                <form action="{{ route('website.inquiry.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_offer_id" value="{{ $offer->id }}">
                    <input type="hidden" name="type" value="buyer">

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الكريم *' : 'Full Name *' }}</label>
                        <input type="text" name="name" required class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: سلطان الحربي' : 'e.g. Sultan Al-Harbi' }}" value="{{ old('name') }}">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الجوال *' : 'Phone Number *' }}</label>
                        <input type="text" name="phone" required class="form-input" placeholder="+966 5X XXX XXXX" value="{{ old('phone') }}">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                        <input type="email" name="email" class="form-input" placeholder="sultan@example.com" value="{{ old('email') }}">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رسالتك أو الموعد المفضل للمعاينة' : 'Your Message' }}</label>
                        <textarea name="message" rows="3" required class="form-textarea" style="width: 100%; border-radius: 8px; border: 1px solid var(--border-light); padding: 0.75rem;">@if(app()->getLocale() === 'ar')أنا مهتم بالعرض العقاري "{{ $displayTitle }}" وأود تنسيق موعد للمعاينة الميدانية أو الحصول على مزيد من التفاصيل.@else I am interested in "{{ $displayTitle }}" and would like to arrange a private viewing or receive more details.@endif</textarea>
                    </div>

                    <button type="submit" class="btn-luxury" style="width: 100%; height: 48px; font-size: 1rem;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'إرسال الطلب للمسوق' : 'Send Inquiry to Agent' }}</span>
                    </button>
                </form>

                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border-light); text-align: center;">
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('السلام عليكم، أود الاستفسار بخصوص العرض: ' . $displayTitle) }}" target="_blank" style="color: #15803d; font-weight: 700; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1.25rem;"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'محادثة مباشرة عبر واتساب' : 'Direct WhatsApp Inquiry' }}@if($agentPhone) ({{ $agentPhone }})@endif</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function swapMainImage(src) {
    const mainImg = document.getElementById('mainGalleryImg');
    if (mainImg) {
        mainImg.src = src;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $offer->latitude ?: 21.543333 }};
    const lng = {{ $offer->longitude ?: 39.172778 }};

    const map = L.map('publicPropertyMap').setView([lat, lng], 14);
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
