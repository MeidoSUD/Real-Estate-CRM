@extends('layouts.website')

@section('title', app()->getLocale() === 'ar' ? 'صفران العقارية | فلل وعقارات فاخرة في جدة' : 'Safran for Real Estate | Luxury Properties in Jeddah, KSA')

@section('styles')
<style>
    .hero-section {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: center;
        background: linear-gradient(180deg, rgba(20, 13, 8, 0.78) 0%, rgba(35, 23, 14, 0.90) 100%),
                    url('{{ asset('images/properties/villa_alshati.jpg') }}') center/cover no-repeat;
        color: #ffffff;
        padding: 5rem 1.5rem;
    }
    .hero-container {
        max-width: 1280px;
        margin: 0 auto;
        width: 100%;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(200, 155, 83, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(200, 155, 83, 0.5);
        color: var(--accent-gold-light);
        padding: 0.4rem 1.1rem;
        border-radius: 9999px;
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    .hero-title {
        font-size: 3.5rem;
        line-height: 1.25;
        max-width: 850px;
        color: #ffffff;
        margin-bottom: 1.5rem;
        font-weight: 900;
    }
    .hero-title span {
        background: linear-gradient(135deg, #dfbe83 0%, #c89b53 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-subtitle {
        font-size: 1.25rem;
        max-width: 720px;
        color: rgba(255, 255, 255, 0.88);
        line-height: 1.8;
        margin-bottom: 2.75rem;
    }
    .search-filter-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(200, 155, 83, 0.3);
        max-width: 1100px;
    }
    .search-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr) auto;
        gap: 1.25rem;
        align-items: end;
    }
    .stats-bar {
        background: #ffffff;
        border-bottom: 1px solid var(--border-light);
        padding: 2.5rem 1.5rem;
    }
    .stats-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        text-align: center;
    }
    .stat-number {
        font-size: 2.6rem;
        font-weight: 900;
        color: var(--primary-900);
        margin-bottom: 0.25rem;
    }
    .stat-label {
        font-size: 0.92rem;
        color: var(--text-muted);
        font-weight: 700;
    }
    .section-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 3.5rem;
    }
    .section-subtitle {
        color: var(--accent-bronze);
        font-weight: 800;
        font-size: 0.92rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    .section-title {
        font-size: 2.5rem;
        color: var(--primary-900);
        line-height: 1.25;
        font-weight: 900;
    }
    .properties-grid {
        max-width: 1280px;
        margin: 0 auto;
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
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
    .district-card {
        position: relative;
        height: 280px;
        border-radius: 20px;
        overflow: hidden;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.75rem;
        box-shadow: var(--shadow-card);
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease;
    }
    .district-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(20, 13, 8, 0.1) 0%, rgba(20, 13, 8, 0.88) 100%);
    }
    .district-card:hover {
        transform: translateY(-5px);
    }
    .district-content {
        position: relative;
        z-index: 1;
    }
    @media (max-width: 992px) {
        .hero-title { font-size: 2.6rem; }
        .search-grid { grid-template-columns: 1fr 1fr; }
        .properties-grid { grid-template-columns: 1fr 1fr; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .hero-title { font-size: 2.1rem; }
        .search-grid { grid-template-columns: 1fr; }
        .properties-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-badge">
            <i class="fa-solid fa-crown"></i>
            {{ app()->getLocale() === 'ar' ? 'العقارات الفاخرة والاستثمارية الأولى في جدة' : 'Premier Real Estate in Jeddah, Saudi Arabia' }}
        </div>
        <h1 class="hero-title">
            @if(app()->getLocale() === 'ar')
                عيش الفخامة الاستثنائية في أرقى أحياء <span>عروس البحر الأحمر</span>
            @else
                Exceptional Living in <span>Jeddah's</span> Most Prestigious Destinations
            @endif
        </h1>
        <p class="hero-subtitle">
            @if(app()->getLocale() === 'ar')
                من الفلل الساحلية الأيقونية في حي الشاطئ وأبحر، إلى البنتهاوس البانورامي بإطلالة كورنيش جدة ونافورة الملك فهد. تشكيلة عروض معتمدة يجمعها فريق التسويق ويخدمها فريق خدمة العملاء على مدار الساعة.
            @else
                From iconic waterfront villas in Al-Shati to sky residences with unobstructed Red Sea views, discover premier real estate curated by our specialized marketing and advisory team.
            @endif
        </p>

        <!-- SEARCH QUICK FILTER BAR -->
        <div class="search-filter-card">
            <form action="{{ route('website.offers') }}" method="GET">
                <div class="search-grid">
                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار' : 'Property Type' }}</label>
                        <select name="type" class="form-select">
                            <option value="all">{{ app()->getLocale() === 'ar' ? 'جميع أنواع العقارات' : 'All Property Types' }}</option>
                            <option value="Villa">{{ app()->getLocale() === 'ar' ? 'فيلا فاخرة' : 'Luxury Villa' }}</option>
                            <option value="Apartment">{{ app()->getLocale() === 'ar' ? 'شقة مودرن' : 'Modern Apartment' }}</option>
                            <option value="Penthouse">{{ app()->getLocale() === 'ar' ? 'بنتهاوس بانورامي' : 'Sky Penthouse' }}</option>
                            <option value="Commercial">{{ app()->getLocale() === 'ar' ? 'مكتب تجاري' : 'Commercial Office' }}</option>
                            <option value="Land">{{ app()->getLocale() === 'ar' ? 'أرض مميزة' : 'Prime Land' }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الغرض' : 'Purpose' }}</label>
                        <select name="purpose" class="form-select">
                            <option value="all">{{ app()->getLocale() === 'ar' ? 'للبيع والإيجار' : 'Sale & Rent' }}</option>
                            <option value="sale">{{ app()->getLocale() === 'ar' ? 'للبيع' : 'For Sale' }}</option>
                            <option value="rent">{{ app()->getLocale() === 'ar' ? 'للإيجار' : 'For Rent' }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الحي في جدة' : 'Jeddah District' }}</label>
                        <select name="district" class="form-select">
                            <option value="all">{{ app()->getLocale() === 'ar' ? 'جميع الأحياء' : 'All Districts' }}</option>
                            <option value="Al-Shati">{{ app()->getLocale() === 'ar' ? 'حي الشاطئ' : 'Al-Shati' }}</option>
                            <option value="Al-Rawdah">{{ app()->getLocale() === 'ar' ? 'حي الروضة' : 'Al-Rawdah' }}</option>
                            <option value="Al-Hamra">{{ app()->getLocale() === 'ar' ? 'حي الحمراء والكورنيش' : 'Al-Hamra' }}</option>
                            <option value="Obhur Al-Shamaliyah">{{ app()->getLocale() === 'ar' ? 'أبحر الشمالية' : 'Obhur' }}</option>
                            <option value="Al-Salama">{{ app()->getLocale() === 'ar' ? 'حي السلامة / طريق الملك' : 'Al-Salama' }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'النطاق السعري' : 'Price Range' }}</label>
                        <select name="max_price" class="form-select">
                            <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الأسعار' : 'Any Price' }}</option>
                            <option value="2000000">{{ app()->getLocale() === 'ar' ? 'حتى 2 مليون ر.س' : 'Up to 2M SAR' }}</option>
                            <option value="5000000">{{ app()->getLocale() === 'ar' ? 'حتى 5 مليون ر.س' : 'Up to 5M SAR' }}</option>
                            <option value="10000000">{{ app()->getLocale() === 'ar' ? 'حتى 10 مليون ر.س' : 'Up to 10M SAR' }}</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn-luxury" style="width: 100%; height: 46px;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'ابحث الآن' : 'Search' }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- STATS BAR -->
<div class="stats-bar">
    <div class="stats-grid">
        <div>
            <div class="stat-number">16+</div>
            <div class="stat-label">{{ app()->getLocale() === 'ar' ? 'عاماً من الخبرة بجدة' : 'Years In Jeddah Market' }}</div>
        </div>
        <div>
            <div class="stat-number">850+</div>
            <div class="stat-label">{{ app()->getLocale() === 'ar' ? 'صفقة عقارية موثقة' : 'Completed Deals' }}</div>
        </div>
        <div>
            <div class="stat-number">2.4B+</div>
            <div class="stat-label">{{ app()->getLocale() === 'ar' ? 'ريال سعودي محفظة العروض' : 'SAR In Managed Portfolio' }}</div>
        </div>
        <div>
            <div class="stat-number">99%</div>
            <div class="stat-label">{{ app()->getLocale() === 'ar' ? 'نسبة رضا العملاء' : 'Client Satisfaction' }}</div>
        </div>
    </div>
</div>

<!-- FEATURED OFFERS SECTION -->
<section style="padding: 5.5rem 1.5rem; background-color: var(--bg-cream);">
    <div style="max-width: 1280px; margin: 0 auto;">
        <div class="section-header">
            <span class="section-subtitle">{{ app()->getLocale() === 'ar' ? 'عروض حصرية مختارة' : 'Handpicked Showcase' }}</span>
            <h2 class="section-title">{{ app()->getLocale() === 'ar' ? 'أحدث العروض العقارية المتاحة' : 'Featured Property Offers' }}</h2>
            <p style="color: var(--text-muted); margin-top: 0.75rem; font-size: 1.05rem;">
                {{ app()->getLocale() === 'ar' ? 'استكشف الفلل والشقق الفاخرة الجاهزة للتسليم والمعاينة المباشرة في أفضل مناطق جدة.' : 'Explore top-tier verified properties available for immediate acquisition in prime Jeddah neighborhoods.' }}
            </p>
        </div>

        <div class="properties-grid">
            @forelse($featuredOffers as $offer)
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
                            <a href="{{ route('website.offers.show', $offer->slug) }}" class="btn-outline-luxury" style="width: 100%; text-align: center;">
                                <span>{{ app()->getLocale() === 'ar' ? 'تفاصيل العقار والمعاينة' : 'View Property Details' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #ffffff; border-radius: 16px;">
                    <p style="color: var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'لا توجد عروض مميزة حالياً.' : 'No featured offers currently available.' }}</p>
                </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="{{ route('website.offers') }}" class="btn-luxury" style="padding: 0.85rem 2.2rem; font-size: 1rem;">
                <span>{{ app()->getLocale() === 'ar' ? 'استعراض كافة العروض والوحدات' : 'View All Properties' }}</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- JEDDAH DISTRICTS HIGHLIGHT -->
<section style="padding: 5rem 1.5rem; background: #ffffff;">
    <div style="max-width: 1280px; margin: 0 auto;">
        <div class="section-header">
            <span class="section-subtitle">{{ app()->getLocale() === 'ar' ? 'نطاق تخصصنا الجغرافي' : 'Locations We Specialize In' }}</span>
            <h2 class="section-title">{{ app()->getLocale() === 'ar' ? 'أحياء جدة الأكثر طلباً وتميزاً' : 'Prime Jeddah Districts' }}</h2>
            <p style="color: var(--text-muted); margin-top: 0.75rem;">
                {{ app()->getLocale() === 'ar' ? 'تغطية عقارية حصرية وشاملة لأرقى الوجهات الساحلية والسكنية في جدة.' : 'Strategic real estate positioning across Jeddah most prestigious coastal and urban hubs.' }}
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem;">
            <div class="district-card" style="background-image: url('{{ asset('images/properties/villa_alshati.jpg') }}');">
                <div class="district-content">
                    <span class="badge-gold" style="margin-bottom: 0.5rem;">{{ app()->getLocale() === 'ar' ? 'نخبة الواجهة البحرية' : 'Coastal Elite' }}</span>
                    <h3 style="color: #ffffff; font-size: 1.7rem; margin-bottom: 0.35rem;">{{ app()->getLocale() === 'ar' ? 'حي الشاطئ' : 'Al-Shati District' }}</h3>
                    <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.85);">{{ app()->getLocale() === 'ar' ? 'قصور وفلل فخمة وقرب مباشر من البحر الأحمر وأشهر المماشي.' : 'Palatial beachfront mansions, private marina access, and tranquil serenity.' }}</p>
                </div>
            </div>

            <div class="district-card" style="background-image: url('{{ asset('images/properties/residences_rawdah.jpg') }}');">
                <div class="district-content">
                    <span class="badge-gold" style="margin-bottom: 0.5rem;">{{ app()->getLocale() === 'ar' ? 'قلب جدة الراقي' : 'Urban Elegance' }}</span>
                    <h3 style="color: #ffffff; font-size: 1.7rem; margin-bottom: 0.35rem;">{{ app()->getLocale() === 'ar' ? 'حي الروضة' : 'Al-Rawdah District' }}</h3>
                    <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.85);">{{ app()->getLocale() === 'ar' ? 'مجمعات سكنية فاخرة وموقع حيوي استراتيجي بالقرب من المطاعم والخدمات.' : 'Fine dining, upscale residential avenues, and central accessibility.' }}</p>
                </div>
            </div>

            <div class="district-card" style="background-image: url('{{ asset('images/properties/penthouse_corniche.jpg') }}');">
                <div class="district-content">
                    <span class="badge-gold" style="margin-bottom: 0.5rem;">{{ app()->getLocale() === 'ar' ? 'إطلالة الكورنيش والنافورة' : 'Waterfront Skyline' }}</span>
                    <h3 style="color: #ffffff; font-size: 1.7rem; margin-bottom: 0.35rem;">{{ app()->getLocale() === 'ar' ? 'الكورنيش وحي الحمراء' : 'Corniche & Al-Hamra' }}</h3>
                    <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.85);">{{ app()->getLocale() === 'ar' ? 'بنتهاوس وأبراج سكنية بإطلالة ساحرة ومباشرة على نافورة الملك فهد.' : 'Iconic sea views, luxury penthouses, and proximity to King Fahds Fountain.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AGENCY CALL TO ACTION -->
<section style="padding: 5rem 1.5rem; background: linear-gradient(135deg, var(--primary-900) 0%, var(--primary-800) 100%); color: #ffffff;">
    <div style="max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div>
            <span class="hero-badge"><i class="fa-solid fa-shield-halved"></i> {{ app()->getLocale() === 'ar' ? 'منظومة عمل متكاملة' : 'Dedicated Teams' }}</span>
            <h2 style="color: #ffffff; font-size: 2.5rem; line-height: 1.35; margin-bottom: 1.5rem; font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'تناغم تام بين فريق التسويق وفريق خدمة العملاء' : 'A Seamless Synergy Between Marketing & Client Care' }}
            </h2>
            <p style="color: rgba(255, 255, 255, 0.85); font-size: 1.05rem; line-height: 1.8; margin-bottom: 2rem;">
                {{ app()->getLocale() === 'ar' ? 'تأسست شركتنا بجدة لتقديم معايير وساطة احترافية ترتكز على الدقة والسرعة. يقوم فريق التسويق بتجميع العروض وفحص وثائقها ومطابقتها للمعايير النظامية، بينما يتولى فريق خدمة العملاء التواصل المباشر مع ملاك العقارات والمشترين وتنسيق المعاينات وإتمام الصفقات بكل موثوقية.' : 'Our real estate firm in Jeddah is structured for complete transparency. Our Marketing Team collects and showcases verified offers, while Customer Service directly connects owners with buyers.' }}
            </p>

            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; max-width: 270px;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(200, 155, 83, 0.2); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); flex-shrink: 0;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.2rem;">{{ app()->getLocale() === 'ar' ? 'عقود وساطة موثقة' : 'Verified REGA Deeds' }}</h4>
                        <p style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.75);">{{ app()->getLocale() === 'ar' ? 'مطابقة تامة لمتطلبات الهيئة العامة للعقار (فال).' : 'Full compliance with Saudi real estate standards.' }}</p>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.75rem; max-width: 270px;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(200, 155, 83, 0.2); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); flex-shrink: 0;">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.2rem;">{{ app()->getLocale() === 'ar' ? 'متابعة مباشرة مع الملاك' : 'Direct Owner Care' }}</h4>
                        <p style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.75);">{{ app()->getLocale() === 'ar' ? 'تنسيق فوري للمعاينة والمفاوضات العادلة.' : 'Around the clock coordination for VIP owners & buyers.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(200, 155, 83, 0.3); border-radius: 24px; padding: 2.5rem; text-align: center;">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-bronze), var(--accent-gold)); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: #ffffff;">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <h3 style="color: #ffffff; font-size: 1.8rem; margin-bottom: 0.75rem;">
                {{ app()->getLocale() === 'ar' ? 'هل تملك عقاراً ترغب في عرضه بجدة؟' : 'List Your Property With Us' }}
            </h3>
            <p style="color: rgba(255, 255, 255, 0.85); margin-bottom: 2rem; font-size: 0.98rem; line-height: 1.7;">
                {{ app()->getLocale() === 'ar' ? 'سواء كنت مالكاً لفيلا سكنية، أو عمارة استثمارية، أو أرض تجارية، يسعد فريقنا بتقييم عقارك وتسويقه لأفضل المشترين والمستثمرين.' : 'Are you an owner with a villa, building, or land plot in Jeddah? Connect with our advisory desk to get an immediate valuation and listing.' }}
            </p>
            <a href="{{ route('website.contact') }}" class="btn-luxury" style="padding: 0.85rem 2rem; font-size: 1rem;">
                <i class="fa-solid fa-paper-plane"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'تسجيل طلب عرض عقار' : 'Submit Property Details' }}</span>
            </a>
        </div>
    </div>
</section>
@endsection
