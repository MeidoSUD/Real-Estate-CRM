@extends('layouts.website')

@section('title', app()->getLocale() === 'ar' ? 'العروض العقارية المتاحة بجدة | صفران العقارية' : 'Exclusive Property Offers & Listings | Safran Real Estate')

@section('styles')
<style>
    .offers-hero {
        background: linear-gradient(180deg, var(--primary-950) 0%, var(--primary-900) 100%);
        color: #ffffff;
        padding: 4.5rem 1.5rem 3.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(200, 155, 83, 0.2);
    }
    .filter-wrapper {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        padding: 1.75rem;
        margin-top: -2.5rem;
        margin-bottom: 3.5rem;
        position: relative;
        z-index: 10;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .property-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .property-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(200, 155, 83, 0.4);
    }
    .property-img-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    .property-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .property-card:hover .property-img {
        transform: scale(1.05);
    }
    .property-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .property-price {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--primary-900);
        margin-bottom: 0.5rem;
    }
    .property-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-900);
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }
    .property-location {
        color: var(--text-muted);
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
        font-weight: 600;
    }
    .property-specs {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid var(--border-light);
        margin-top: auto;
        color: var(--primary-700);
        font-size: 0.88rem;
        font-weight: 700;
    }
    .spec-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    @media (max-width: 1024px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
        .properties-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 650px) {
        .filter-grid { grid-template-columns: 1fr; }
        .properties-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- OFFERS HEADER -->
<div class="offers-hero">
    <div style="max-width: 800px; margin: 0 auto;">
        <span class="badge-gold" style="margin-bottom: 1rem;"><i class="fa-solid fa-building"></i> {{ app()->getLocale() === 'ar' ? 'عقارات معتمدة وموثقة' : 'Verified Properties' }}</span>
        <h1 style="color: #ffffff; font-size: 2.8rem; margin-bottom: 1rem; font-weight: 900;">
            {{ app()->getLocale() === 'ar' ? 'العروض والوحدات العقارية في جدة' : 'Real Estate Offers in Jeddah' }}
        </h1>
        <p style="color: rgba(255, 255, 255, 0.85); font-size: 1.1rem; line-height: 1.7;">
            {{ app()->getLocale() === 'ar' ? 'استكشف أحدث الفلل السكنية والعمائر والشقق الفاخرة المجمعة والمدققة بواسطة فريق التسويق.' : 'Discover exclusive villas, sea-view penthouses, and commercial plots listed and managed by our marketing specialists.' }}
        </p>
    </div>
</div>

<div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem 5rem;">
    <!-- FILTER BAR -->
    <div class="filter-wrapper">
        <form action="{{ route('website.offers') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البحث بالاسم أو الموقع' : 'Search Keyword / Location' }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: الشاطئ، فيلا، مسبح...' : 'e.g. Al-Shati, Penthouse, Pool...' }}">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار' : 'Property Type' }}</label>
                    <select name="type" class="form-select">
                        <option value="all">{{ app()->getLocale() === 'ar' ? 'كافة الأنواع' : 'All Types' }}</option>
                        <option value="Villa" {{ request('type') == 'Villa' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'فيلا' : 'Villa' }}</option>
                        <option value="Apartment" {{ request('type') == 'Apartment' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'شقة' : 'Apartment' }}</option>
                        <option value="Penthouse" {{ request('type') == 'Penthouse' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'بنتهاوس' : 'Penthouse' }}</option>
                        <option value="Commercial" {{ request('type') == 'Commercial' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'تجاري' : 'Commercial' }}</option>
                        <option value="Land" {{ request('type') == 'Land' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أرض' : 'Land' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الغرض' : 'Purpose' }}</label>
                    <select name="purpose" class="form-select">
                        <option value="all">{{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}</option>
                        <option value="sale" {{ request('purpose') == 'sale' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'للبيع' : 'For Sale' }}</option>
                        <option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'للإيجار' : 'For Rent' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الحي' : 'District' }}</label>
                    <select name="district" class="form-select">
                        <option value="all">{{ app()->getLocale() === 'ar' ? 'كافة الأحياء' : 'All Districts' }}</option>
                        @foreach($districts as $dst)
                            @php
                                $dName = [
                                    'Al-Shati' => 'حي الشاطئ',
                                    'Al-Rawdah' => 'حي الروضة',
                                    'Al-Hamra' => 'حي الحمراء',
                                    'Obhur Al-Shamaliyah' => 'أبحر الشمالية',
                                    'Al-Salama' => 'حي السلامة',
                                ][$dst] ?? $dst;
                            @endphp
                            <option value="{{ $dst }}" {{ request('district') == $dst ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? $dName : $dst }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الحد الأقصى للسعر' : 'Max Price' }}</label>
                    <select name="max_price" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? 'دون تحديد' : 'No Limit' }}</option>
                        <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'حتى 2 مليون' : 'Up to 2M SAR' }}</option>
                        <option value="5000000" {{ request('max_price') == '5000000' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'حتى 5 مليون' : 'Up to 5M SAR' }}</option>
                        <option value="10000000" {{ request('max_price') == '10000000' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'حتى 10 مليون' : 'Up to 10M SAR' }}</option>
                    </select>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-luxury" style="height: 44px; padding: 0 1.25rem;">
                        <i class="fa-solid fa-filter"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'تصفية' : 'Filter' }}</span>
                    </button>
                    @if(request()->hasAny(['search', 'type', 'purpose', 'district', 'max_price']))
                        <a href="{{ route('website.offers') }}" class="btn-outline-luxury" style="height: 44px; padding: 0 0.85rem;" title="{{ app()->getLocale() === 'ar' ? 'إعادة ضبط الفلاتر' : 'Reset' }}">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- OFFERS COUNT -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <p style="font-size: 0.95rem; color: var(--text-muted); font-weight: 600;">
            {{ app()->getLocale() === 'ar' ? 'يتم عرض' : 'Showing' }} <strong style="color: var(--primary-900);">{{ $offers->total() }}</strong> {{ app()->getLocale() === 'ar' ? 'عقار معتمد ومتاح حالياً في جدة' : 'verified properties in Jeddah' }}
        </p>
    </div>

    <!-- PROPERTIES GRID -->
    <div class="properties-grid">
        @forelse($offers as $offer)
            @php
                $displayTitle = (app()->getLocale() === 'ar' && !empty($offer->title_ar)) ? $offer->title_ar : $offer->title;
                $districtAr = [
                    'Al-Shati' => 'حي الشاطئ',
                    'Al-Rawdah' => 'حي الروضة',
                    'Al-Hamra' => 'حي الحمراء',
                    'Obhur Al-Shamaliyah' => 'أبحر الشمالية',
                    'Al-Salama' => 'حي السلامة',
                ][$offer->district] ?? $offer->district;
            @endphp
            <div class="property-card">
                <div class="property-img-wrapper">
                    <img src="{{ asset($offer->main_image) }}" alt="{{ $displayTitle }}" class="property-img">
                    <span class="property-type-tag">
                        @if(app()->getLocale() === 'ar')
                            {{ $offer->property_type === 'Villa' ? 'فيلا' : ($offer->property_type === 'Penthouse' ? 'بنتهاوس' : ($offer->property_type === 'Apartment' ? 'شقة' : $offer->property_type)) }}
                        @else
                            {{ $offer->property_type }}
                        @endif
                    </span>
                    <span class="property-purpose-tag">
                        {{ app()->getLocale() === 'ar' ? ($offer->purpose === 'sale' ? 'للبيع' : 'للإيجار') : 'For ' . ucfirst($offer->purpose) }}
                    </span>
                </div>

                <div class="property-content">
                    <div class="property-price">
                        {{ number_format($offer->price) }}
                        <span style="font-size: 0.95rem; font-weight: 700; color: var(--accent-bronze);">
                            {{ app()->getLocale() === 'ar' ? 'ريال سعودي' : 'SAR' }}
                        </span>
                    </div>

                    <h3 class="property-title">
                        <a href="{{ route('website.offers.show', $offer->slug) }}">{{ $displayTitle }}</a>
                    </h3>

                    <div class="property-location">
                        <i class="fa-solid fa-location-dot text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? $districtAr . '، جدة' : $offer->district . ', Jeddah' }}</span>
                    </div>

                    <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $offer->description }}
                    </p>

                    <div class="property-specs">
                        @if($offer->bedrooms)
                            <div class="spec-item"><i class="fa-solid fa-bed text-gold"></i> {{ $offer->bedrooms }} {{ app()->getLocale() === 'ar' ? 'غرف' : 'Beds' }}</div>
                        @endif
                        @if($offer->bathrooms)
                            <div class="spec-item"><i class="fa-solid fa-bath text-gold"></i> {{ $offer->bathrooms }} {{ app()->getLocale() === 'ar' ? 'حمامات' : 'Baths' }}</div>
                        @endif
                        <div class="spec-item"><i class="fa-solid fa-ruler-combined text-gold"></i> {{ number_format($offer->area_sqm) }} م²</div>
                    </div>

                    <div style="margin-top: 1.25rem;">
                        <a href="{{ route('website.offers.show', $offer->slug) }}" class="btn-luxury" style="width: 100%; text-align: center;">
                            <span>{{ app()->getLocale() === 'ar' ? 'عرض تفاصيل العقار' : 'View Full Listing' }}</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--border-light);">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 3rem; color: var(--accent-bronze); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">{{ app()->getLocale() === 'ar' ? 'لم يتم العثور على عقارات مطابقة' : 'No properties found' }}</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">{{ app()->getLocale() === 'ar' ? 'يرجى تجربة معايير بحث أخرى أو إعادة ضبط الفلاتر.' : 'Try adjusting your search criteria or resetting filters.' }}</p>
                <a href="{{ route('website.offers') }}" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء الفلاتر' : 'Clear All Filters' }}</a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div style="margin-top: 3.5rem;">
        {{ $offers->links() }}
    </div>
</div>
@endsection
