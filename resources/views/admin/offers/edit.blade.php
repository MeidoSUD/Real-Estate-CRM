@extends('layouts.admin')

@php
    $displayTitle = (app()->getLocale() === 'ar' && !empty($offer->title_ar)) ? $offer->title_ar : $offer->title;
    $existingImages = $offer->categorized_images ?? [];
    $existingChannels = $offer->advertising_channels ?? [];
    $existingFeatures = $offer->features ?? [];
    $existingUtilities = $offer->utilities_services ?? [];
@endphp

@section('title', app()->getLocale() === 'ar' ? 'تعديل العرض العقاري: ' . $displayTitle : 'Edit Offer: ' . $offer->title)
@section('page_title', app()->getLocale() === 'ar' ? 'العقارات / تعديل العرض' : 'Properties / Edit Offer')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* FORM & CONTAINER RESPONSIVENESS */
    #editOfferForm {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow-x: hidden;
    }
    .luxury-card {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    /* WIZARD TABS HEADER - WRAP IN SIZE OF SCREEN */
    .wizard-tabs {
        display: flex;
        flex-wrap: wrap; /* WRAP IN SIZE OF SCREEN */
        gap: 0.45rem;
        padding-bottom: 0.85rem;
        border-bottom: 2px solid var(--border-light);
        margin-bottom: 1.5rem;
        width: 100%;
        max-width: 100%;
    }
    .wizard-tab-btn {
        background: #ffffff;
        border: 1px solid var(--border-light);
        padding: 0.65rem 0.95rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex: 1 1 auto;
        justify-content: center;
        min-height: 42px;
    }
    .wizard-tab-btn:hover {
        color: var(--primary-900);
        background: var(--primary-50);
        border-color: var(--accent-bronze);
    }
    .wizard-tab-btn.active {
        background: linear-gradient(135deg, var(--accent-bronze), var(--accent-gold));
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(163, 105, 57, 0.25);
    }
    .wizard-step-pane {
        display: none;
        width: 100%;
        max-width: 100%;
    }
    .wizard-step-pane.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* PHOTO UPLOAD SLOTS GRID */
    .photo-slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 1.15rem;
        width: 100%;
    }
    .photo-slot-card {
        background: #ffffff;
        border: 1.5px dashed var(--border-light);
        border-radius: 14px;
        padding: 1.25rem 0.75rem;
        text-align: center;
        position: relative;
        cursor: pointer;
        transition: all 0.25s ease;
        min-height: 155px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .photo-slot-card:hover {
        border-color: var(--accent-bronze);
        background: var(--bg-cream);
        box-shadow: 0 4px 15px rgba(163, 105, 57, 0.12);
    }
    .photo-slot-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(163, 105, 57, 0.1);
        color: var(--accent-bronze);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 0.65rem;
        transition: transform 0.2s;
    }
    .photo-slot-card:hover .photo-slot-icon {
        transform: scale(1.1);
    }
    .photo-slot-preview {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 13px;
    }
    .slot-required-badge {
        position: absolute;
        bottom: 0.6rem;
        font-size: 0.68rem;
        color: #ef4444;
        font-weight: 700;
        z-index: 2;
    }
    .slot-has-image-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(21, 128, 61, 0.85);
        color: #ffffff;
        padding: 2px 7px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        z-index: 2;
    }

    /* REGIONS BAR - WRAP IN SIZE OF SCREEN */
    .regions-bar {
        background: #ffffff;
        border: 1px solid var(--border-light);
        border-radius: 14px;
        padding: 0.75rem 1rem;
        display: flex;
        flex-wrap: wrap; /* WRAP IN SIZE OF SCREEN */
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        width: 100%;
        max-width: 100%;
    }
    .region-chip {
        background: var(--primary-50);
        border: 1px solid var(--border-light);
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary-900);
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .region-chip:hover, .region-chip.active {
        background: var(--accent-bronze);
        color: #ffffff;
        border-color: var(--accent-bronze);
    }

    /* RESPONSIVE FORM GRIDS */
    .form-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        width: 100%;
    }
    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        width: 100%;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        width: 100%;
    }
    .form-grid-5 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .form-grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 860px) {
        .form-grid-3 {
            grid-template-columns: repeat(2, 1fr);
        }
        .form-grid-4 {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .form-grid-2,
        .form-grid-3,
        .form-grid-4 {
            grid-template-columns: 1fr;
        }
        .wizard-tab-btn {
            font-size: 0.78rem;
            padding: 0.5rem 0.7rem;
        }
    }
</style>
@endsection

@section('content')
<form action="{{ route('admin.offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data" id="editOfferForm">
    @csrf
    @method('PUT')

    <!-- TOP HEADER & CONTROLS -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; width: 100%;">
        <div>
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <h3 style="font-size: 1.6rem; color: var(--primary-900); font-family: 'Playfair Display', serif; font-weight: 800;">
                    {{ app()->getLocale() === 'ar' ? 'تعديل العرض العقاري' : 'Edit Property Offer' }}
                </h3>
                <span class="badge-gold">#{{ $offer->id }} - {{ $displayTitle }}</span>
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                {{ app()->getLocale() === 'ar' ? 'تحديث كامل للبيانات، العقود، قنوات الإعلان، مميزات العقار، إحداثيات الخريطة، وألبوم الصور.' : 'Comprehensive editing of contract, marketing channels, features, GPS coordinates, and media slots.' }}
            </p>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('admin.offers.index') }}" class="btn-outline-luxury" title="{{ app()->getLocale() === 'ar' ? 'إلغاء والعودة' : 'Cancel & Back' }}">
                <i class="fa-solid fa-arrow-right"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}</span>
            </a>

            <button type="button" class="btn-outline-luxury" id="btnPrevTab" onclick="prevStep()" style="display: none;">
                <i class="fa-solid fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</span>
            </button>

            <button type="button" class="btn-luxury" id="btnNextTab" onclick="nextStep()" style="background: #15803d; border-color: #15803d;">
                <span>{{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }}</span>
                <i class="fa-solid fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
            </button>

            <button type="submit" class="btn-luxury" id="btnSubmitForm">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}</span>
            </button>
        </div>
    </div>

    <!-- QUICK REGIONS SELECTOR BAR - WRAP IN SIZE OF SCREEN -->
    <div class="regions-bar">
        <span style="font-size: 0.85rem; font-weight: 800; color: var(--accent-bronze); white-space: nowrap;">
            <i class="fa-solid fa-location-crosshairs"></i>
            {{ app()->getLocale() === 'ar' ? 'المناطق التابعة للفرع (جدة):' : 'Branch Zones (Jeddah):' }}
        </span>
        @foreach($districts as $d)
            <div class="region-chip {{ old('district', $offer->district) === $d->name_en || old('district', $offer->district) === $d->name_ar ? 'active' : '' }}" onclick="quickSelectDistrict('{{ $d->name_en }}', '{{ $d->name_ar }}', this)">
                {{ $d->name }}
            </div>
        @endforeach
    </div>

    <!-- 10 WIZARD TABS NAVIGATION - WRAP IN SIZE OF SCREEN -->
    <div class="wizard-tabs">
        <button type="button" class="wizard-tab-btn active" onclick="goToStep(1)">
            <i class="fa-solid fa-file-contract"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'معلومات العقد' : 'Contract Info' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(2)">
            <i class="fa-solid fa-bullhorn"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'قنوات الإعلان' : 'Ad Channels' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(3)">
            <i class="fa-solid fa-layer-group"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'البيانات الأساسية' : 'Basic Data' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(4)">
            <i class="fa-solid fa-camera"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'صور العقار' : 'Property Photos' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(5)">
            <i class="fa-solid fa-stamp"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'الوثائق الرسمية' : 'Official Docs' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(6)">
            <i class="fa-solid fa-sparkles"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'مميزات العقار' : 'Features' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(7)">
            <i class="fa-solid fa-circle-info"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'معلومات العقار' : 'Property Info' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(8)">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'عنوان العقار' : 'Address & Map' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(9)">
            <i class="fa-solid fa-video"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'فيديو' : 'Video' }}</span>
        </button>
        <button type="button" class="wizard-tab-btn" onclick="goToStep(10)">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'الملاحظات' : 'Notes' }}</span>
        </button>
    </div>

    <!-- TAB 1: CONTRACT INFO -->
    <div class="wizard-step-pane active" id="step-1">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'بيانات العقد والصك العقاري' : 'Contract & Deed Information' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'توثيق بيانات عقد الوساطة الحصري أو غير الحصري وأرقام الصك والمخطط' : 'Brokerage agreement details, deed registration, and plan numbers' }}
                    </p>
                </div>
            </div>

            <div class="form-grid-3" style="margin-bottom: 1.5rem;">
                <!-- Contract Type -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقد' : 'Contract Type' }}</label>
                    <select name="contract_type" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر نوع العقد --' : '-- Select Contract Type --' }}</option>
                        @foreach($contractTypes as $ct)
                            <option value="{{ $ct->name_ar }}" {{ old('contract_type', $offer->contract_type) === $ct->name_ar || old('contract_type', $offer->contract_type) === $ct->name_en ? 'selected' : '' }}>
                                {{ $ct->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deed Number -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الصك' : 'Deed Number' }}</label>
                    <input type="text" name="deed_number" value="{{ old('deed_number', $offer->deed_number) }}" class="form-input" placeholder="مثال: 320109004812">
                </div>

                <!-- Plan Number -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم المخطط' : 'Plan Number' }}</label>
                    <input type="text" name="plan_number" value="{{ old('plan_number', $offer->plan_number) }}" class="form-input" placeholder="مثال: 450/ج/س">
                </div>
            </div>

            <div class="form-grid-3" style="margin-bottom: 1.5rem;">
                <!-- Parcel Number -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم القطعة' : 'Parcel Number' }}</label>
                    <input type="text" name="parcel_number" value="{{ old('parcel_number', $offer->parcel_number) }}" class="form-input" placeholder="مثال: 124 / 2">
                </div>

                <!-- Duration (Months) -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'مدة العقد (بالشهور)' : 'Contract Duration (Months)' }}</label>
                    <input type="number" name="contract_duration_months" value="{{ old('contract_duration_months', $offer->contract_duration_months) }}" class="form-input" placeholder="مثال: 6">
                </div>

                <!-- Power of Attorney -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'هل يوجد وكالة شرعية؟' : 'Power of Attorney (POA)?' }}</label>
                    <select name="has_agency_poa" class="form-select">
                        <option value="no" {{ old('has_agency_poa', $offer->has_agency_poa) === 'no' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'لا (المالك الأصيل)' : 'No (Original Owner)' }}</option>
                        <option value="yes" {{ old('has_agency_poa', $offer->has_agency_poa) === 'yes' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'نعم (يوجد وكيل شرعي)' : 'Yes (Legal Agent)' }}</option>
                    </select>
                </div>
            </div>

            <!-- Deed File Upload Attachment -->
            <div style="margin-top: 1.5rem; padding: 1.25rem; background: var(--bg-cream); border-radius: 12px; border: 1px dashed var(--accent-bronze);">
                <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-paperclip" style="color: var(--accent-bronze);"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'مرفق صورة الصك أو العقد (PDF أو صورة)' : 'Deed or Contract Attachment (PDF / Image)' }}</span>
                </label>
                @if($offer->deed_image)
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; background: #ffffff; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-light); flex-wrap: wrap;">
                        <i class="fa-solid fa-file-check" style="color: #15803d; font-size: 1.2rem;"></i>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--primary-900);">{{ app()->getLocale() === 'ar' ? 'يوجد صك مرفق حالياً:' : 'Current Deed Attached:' }}</span>
                        <a href="{{ asset('storage/' . $offer->deed_image) }}" target="_blank" class="btn-outline-luxury" style="padding: 0.3rem 0.8rem; font-size: 0.75rem;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'معاينة الصك المرفق' : 'Preview Current Deed' }}</span>
                        </a>
                    </div>
                @endif
                <input type="file" name="deed_image" class="form-input" accept="image/*,.pdf" style="background: #ffffff;">
                <small style="color: var(--text-muted); display: block; margin-top: 0.4rem;">
                    {{ app()->getLocale() === 'ar' ? 'الحجم الأقصى 5 ميجابايت. اترك الحقل فارغاً للإبقاء على الملف الحالي.' : 'Max file size 5MB. Leave empty to keep existing file.' }}
                </small>
            </div>
        </div>
    </div>

    <!-- TAB 2: ADVERTISING CHANNELS -->
    <div class="wizard-step-pane" id="step-2">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'قنوات الإعلان والتسويق المعتمدة' : 'Approved Marketing Channels' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'حدد المنصات والوسائل المتفق عليها لنشر هذا العرض العقاري' : 'Specify advertising channels agreed upon for distributing this property' }}
                    </p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
                @php
                    $channelsList = [
                        'licensed_platform' => ['icon' => 'fa-globe', 'ar' => 'منصة مرخصة وموقع إلكتروني', 'en' => 'Licensed Platform & Website'],
                        'signboard' => ['icon' => 'fa-sign-hanging', 'ar' => 'لوحة إعلانية على العقار', 'en' => 'Property Signboard'],
                        'social_media' => ['icon' => 'fa-share-nodes', 'ar' => 'وسائل التواصل الاجتماعي (سوشيال ميديا)', 'en' => 'Social Media Channels'],
                        'radio' => ['icon' => 'fa-radio', 'ar' => 'إذاعة ومسموع', 'en' => 'Radio Broadcast'],
                        'newspaper_print' => ['icon' => 'fa-newspaper', 'ar' => 'صحف ومطبوعات ورقية', 'en' => 'Print & Newspapers'],
                        'sms_campaigns' => ['icon' => 'fa-comment-sms', 'ar' => 'حملات الرسائل النصية القصيرة SMS', 'en' => 'SMS Marketing Campaigns'],
                        'other' => ['icon' => 'fa-ellipsis', 'ar' => 'وسائل وقنوات تسويقية أخرى', 'en' => 'Other Marketing Channels'],
                    ];
                @endphp

                @foreach($channelsList as $chKey => $chData)
                    <label style="display: flex; align-items: center; gap: 0.85rem; padding: 1rem 1.25rem; background: #ffffff; border: 1.5px solid var(--border-light); border-radius: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent-bronze)'" onmouseout="this.style.borderColor='var(--border-light)'">
                        <input type="checkbox" name="advertising_channels[]" value="{{ $chKey }}" {{ in_array($chKey, old('advertising_channels', $existingChannels)) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--accent-bronze);">
                        <i class="fa-solid {{ $chData['icon'] }}" style="color: var(--accent-bronze); font-size: 1.15rem; width: 24px; text-align: center;"></i>
                        <span style="font-size: 0.92rem; font-weight: 700; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? $chData['ar'] : $chData['en'] }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 3: BASIC DATA -->
    <div class="wizard-step-pane" id="step-3">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'البيانات الأساسية وتصنيف العقار' : 'Basic Property Classification' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'نوع وتصنيف الوحدة، نوع الصك، الفئة، الأدوار، وموقع الوحدة' : 'Category, deed property type, property grade, floors, and finishing' }}
                    </p>
                </div>
            </div>

            <!-- Title AR & EN -->
            <div class="form-grid-2" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عنوان العرض (عربي)' : 'Offer Title (Arabic)' }}</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $offer->title_ar) }}" class="form-input" placeholder="مثال: فيلا فاخرة بتصميم مودرن في حي الشاطئ">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عنوان العرض (إنجليزي)' : 'Offer Title (English)' }}</label>
                    <input type="text" name="title" value="{{ old('title', $offer->title) }}" class="form-input" placeholder="e.g. Luxury Modern Villa in Al-Shati District">
                </div>
            </div>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <!-- Category -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تصنيف العقار' : 'Property Category' }}</label>
                    <select name="property_category" class="form-select">
                        @foreach($propertyCategories as $cat)
                            <option value="{{ $cat->value ?: $cat->name_en }}" {{ old('property_category', $offer->property_category) === ($cat->value ?: $cat->name_en) || old('property_category', $offer->property_category) === $cat->name_ar ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deed Property Type -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار بالصك' : 'Deed Property Type' }}</label>
                    <select name="deed_property_type" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر النوع بالصك --' : '-- Select Deed Type --' }}</option>
                        @foreach($deedPropertyTypes as $dpt)
                            <option value="{{ $dpt->name_ar }}" {{ old('deed_property_type', $offer->deed_property_type) === $dpt->name_ar || old('deed_property_type', $offer->deed_property_type) === $dpt->name_en ? 'selected' : '' }}>
                                {{ $dpt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Property Type -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار الفعلي *' : 'Actual Property Type *' }}</label>
                    <select name="property_type" required class="form-select">
                        @foreach($propertyTypes as $pt)
                            <option value="{{ $pt->value ?: $pt->name_en }}" {{ old('property_type', $offer->property_type) === ($pt->value ?: $pt->name_en) || old('property_type', $offer->property_type) === $pt->name_ar ? 'selected' : '' }}>
                                {{ $pt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Property Grade -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'فئة العقار' : 'Property Grade' }}</label>
                    <select name="property_grade" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر الفئة --' : '-- Select Grade --' }}</option>
                        @foreach($propertyGrades as $pg)
                            <option value="{{ $pg->name_ar }}" {{ old('property_grade', $offer->property_grade) === $pg->name_ar || old('property_grade', $offer->property_grade) === $pg->name_en ? 'selected' : '' }}>
                                {{ $pg->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-4">
                <!-- Floors Count -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد الأدوار' : 'Floors Count' }}</label>
                    <input type="number" name="floors_count" value="{{ old('floors_count', $offer->floors_count) }}" class="form-input" placeholder="مثال: 3" min="0">
                </div>

                <!-- Has Upper Annex -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'ملحق علوي؟' : 'Upper Annex (Roof)?' }}</label>
                    <select name="has_upper_annex" class="form-select">
                        <option value="no" {{ old('has_upper_annex', $offer->has_upper_annex) === 'no' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'لا يوجد' : 'No' }}</option>
                        <option value="yes" {{ old('has_upper_annex', $offer->has_upper_annex) === 'yes' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'نعم يوجد ملحق علوي' : 'Yes' }}</option>
                    </select>
                </div>

                <!-- Unit Position -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'موقع الوحدة' : 'Unit Position' }}</label>
                    <select name="unit_position" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر موقع الوحدة --' : '-- Select Position --' }}</option>
                        @foreach($unitPositions as $up)
                            <option value="{{ $up->name_ar }}" {{ old('unit_position', $offer->unit_position) === $up->name_ar || old('unit_position', $offer->unit_position) === $up->name_en ? 'selected' : '' }}>
                                {{ $up->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Finishing Type -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع التشطيب' : 'Finishing Type' }}</label>
                    <select name="finishing_type" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر نوع التشطيب --' : '-- Select Finishing --' }}</option>
                        @foreach($finishingTypes as $ft)
                            <option value="{{ $ft->name_ar }}" {{ old('finishing_type', $offer->finishing_type) === $ft->name_ar || old('finishing_type', $offer->finishing_type) === $ft->name_en ? 'selected' : '' }}>
                                {{ $ft->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: PROPERTY PHOTOS (21 SLOTS) -->
    <div class="wizard-step-pane" id="step-4">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? 'ألبوم صور العقار (21 خانة مخصصة)' : 'Property Photo Album (21 Categorized Slots)' }}
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                            {{ app()->getLocale() === 'ar' ? 'انقر على أي بطاقة لرفع أو استبدال الصورة الخاصة بها. الخانات التي تحتوي على صور تظهر بعلامة خضراء.' : 'Click any slot card to upload/replace. Slots with existing photos display a green badge.' }}
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: #ef4444; font-weight: 700;">
                    <i class="fa-solid fa-asterisk"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'خانات أساسية: الواجهة، الصالة 1، المطبخ، الحمام 1، غرفة النوم 1' : 'Core slots: Facade, Living 1, Kitchen, Bath 1, Master Bed' }}</span>
                </div>
            </div>

            @php
                $photoSlots = [
                    'facade_main' => ['ar' => 'واجهة العقار (رئيسية)', 'en' => 'Main Facade', 'icon' => 'fa-building', 'req' => true],
                    'facade_side' => ['ar' => 'واجهة العقار الجانبية', 'en' => 'Side Facade', 'icon' => 'fa-building-columns', 'req' => false],
                    'entrance' => ['ar' => 'مدخل العمارة / الفيلا', 'en' => 'Main Entrance', 'icon' => 'fa-door-open', 'req' => false],
                    'living_room_1' => ['ar' => 'الصالة الرئيسية (1)', 'en' => 'Main Living Room (1)', 'icon' => 'fa-couch', 'req' => true],
                    'living_room_2' => ['ar' => 'مجلس الضيوف (2)', 'en' => 'Guest Majlis (2)', 'icon' => 'fa-chair', 'req' => false],
                    'kitchen' => ['ar' => 'المطبخ', 'en' => 'Kitchen', 'icon' => 'fa-utensils', 'req' => true],
                    'bathroom_1' => ['ar' => 'دورة المياه (1)', 'en' => 'Bathroom (1)', 'icon' => 'fa-bath', 'req' => true],
                    'bathroom_2' => ['ar' => 'دورة المياه (2)', 'en' => 'Bathroom (2)', 'icon' => 'fa-shower', 'req' => false],
                    'bedroom_master' => ['ar' => 'غرفة النوم الرئيسية', 'en' => 'Master Bedroom', 'icon' => 'fa-bed', 'req' => true],
                    'bedroom_2' => ['ar' => 'غرفة النوم (2)', 'en' => 'Bedroom (2)', 'icon' => 'fa-bed', 'req' => false],
                    'bedroom_3' => ['ar' => 'غرفة النوم (3)', 'en' => 'Bedroom (3)', 'icon' => 'fa-bed', 'req' => false],
                    'internal_stairs' => ['ar' => 'الدرج الداخلي', 'en' => 'Internal Stairs', 'icon' => 'fa-stairs', 'req' => false],
                    'upper_annex' => ['ar' => 'الملحق العلوي / الروف', 'en' => 'Upper Annex / Roof', 'icon' => 'fa-house-chimney-window', 'req' => false],
                    'pool' => ['ar' => 'المسبح', 'en' => 'Swimming Pool', 'icon' => 'fa-water-ladder', 'req' => false],
                    'garden' => ['ar' => 'الحديقة / الفناء الخارجي', 'en' => 'Garden / Courtyard', 'icon' => 'fa-tree', 'req' => false],
                    'laundry_room' => ['ar' => 'غرفة الغسيل', 'en' => 'Laundry Room', 'icon' => 'fa-soap', 'req' => false],
                    'storage_room' => ['ar' => 'المستودع', 'en' => 'Storage Room', 'icon' => 'fa-boxes-stacked', 'req' => false],
                    'maid_room' => ['ar' => 'غرفة الخادمة', 'en' => 'Maid Room', 'icon' => 'fa-person-shelter', 'req' => false],
                    'external_stairs' => ['ar' => 'الدرج الخارجي', 'en' => 'External Stairs', 'icon' => 'fa-stairs', 'req' => false],
                    'driver_room' => ['ar' => 'غرفة السائق', 'en' => 'Driver Room', 'icon' => 'fa-id-badge', 'req' => false],
                    'elevator' => ['ar' => 'المصعد', 'en' => 'Elevator', 'icon' => 'fa-elevator', 'req' => false],
                ];
            @endphp

            <div class="photo-slots-grid">
                @foreach($photoSlots as $slotKey => $slot)
                    @php
                        $hasExisting = !empty($existingImages[$slotKey]);
                        $existingSrc = $hasExisting ? asset('storage/' . $existingImages[$slotKey]) : '';
                    @endphp
                    <div class="photo-slot-card" onclick="document.getElementById('input_{{ $slotKey }}').click()">
                        @if($hasExisting)
                            <span class="slot-has-image-badge" title="{{ app()->getLocale() === 'ar' ? 'صورة مرفوعة حالياً (انقر للاستبدال)' : 'Existing photo (click to replace)' }}">
                                <i class="fa-solid fa-check"></i> {{ app()->getLocale() === 'ar' ? 'موجودة' : 'Uploaded' }}
                            </span>
                            <img src="{{ $existingSrc }}" alt="" id="prev_{{ $slotKey }}" class="photo-slot-preview" style="display: block;">
                        @else
                            <img src="" alt="" id="prev_{{ $slotKey }}" class="photo-slot-preview" style="display: none;">
                        @endif

                        <div class="photo-slot-icon" id="icon_{{ $slotKey }}" style="{{ $hasExisting ? 'display: none;' : '' }}">
                            <i class="fa-solid {{ $slot['icon'] }}"></i>
                        </div>

                        <span style="font-size: 0.82rem; font-weight: 700; color: var(--primary-900); z-index: 2; {{ $hasExisting ? 'background: rgba(0,0,0,0.65); color: #fff; padding: 2px 6px; border-radius: 4px;' : '' }}" id="label_{{ $slotKey }}">
                            {{ app()->getLocale() === 'ar' ? $slot['ar'] : $slot['en'] }}
                        </span>

                        @if($slot['req'])
                            <span class="slot-required-badge" id="req_{{ $slotKey }}" style="{{ $hasExisting ? 'display: none;' : '' }}">
                                * {{ app()->getLocale() === 'ar' ? 'مطلوب' : 'Required' }}
                            </span>
                        @endif

                        <input type="file" name="categorized_images[{{ $slotKey }}]" id="input_{{ $slotKey }}" style="display: none;" accept="image/*" onchange="previewSlotImage(this, '{{ $slotKey }}')">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 5: OFFICIAL REGA DOCS -->
    <div class="wizard-step-pane" id="step-5">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-stamp"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'الوثائق الرسمية والتراخيص (الهيئة العامة للعقار)' : 'Official Licenses & REGA Compliance' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'توثيق ترخيص الإعلان العقاري الصادر من هيئة العقار وقيود العقار والرهن' : 'REGA advertisement license number, mortgages, and legal constraints' }}
                    </p>
                </div>
            </div>

            <div class="form-grid-2" style="margin-bottom: 2rem;">
                <!-- Ad License Number -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم ترخيص الإعلان العقاري (فال / هيئة العقار)' : 'REGA Ad License Number (Fal)' }}</label>
                    <input type="text" name="ad_license_number" value="{{ old('ad_license_number', $offer->ad_license_number) }}" class="form-input" placeholder="مثال: 7200012345">
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'حالة العرض *' : 'Offer Status *' }}</label>
                    <select name="status" required class="form-select">
                        <option value="available" {{ old('status', $offer->status) === 'available' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'متاح للعرض والبيع' : 'Available' }}</option>
                        <option value="reserved" {{ old('status', $offer->status) === 'reserved' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'محجوز بعربون' : 'Reserved' }}</option>
                        <option value="sold" {{ old('status', $offer->status) === 'sold' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'تم البيع بنجاح' : 'Sold' }}</option>
                        <option value="rented" {{ old('status', $offer->status) === 'rented' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'تم التأجير' : 'Rented' }}</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <!-- Has Restrictions -->
                <div style="background: #ffffff; border: 1.5px solid var(--border-light); border-radius: 12px; padding: 1.25rem;">
                    <label style="display: flex; align-items: flex-start; gap: 0.85rem; cursor: pointer;">
                        <input type="checkbox" name="has_restrictions" value="1" {{ old('has_restrictions', $offer->has_restrictions) ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--accent-bronze); margin-top: 2px;">
                        <div>
                            <span style="font-size: 0.95rem; font-weight: 800; color: var(--primary-900); display: block;">
                                {{ app()->getLocale() === 'ar' ? 'هل يوجد أي قيود أو حقوق على العقار؟' : 'Are there any restrictions or easements on the property?' }}
                            </span>
                            <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">
                                {{ app()->getLocale() === 'ar' ? 'مثل حق مرور، وصية، أو وقف يستوجب الإفصاح عنه نظاماً' : 'Such as rights of way, endowments, or easements requiring disclosure' }}
                            </small>
                        </div>
                    </label>
                </div>

                <!-- Has Mortgage -->
                <div style="background: #ffffff; border: 1.5px solid var(--border-light); border-radius: 12px; padding: 1.25rem;">
                    <label style="display: flex; align-items: flex-start; gap: 0.85rem; cursor: pointer;">
                        <input type="checkbox" name="has_mortgage" value="1" {{ old('has_mortgage', $offer->has_mortgage) ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--accent-bronze); margin-top: 2px;">
                        <div>
                            <span style="font-size: 0.95rem; font-weight: 800; color: var(--primary-900); display: block;">
                                {{ app()->getLocale() === 'ar' ? 'هل العقار مرهون لجهة تمويلية أو بنكية؟' : 'Is the property mortgaged to a bank or financial institution?' }}
                            </span>
                            <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">
                                {{ app()->getLocale() === 'ar' ? 'صندوق التنمية العقارية، بنك، أو رهن تجاري' : 'Real Estate Development Fund, bank mortgage, or commercial pledge' }}
                            </small>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 6: PROPERTY FEATURES (22 CHECKBOXES) -->
    <div class="wizard-step-pane" id="step-6">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-sparkles"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'مميزات ومرافق العقار' : 'Property Features & Amenities' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'حدد المميزات والمرافق المتوفرة في العقار لعرضها في بطاقة العرض والموقع' : 'Select all available amenities to feature on the property card and website' }}
                    </p>
                </div>
            </div>

            @php
                $featuresList = [
                    'annex' => ['ar' => 'ملحق علوي', 'en' => 'Upper Annex', 'icon' => 'fa-house-user'],
                    'yard' => ['ar' => 'حوش خارجي واسع', 'en' => 'Spacious Yard', 'icon' => 'fa-border-all'],
                    'rooftop' => ['ar' => 'سطح خاص', 'en' => 'Private Rooftop', 'icon' => 'fa-sun'],
                    'laundry_room' => ['ar' => 'غرفة غسيل ملابس', 'en' => 'Laundry Room', 'icon' => 'fa-soap'],
                    'maid_room' => ['ar' => 'غرفة خادمة خاصة', 'en' => 'Maid Room', 'icon' => 'fa-person-shelter'],
                    'driver_room' => ['ar' => 'غرفة سائق مستقلة', 'en' => 'Driver Room', 'icon' => 'fa-id-badge'],
                    'pool' => ['ar' => 'مسبح خاص', 'en' => 'Private Swimming Pool', 'icon' => 'fa-water-ladder'],
                    'driveway_parking' => ['ar' => 'مدخل سيارة / كراج', 'en' => 'Driveway Garage', 'icon' => 'fa-car'],
                    'basement' => ['ar' => 'بدروم (قبو)', 'en' => 'Basement', 'icon' => 'fa-dungeon'],
                    'elevator_ready' => ['ar' => 'تأسيس مصعد', 'en' => 'Elevator Shaft Ready', 'icon' => 'fa-arrow-up-from-ground-water'],
                    'elevator_installed' => ['ar' => 'مصعد راكب وجاهز', 'en' => 'Installed Elevator', 'icon' => 'fa-elevator'],
                    'central_ac' => ['ar' => 'تكييف مركزي / دكت', 'en' => 'Central Air Conditioning', 'icon' => 'fa-snowflake'],
                    'outdoor_kitchen' => ['ar' => 'مطبخ خارجي (ديرتي كيتشن)', 'en' => 'Outdoor Dirty Kitchen', 'icon' => 'fa-utensils'],
                    'fountain' => ['ar' => 'شلال أو نافورة مائية', 'en' => 'Water Fountain / Waterfall', 'icon' => 'fa-faucet-drip'],
                    'storage' => ['ar' => 'مستودع تخزين', 'en' => 'Storage Room', 'icon' => 'fa-boxes-stacked'],
                    'garden' => ['ar' => 'حديقة ومساحات خضراء', 'en' => 'Landscaped Garden', 'icon' => 'fa-tree'],
                    'glass_facade' => ['ar' => 'واجهات زجاجية بانورامية', 'en' => 'Panoramic Glass Windows', 'icon' => 'fa-window-maximize'],
                    'terrace' => ['ar' => 'تراس واسع', 'en' => 'Outdoor Terrace', 'icon' => 'fa-umbrella-beach'],
                    'balcony' => ['ar' => 'شرفة مطلة (بلكونة)', 'en' => 'Balcony', 'icon' => 'fa-door-open'],
                    'furnished' => ['ar' => 'مؤثث بالكامل', 'en' => 'Fully Furnished', 'icon' => 'fa-couch'],
                    'near_mosque' => ['ar' => 'قريب من مسجد وخدمات', 'en' => 'Near Mosque & Services', 'icon' => 'fa-mosque'],
                    'smart_home' => ['ar' => 'نظام سمارت هوم ذكي', 'en' => 'Smart Home Automation', 'icon' => 'fa-microchip'],
                ];
            @endphp

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 0.9rem;">
                @foreach($featuresList as $fKey => $fData)
                    <label style="display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem 1rem; background: #ffffff; border: 1.5px solid var(--border-light); border-radius: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent-bronze)'" onmouseout="this.style.borderColor='var(--border-light)'">
                        <input type="checkbox" name="features[]" value="{{ $fKey }}" {{ in_array($fKey, old('features', $existingFeatures)) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--accent-bronze);">
                        <i class="fa-solid {{ $fData['icon'] }}" style="color: var(--accent-bronze); font-size: 1.1rem; width: 22px; text-align: center;"></i>
                        <span style="font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? $fData['ar'] : $fData['en'] }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 7: PROPERTY SPECS & INFO -->
    <div class="wizard-step-pane" id="step-7">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'المواصفات الفنية والمالية' : 'Financial & Technical Specifications' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'السعر، المساحة، الغرض، الاستخدام، عدد الغرف، الضمانات، والالتزامات' : 'Price, area sqm, purpose, usage, rooms, warranties, and liabilities' }}
                    </p>
                </div>
            </div>

            <!-- Price & Purpose & Area -->
            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الغرض *' : 'Purpose *' }}</label>
                    <select name="purpose" required class="form-select">
                        <option value="sale" {{ old('purpose', $offer->purpose) === 'sale' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'للبيع' : 'For Sale' }}</option>
                        <option value="rent" {{ old('purpose', $offer->purpose) === 'rent' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'للإيجار' : 'For Rent' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'السعر المطلوب (ريال سعودي) *' : 'Price (SAR) *' }}</label>
                    <input type="number" step="0.01" name="price" required value="{{ old('price', $offer->price) }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المساحة الإجمالية (م²) *' : 'Area (sqm) *' }}</label>
                    <input type="number" step="0.01" name="area_sqm" required value="{{ old('area_sqm', $offer->area_sqm) }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'استخدام العقار' : 'Property Usage' }}</label>
                    <select name="property_usage" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر الاستخدام --' : '-- Select Usage --' }}</option>
                        @foreach($propertyUsages as $pu)
                            <option value="{{ $pu->name_ar }}" {{ old('property_usage', $offer->property_usage) === $pu->name_ar || old('property_usage', $offer->property_usage) === $pu->name_en ? 'selected' : '' }}>
                                {{ $pu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-3" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عمر العقار' : 'Property Age' }}</label>
                    <input type="text" name="property_age" value="{{ old('property_age', $offer->property_age) }}" class="form-input" placeholder="مثال: جديد / 3 سنوات">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد غرف النوم' : 'Bedrooms' }}</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $offer->bedrooms) }}" class="form-input" min="0">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد دورات المياه' : 'Bathrooms' }}</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $offer->bathrooms) }}" class="form-input" min="0">
                </div>
            </div>

            <!-- Utilities / Services Checkboxes -->
            <div style="margin-bottom: 1.5rem; padding: 1.25rem; background: var(--bg-cream); border-radius: 12px; border: 1px solid var(--border-light);">
                <label class="form-label" style="margin-bottom: 0.75rem; color: var(--accent-bronze);">
                    <i class="fa-solid fa-bolt"></i>
                    {{ app()->getLocale() === 'ar' ? 'الخدمات والمرافق المتوفرة (شبكات البنية التحتية):' : 'Available Utilities & Infrastructure:' }}
                </label>
                <div style="display: flex; gap: 1.25rem; flex-wrap: wrap;">
                    @foreach($utilities as $util)
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; font-weight: 700; color: var(--primary-900);">
                            <input type="checkbox" name="utilities_services[]" value="{{ $util->name_en }}" {{ in_array($util->name_en, old('utilities_services', $existingUtilities)) || in_array($util->name_ar, old('utilities_services', $existingUtilities)) ? 'checked' : '' }} style="width: 17px; height: 17px; accent-color: var(--accent-bronze);">
                            <span>{{ $util->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Guarantees & Liabilities & Disputes -->
            <div class="form-grid-3">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الضمانات وتفاصيلها' : 'Warranties & Guarantees' }}</label>
                    <textarea name="guarantees" rows="3" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: ضمان 10 سنوات على الهيكل الإنشائي، سنتين سباكة وكهرباء' : 'e.g. 10 years structural warranty' }}">{{ old('guarantees', $offer->guarantees) }}</textarea>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الالتزامات على العقار' : 'Liabilities & Obligations' }}</label>
                    <textarea name="property_liabilities" rows="3" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: رسوم اتحاد ملاك، فواتير دورية، أو لا يوجد' : 'e.g. HOA fees, utility obligations' }}">{{ old('property_liabilities', $offer->property_liabilities) }}</textarea>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'النزاعات أو القضايا' : 'Disputes / Legal Cases' }}</label>
                    <textarea name="property_disputes" rows="3" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: لا يوجد أي نزاع قانوني قائم' : 'e.g. No legal disputes pending' }}">{{ old('property_disputes', $offer->property_disputes) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 8: NATIONAL ADDRESS & LEAFLET MAP -->
    <div class="wizard-step-pane" id="step-8">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? 'عنوان العقار وإحداثيات العنوان الوطني' : 'National Address & Geographic Coordinates' }}
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                            {{ app()->getLocale() === 'ar' ? 'حدد الموقع بدقة على الخريطة التفاعلية أو اسحب المؤشر لتحديث الإحداثيات ورابط جوجل' : 'Drag pin or click map to update GPS coordinates and Google Maps link' }}
                        </p>
                    </div>
                </div>

                <button type="button" class="btn-outline-luxury" onclick="locateUserGPS()" style="font-size: 0.82rem;">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'تحديد موقعي الحالي GPS' : 'Use Current Location' }}</span>
                </button>
            </div>

            <!-- Address fields grid -->
            <div class="form-grid-4" style="margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المنطقة' : 'Region' }}</label>
                    <input type="text" name="region" value="{{ old('region', $offer->region ?? 'منطقة مكة المكرمة') }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المدينة *' : 'City *' }}</label>
                    <input type="text" name="city" required value="{{ old('city', $offer->city) }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الحي بجدة *' : 'District in Jeddah *' }}</label>
                    <select name="district" required class="form-select" id="offerDistrictSelect">
                        @foreach($districts as $d)
                            <option value="{{ $d->name_en }}" {{ old('district', $offer->district) === $d->name_en || old('district', $offer->district) === $d->name_ar ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم الشارع' : 'Street Name' }}</label>
                    <input type="text" name="street_name" value="{{ old('street_name', $offer->street_name) }}" class="form-input" placeholder="مثال: طريق الملك عبد العزيز">
                </div>
            </div>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الرمز البريدي' : 'Postal Code' }}</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $offer->postal_code) }}" class="form-input" placeholder="مثال: 23615">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم المبنى' : 'Building No.' }}</label>
                    <input type="text" name="building_number" value="{{ old('building_number', $offer->building_number) }}" class="form-input" placeholder="مثال: 7421">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الرقم الإضافي' : 'Additional No.' }}</label>
                    <input type="text" name="additional_number" value="{{ old('additional_number', $offer->additional_number) }}" class="form-input" placeholder="مثال: 3120">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رابط خرائط جوجل' : 'Google Maps Link' }}</label>
                    <input type="text" name="map_link" id="offerMapLink" value="{{ old('map_link', $offer->map_link) }}" class="form-input" placeholder="https://maps.google.com/...">
                </div>
            </div>

            <!-- Lat & Lng Hidden/Readonly inputs -->
            <input type="hidden" name="latitude" id="offerLatInput" value="{{ old('latitude', $offer->latitude ?? '21.543333') }}">
            <input type="hidden" name="longitude" id="offerLngInput" value="{{ old('longitude', $offer->longitude ?? '39.172778') }}">

            <!-- LEAFLET INTERACTIVE MAP CONTAINER -->
            <div style="position: relative;">
                <div id="propertyMap" style="width: 100%; height: 420px; border-radius: 14px; border: 1.5px solid var(--border-light); z-index: 1;"></div>
                <div style="position: absolute; bottom: 12px; {{ app()->getLocale() === 'ar' ? 'right: 12px;' : 'left: 12px;' }} background: rgba(255,255,255,0.92); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; color: var(--primary-900); z-index: 1000; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-crosshairs" style="color: var(--accent-bronze);"></i>
                    {{ app()->getLocale() === 'ar' ? 'انقر على أي نقطة في الخريطة أو اسحب العلامة لتحديد الموقع الدقيق' : 'Click anywhere or drag marker to set exact coordinates' }}
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 9: VIDEO TOUR -->
    <div class="wizard-step-pane" id="step-9">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'فيديو الجولة الافتراضية' : 'Virtual Video Tour' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'أضف رابط فيديو الجولة للعقار على منصات يوتيوب أو فيميو أو تيك توك' : 'Attach YouTube, Vimeo, or cloud video tour URL' }}
                    </p>
                </div>
            </div>

            <div style="max-width: 600px;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رابط الفيديو (YouTube / Vimeo / Direct URL)' : 'Video Link (YouTube / Vimeo)' }}</label>
                <div style="display: flex; gap: 0.75rem;">
                    <input type="url" name="video_url" value="{{ old('video_url', $offer->video_url) }}" class="form-input" placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">
                    {{ app()->getLocale() === 'ar' ? 'سيتم تضمين الفيديو في صفحة تفاصيل العرض لتمكين العملاء من مشاهدة الجولة التصويرية.' : 'Video tour will be embedded directly in the property public listing page.' }}
                </small>
            </div>
        </div>
    </div>

    <!-- TAB 10: NOTES & REMARKS -->
    <div class="wizard-step-pane" id="step-10">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(163, 105, 57, 0.1); color: var(--accent-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'الملاحظات والوصف التفصيلي' : 'Descriptions & Internal Notes' }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        {{ app()->getLocale() === 'ar' ? 'الوصف التسويقي العام الذي يظهر للزوار، والملاحظات الداخلية الخاصة بفريق العمل' : 'Public marketing description and confidential internal brokerage notes' }}
                    </p>
                </div>
            </div>

            <div class="form-grid-2">
                <div>
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-bullhorn" style="color: var(--accent-bronze);"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'الوصف التسويقي العام (يظهر للعملاء والموقع)' : 'Public Marketing Description' }}</span>
                    </label>
                    <textarea name="description" rows="8" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب وصفاً جذاباً ومفصلاً للعقار ومواصفاته...' : 'Enter enticing marketing description...' }}">{{ old('description', $offer->description) }}</textarea>
                </div>

                <div>
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-lock" style="color: #ef4444;"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'ملاحظات داخلية سرية (لفريق الوساطة فقط)' : 'Internal Private Notes (Team only)' }}</span>
                    </label>
                    <textarea name="internal_notes" rows="8" class="form-input" style="background: #fdfaf6;" placeholder="{{ app()->getLocale() === 'ar' ? 'بيانات المالك السرية، عمولة السعي الإضافية، أو توجيهات خاصة بالمعاينة...' : 'Confidential seller notes, broker commission split, inspection codes...' }}">{{ old('internal_notes', $offer->internal_notes) }}</textarea>
                </div>
            </div>

            <!-- Featured Property Toggle -->
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $offer->is_featured) ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--accent-gold);">
                    <span style="font-size: 0.95rem; font-weight: 800; color: var(--primary-900);">
                        {{ app()->getLocale() === 'ar' ? 'تمييز هذا العرض في الصفحة الرئيسية والموقع الإلكتروني' : 'Feature this property listing on the home page' }}
                    </span>
                </label>

                <button type="submit" class="btn-luxury" style="padding: 0.85rem 2rem; font-size: 1rem;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ وتحديث العرض العقاري' : 'Save & Update Offer' }}</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let currentStep = 1;
