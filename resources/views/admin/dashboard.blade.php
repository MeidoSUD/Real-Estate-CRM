@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'لوحة التحكم التنفيذية' : 'Executive Dashboard')
@section('page_title', app()->getLocale() === 'ar' ? 'لوحة المتابعة والتحكم العقاري' : 'Real Estate Executive Dashboard')

@section('content')
<!-- KPI STAT CARDS -->
<div class="form-grid-4" style="margin-bottom: 2rem;">
    <!-- CARD 1 -->
    <div class="luxury-card card-border-accent" style="padding: 1.5rem; border-inline-start: 4px solid var(--accent-bronze);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                    {{ app()->getLocale() === 'ar' ? 'العروض المتاحة' : 'Available Offers' }}
                </span>
                <h3 style="font-size: 2.2rem; font-weight: 900; color: var(--primary-900);">
                    {{ $stats['available_offers'] }}
                </h3>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(163, 105, 57, 0.12); display: flex; align-items: center; justify-content: center; color: var(--accent-bronze); font-size: 1.25rem; flex-shrink: 0;">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>
        <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">
            <strong style="color: var(--primary-900);">{{ $stats['total_offers'] }}</strong> {{ app()->getLocale() === 'ar' ? 'إجمالي العقارات المسجلة' : 'total listings registered' }}
        </div>
    </div>

    <!-- CARD 2 -->
    <div class="luxury-card card-border-accent" style="padding: 1.5rem; border-inline-start: 4px solid var(--accent-gold);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                    {{ app()->getLocale() === 'ar' ? 'قيمة المحفظة النشطة (ر.س)' : 'Active Portfolio (SAR)' }}
                </span>
                <h3 style="font-size: 1.8rem; font-weight: 900; color: var(--primary-900);">
                    {{ number_format($stats['total_portfolio_value'] / 1000000, 1) }} {{ app()->getLocale() === 'ar' ? 'مليون ر.س' : 'M' }}
                </h3>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(200, 155, 83, 0.15); display: flex; align-items: center; justify-content: center; color: var(--accent-gold); font-size: 1.25rem; flex-shrink: 0;">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
        <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">
            {{ app()->getLocale() === 'ar' ? 'إجمالي قيمة الوحدات المعروضة بجدة' : 'Total inventory valuation in Jeddah' }}
        </div>
    </div>

    <!-- CARD 3 -->
    <div class="luxury-card card-border-accent" style="padding: 1.5rem; border-inline-start: 4px solid #10b981;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                    {{ app()->getLocale() === 'ar' ? 'طلبات خدمة العملاء' : 'Customer Leads' }}
                </span>
                <h3 style="font-size: 2.2rem; font-weight: 900; color: var(--primary-900);">
                    {{ $stats['total_leads'] }}
                </h3>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 1.25rem; flex-shrink: 0;">
                <i class="fa-solid fa-headset"></i>
            </div>
        </div>
        <div style="font-size: 0.82rem; color: #047857; font-weight: 600;">
            <i class="fa-solid fa-bell"></i> <strong>{{ $stats['new_leads'] }}</strong> {{ app()->getLocale() === 'ar' ? 'طلب جديد بحاجة للمتابعة' : 'pending customer inquiries' }}
        </div>
    </div>

    <!-- CARD 4 -->
    <div class="luxury-card card-border-accent" style="padding: 1.5rem; border-inline-start: 4px solid var(--primary-800);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                    {{ app()->getLocale() === 'ar' ? 'فريق العمل والوسطاء' : 'Staff & Agents' }}
                </span>
                <h3 style="font-size: 2.2rem; font-weight: 900; color: var(--primary-900);">
                    {{ $stats['total_users'] }}
                </h3>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(36, 24, 16, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-900); font-size: 1.25rem; flex-shrink: 0;">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">
            <strong style="color: #10b981;">{{ $stats['active_users'] }}</strong> {{ app()->getLocale() === 'ar' ? 'عضو نشط بالمنظومة' : 'active team members' }}
        </div>
    </div>
</div>

<!-- ANALYTICS ROW -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- RECENT LEADS -->
    <div class="luxury-card" style="padding: 1.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h3 style="font-size: 1.25rem; color: var(--primary-900); font-weight: 800;">
                    {{ app()->getLocale() === 'ar' ? 'أحدث طلبات خدمة العملاء الواردة' : 'Incoming Customer Care Leads' }}
                </h3>
                <span style="font-size: 0.82rem; color: var(--text-muted);">
                    {{ app()->getLocale() === 'ar' ? 'استفسارات الملاك والمشترين من الموقع العام' : 'Owners & Buyers contacting from website' }}
                </span>
            </div>
            @if(auth()->user()->hasPermission('leads.view') || auth()->user()->isAdmin())
                <a href="{{ route('admin.leads.index') }}" class="btn-outline-luxury btn-sm">
                    {{ app()->getLocale() === 'ar' ? 'كافة الطلبات' : 'View All Leads' }}
                </a>
            @endif
        </div>

        <div class="luxury-table-container">
            <table class="luxury-table">
                <thead>
                    <tr>
                        <th>{{ app()->getLocale() === 'ar' ? 'العميل' : 'Client' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'صفة الطلب' : 'Type' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'رقم الاتصال' : 'Phone' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'التوقيت' : 'Date' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLeads as $lead)
                        <tr>
                            <td>
                                <strong style="color: var(--primary-900); font-size: 0.95rem;">{{ $lead->name }}</strong>
                                @if($lead->email)
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">{{ $lead->email }}</div>
                                @endif
                            </td>
                            <td>
                                @if($lead->type === 'owner')
                                    <span class="badge-dark"><i class="fa-solid fa-key text-gold"></i> {{ app()->getLocale() === 'ar' ? 'مالك عقار' : 'Owner' }}</span>
                                @elseif($lead->type === 'buyer')
                                    <span class="badge-gold"><i class="fa-solid fa-cart-shopping"></i> {{ app()->getLocale() === 'ar' ? 'مشتري / مستثمر' : 'Buyer' }}</span>
                                @else
                                    <span class="badge-info">{{ app()->getLocale() === 'ar' ? 'استفسار عام' : 'Inquiry' }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="tel:{{ $lead->phone }}" style="color: var(--accent-bronze); font-weight: 700; direction: ltr; display: inline-block;">
                                    {{ $lead->phone }}
                                </a>
                            </td>
                            <td>
                                @if($lead->status === 'new')
                                    <span class="badge-warning">{{ app()->getLocale() === 'ar' ? 'جديد' : 'New' }}</span>
                                @elseif($lead->status === 'contacted')
                                    <span class="badge-info">{{ app()->getLocale() === 'ar' ? 'تم التواصل' : 'Contacted' }}</span>
                                @elseif($lead->status === 'in_progress')
                                    <span class="badge-gold">{{ app()->getLocale() === 'ar' ? 'قيد المتابعة' : 'In Progress' }}</span>
                                @elseif($lead->status === 'closed')
                                    <span class="badge-success">{{ app()->getLocale() === 'ar' ? 'مكتمل' : 'Closed' }}</span>
                                @else
                                    <span class="badge-dark">{{ $lead->status }}</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $lead->created_at->locale(app()->getLocale())->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد طلبات واردة حالياً.' : 'No inquiries logged yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- DISTRICT BREAKDOWN & SEGMENTATION -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="luxury-card" style="padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; color: var(--primary-900); margin-bottom: 1rem; font-weight: 800;">
                <i class="fa-solid fa-location-dot text-gold" style="margin-inline-end: 0.4rem;"></i>
                {{ app()->getLocale() === 'ar' ? 'توزيع العروض حسب أحياء جدة' : 'Jeddah District Portfolio' }}
            </h3>
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                @foreach($districtsBreakdown as $d)
                    @php
                        $dName = [
                            'Al-Shati' => 'حي الشاطئ',
                            'Al-Rawdah' => 'حي الروضة',
                            'Al-Hamra' => 'حي الحمراء',
                            'Obhur Al-Shamaliyah' => 'أبحر الشمالية',
                            'Al-Salama' => 'حي السلامة',
                        ][$d->district] ?? $d->district;
                    @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.88rem; margin-bottom: 0.25rem;">
                            <span style="font-weight: 700; color: var(--primary-900);">
                                {{ app()->getLocale() === 'ar' ? $dName : $d->district }}
                            </span>
                            <span style="color: var(--accent-bronze); font-weight: 800;">
                                {{ $d->count }} {{ app()->getLocale() === 'ar' ? 'عقارات' : 'properties' }}
                            </span>
                        </div>
                        <div style="height: 6px; background: var(--primary-50); border-radius: 999px; overflow: hidden;">
                            <div style="height: 100%; width: {{ min(100, $d->count * 30) }}%; background: linear-gradient(90deg, var(--accent-bronze), var(--accent-gold));"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="luxury-card" style="padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; color: var(--primary-900); margin-bottom: 1rem; font-weight: 800;">
                <i class="fa-solid fa-chart-pie text-gold" style="margin-inline-end: 0.4rem;"></i>
                {{ app()->getLocale() === 'ar' ? 'تصنيف الطلبات الواردة' : 'Inquiry Segmentation' }}
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); gap: 0.75rem; text-align: center;">
                <div style="background: var(--primary-50); padding: 0.85rem; border-radius: 12px; border: 1px solid var(--border-light);">
                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--primary-900);">{{ $leadsByType['buyer'] }}</div>
                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'مشترين' : 'Buyers' }}</div>
                </div>
                <div style="background: var(--primary-50); padding: 0.85rem; border-radius: 12px; border: 1px solid var(--border-light);">
                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--primary-900);">{{ $leadsByType['owner'] }}</div>
                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'ملاك عقار' : 'Owners' }}</div>
                </div>
                <div style="background: var(--primary-50); padding: 0.85rem; border-radius: 12px; border: 1px solid var(--border-light);">
                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--primary-900);">{{ $leadsByType['inquiry'] }}</div>
                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'استفسار' : 'General' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RECENT OFFERS -->