const totalSteps = 10;
let mapInstance = null;
let markerInstance = null;

function goToStep(step) {
    if (step < 1 || step > totalSteps) return;
    currentStep = step;

    // Toggle panes
    document.querySelectorAll('.wizard-step-pane').forEach((pane, idx) => {
        pane.classList.toggle('active', (idx + 1) === step);
    });

    // Toggle tab buttons
    document.querySelectorAll('.wizard-tab-btn').forEach((btn, idx) => {
        btn.classList.toggle('active', (idx + 1) === step);
    });

    // Toggle prev/next buttons
    const btnPrev = document.getElementById('btnPrevTab');
    if (step === 1) {
        btnPrev.style.display = 'none';
    } else {
        btnPrev.style.display = 'inline-flex';
    }

    if (step === totalSteps) {
        document.getElementById('btnNextTab').style.display = 'none';
    } else {
        document.getElementById('btnNextTab').style.display = 'inline-flex';
    }

    // Init map if moving to step 8
    if (step === 8) {
        setTimeout(initLeafletMap, 200);
    }
}

function nextStep() {
    goToStep(currentStep + 1);
}

function prevStep() {
    goToStep(currentStep - 1);
}

function quickSelectDistrict(valEn, valAr, el) {
    const select = document.getElementById('offerDistrictSelect');
    if (select) {
        select.value = valEn;
    }
    document.querySelectorAll('.region-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
}

function previewSlotImage(input, slotKey) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('prev_' + slotKey);
            const icon = document.getElementById('icon_' + slotKey);
            const label = document.getElementById('label_' + slotKey);
            const req = document.getElementById('req_' + slotKey);

            preview.src = e.target.result;
            preview.style.display = 'block';
            if (icon) icon.style.display = 'none';
            if (req) req.style.display = 'none';
            if (label) {
                label.style.background = 'rgba(0,0,0,0.65)';
                label.style.color = '#fff';
                label.style.padding = '2px 6px';
                label.style.borderRadius = '4px';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// LEAFLET MAP INITIALIZATION
function initLeafletMap() {
    if (mapInstance) {
        mapInstance.invalidateSize();
        return;
    }

    const defaultLat = parseFloat(document.getElementById('offerLatInput').value) || 21.543333;
    const defaultLng = parseFloat(document.getElementById('offerLngInput').value) || 39.172778;

    mapInstance = L.map('propertyMap').setView([defaultLat, defaultLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapInstance);

    markerInstance = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(mapInstance);

    markerInstance.on('dragend', function(e) {
        const pos = markerInstance.getLatLng();
        updateCoordinates(pos.lat, pos.lng);
    });

    mapInstance.on('click', function(e) {
        markerInstance.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoordinates(lat, lng) {
    document.getElementById('offerLatInput').value = lat.toFixed(6);
    document.getElementById('offerLngInput').value = lng.toFixed(6);
    document.getElementById('offerMapLink').value = 'https://www.google.com/maps?q=' + lat.toFixed(6) + ',' + lng.toFixed(6);
}

function locateUserGPS() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            if (mapInstance && markerInstance) {
                mapInstance.setView([lat, lng], 15);
                markerInstance.setLatLng([lat, lng]);
                updateCoordinates(lat, lng);
            }
        });
    }
}
</script>
@endsection