<div class="luxury-card" style="padding: 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
            <h3 style="font-size: 1.25rem; color: var(--primary-900); font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'أحدث العروض العقارية المضافة' : 'Recently Added Property Offers' }}
            </h3>
            <span style="font-size: 0.82rem; color: var(--text-muted);">
                {{ app()->getLocale() === 'ar' ? 'مجمعة ومدققة بواسطة فريق التسويق' : 'Managed by the Marketing Team' }}
            </span>
        </div>
        @if(auth()->user()->hasPermission('offers.view') || auth()->user()->isAdmin())
            <a href="{{ route('admin.offers.index') }}" class="btn-outline-luxury btn-sm">
                {{ app()->getLocale() === 'ar' ? 'كافة العروض' : 'All Offers' }}
            </a>
        @endif
    </div>

    <div class="luxury-table-container">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'ar' ? 'العقار' : 'Property' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'النوع والغرض' : 'Type & Purpose' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحي بجدة' : 'District' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'السعر المطلوب' : 'Price (SAR)' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'أضيف بواسطة' : 'Listed By' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOffers as $offer)
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
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.85rem;">
                                <img src="{{ asset($offer->main_image) }}" alt="" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-light); flex-shrink: 0;">
                                <div>
                                    <strong style="color: var(--primary-900); font-size: 0.95rem;">{{ $displayTitle }}</strong>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">{{ number_format($offer->area_sqm) }} م² • {{ $offer->bedrooms ?? 0 }} {{ app()->getLocale() === 'ar' ? 'غرف' : 'Beds' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-dark">
                                @if(app()->getLocale() === 'ar')
                                    {{ $offer->property_type === 'Villa' ? 'فيلا' : ($offer->property_type === 'Penthouse' ? 'بنتهاوس' : ($offer->property_type === 'Apartment' ? 'شقة' : $offer->property_type)) }}
                                @else
                                    {{ $offer->property_type }}
                                @endif
                            </span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.2rem;">
                                {{ app()->getLocale() === 'ar' ? ($offer->purpose === 'sale' ? 'للبيع' : 'للإيجار') : 'For ' . ucfirst($offer->purpose) }}
                            </span>
                        </td>
                        <td>
                            <i class="fa-solid fa-location-dot text-gold" style="font-size: 0.8rem;"></i>
                            {{ app()->getLocale() === 'ar' ? $districtAr : $offer->district }}
                        </td>
                        <td>
                            <strong style="color: var(--primary-900); font-size: 1.05rem;">
                                {{ number_format($offer->price) }}
                            </strong>
                            <span style="font-size: 0.8rem; color: var(--accent-bronze); font-weight: 700;">
                                {{ app()->getLocale() === 'ar' ? 'ر.س' : 'SAR' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-success">
                                {{ app()->getLocale() === 'ar' ? ($offer->status === 'available' ? 'متاح' : $offer->status) : ucfirst($offer->status) }}
                            </span>
                        </td>
                        <td style="font-size: 0.85rem; color: var(--text-muted);">
                            {{ $offer->creator ? $offer->creator->name : (app()->getLocale() === 'ar' ? 'النظام' : 'System') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
