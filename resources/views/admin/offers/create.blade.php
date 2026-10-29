@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إنشاء عرض عقاري جديد' : 'Create New Property Offer')
@section('page_title', app()->getLocale() === 'ar' ? 'العقارات / إنشاء عرض عقاري جديد' : 'Properties / Create New Offer')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* FORM & CONTAINER RESPONSIVENESS */
    #createOfferForm {
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
        display: none;
    }
    .slot-required-badge {
        position: absolute;
        bottom: 0.6rem;
        font-size: 0.68rem;
        color: #ef4444;
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
<form action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data" id="createOfferForm">
    @csrf

    <!-- TOP HEADER & CONTROLS -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; width: 100%;">
        <div>
            <h3 style="font-size: 1.6rem; color: var(--primary-900); font-family: 'Playfair Display', serif; font-weight: 800;">
                {{ app()->getLocale() === 'ar' ? 'إنشاء عرض عقاري جديد' : 'Create New Property Offer' }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                {{ app()->getLocale() === 'ar' ? 'نموذج شامل لتوثيق العقد، البيانات الأساسية، التراخيص، إحداثيات العنوان الوطني، والألبوم المصور.' : 'Comprehensive wizard for contracts, legal deeds, national address, and room-by-room media.' }}
            </p>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <button type="button" class="btn-outline-luxury" onclick="resetForm()" title="{{ app()->getLocale() === 'ar' ? 'تفريغ الحقول' : 'Reset Form' }}">
                <i class="fa-solid fa-rotate-left"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'تفريغ الحقول' : 'Reset' }}</span>
            </button>

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
                <span>{{ app()->getLocale() === 'ar' ? 'حفظ نهائي' : 'Final Submit' }}</span>
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
            <div class="region-chip" onclick="quickSelectDistrict('{{ $d->name_en }}', '{{ $d->name_ar }}', this)">
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
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-file-contract text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'بيانات عقد الوساطة وصك الملكية' : 'Brokerage Contract & Ownership Deed' }}</span>
            </h4>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقد' : 'Contract Type' }}</label>
                    <select name="contract_type" class="form-select">
                        <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر نوع العقد --' : '-- Select Type --' }}</option>
                        @foreach($contractTypes as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم صك الملكية الإلكتروني' : 'Title Deed Number' }}</label>
                    <input type="text" name="deed_number" class="form-input" placeholder="e.g. 320109004812">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم المخطط' : 'Master Plan Number' }}</label>
                    <input type="text" name="plan_number" class="form-input" placeholder="e.g. 140/ج/س">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم القطعة' : 'Plot / Parcel Number' }}</label>
                    <input type="text" name="parcel_number" class="form-input" placeholder="e.g. 458">
                </div>
            </div>

            <!-- OWNER INFORMATION SECTION (CONFIDENTIAL: FOR CS & ADMIN) -->
            <div style="background: var(--primary-50); border: 1px solid var(--border-light); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                    <h5 style="font-size: 1rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                        <i class="fa-solid fa-user-lock text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'بيانات مالك العقار (سرية ومخصصة لخدمة العملاء والإدارة)' : 'Property Owner Information (Restricted Access)' }}</span>
                    </h5>
                    <span class="badge-gold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-shield"></i> {{ app()->getLocale() === 'ar' ? 'مشفر ومحمي الصلاحية' : 'Permission Restricted' }}
                    </span>
                </div>

                <div class="form-grid-3" style="margin-bottom: 0.75rem;">
                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم مالك العقار' : 'Owner Full Name' }}</label>
                        <input type="text" name="owner_name" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: الشيخ عبد الله آل سيف' : 'e.g. Abdullah Al-Saif' }}" value="{{ old('owner_name') }}">
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم جوال المالك للتواصل المباشر' : 'Owner Phone Number' }}</label>
                        <input type="text" name="owner_phone" class="form-input" placeholder="+966 5X XXX XXXX" value="{{ old('owner_phone') }}" style="direction: ltr;">
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الهوية الوطنية / السجل التجاري' : 'Owner National ID / CR' }}</label>
                        <input type="text" name="owner_national_id" class="form-input" placeholder="10XXXXXXXX" value="{{ old('owner_national_id') }}">
                    </div>
                </div>

                <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
                    <i class="fa-solid fa-circle-info text-gold"></i>
                    {{ app()->getLocale() === 'ar' ? 'تُحفظ بيانات مالك العقار بصورة سرية لتكون متاحة لفريق خدمة العملاء والإدارة فقط لإجراء المعاينات والتواصل الرسمي، ولا تظهر للموقع العام أو المسوقين الآخرين.' : 'Owner contact is stored securely for Customer Service and Administration to handle viewings, and will not be displayed publicly or to general marketers.' }}
                </p>
            </div>

            <div class="form-grid-2" style="margin-bottom: 2rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المدة بالأشهر' : 'Duration in Months' }}</label>
                    <select name="contract_duration_months" class="form-select">
                        <option value="1">1 {{ app()->getLocale() === 'ar' ? 'شهر' : 'Month' }}</option>
                        <option value="3" selected>3 {{ app()->getLocale() === 'ar' ? 'أشهر' : 'Months' }}</option>
                        <option value="6">6 {{ app()->getLocale() === 'ar' ? 'أشهر' : 'Months' }}</option>
                        <option value="12">12 {{ app()->getLocale() === 'ar' ? 'شهراً (سنة)' : 'Months (1 Year)' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'هل يوجد وكالة شرعية؟' : 'Has Legal Power of Attorney?' }}</label>
                    <select name="has_agency_poa" class="form-select">
                        <option value="no">{{ app()->getLocale() === 'ar' ? 'لا (المالك مباشرة)' : 'No (Direct Owner)' }}</option>
                        <option value="yes">{{ app()->getLocale() === 'ar' ? 'نعم (وكيل شرعي)' : 'Yes (Legal Agent)' }}</option>
                    </select>
                </div>
            </div>

            <!-- ATTACHMENTS SECTION -->
            <div style="border-top: 1px solid var(--border-light); padding-top: 1.5rem;">
                <h5 style="font-size: 1rem; color: var(--primary-900); font-weight: 700; margin-bottom: 1rem;">
                    {{ app()->getLocale() === 'ar' ? 'المرفقات الرسمية للعقد' : 'Contract Attachments' }}
                </h5>

                <div style="max-width: 300px;">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'صورة أو ملف الصك (PDF / صورة)' : 'Deed Photo or Document' }}</label>
                    <div class="photo-slot-card" onclick="document.getElementById('deed_image_input').click()">
                        <div class="photo-slot-icon">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>
                        <span style="font-size: 0.84rem; font-weight: 700; color: var(--primary-900);" id="deed_file_label">
                            {{ app()->getLocale() === 'ar' ? 'رفع صورة الصك' : 'Upload Deed' }}
                        </span>
                        <input type="file" name="deed_image" id="deed_image_input" accept="image/*,application/pdf" style="display: none;" onchange="updateFileLabel(this, 'deed_file_label')">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: ADVERTISING CHANNELS -->
    <div class="wizard-step-pane" id="step-2">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-bullhorn text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'قنوات الإعلان المعتمدة للنشر' : 'Authorized Advertising Channels' }}</span>
            </h4>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1.75rem;">
                {{ app()->getLocale() === 'ar' ? 'حدد القنوات المصرح بها حسب بنود عقد الوساطة والتسويق مع المالك.' : 'Select the approved marketing channels according to the owner agreement.' }}
            </p>

            <div class="form-grid-5">
                @php
                    $channels = [
                        ['id' => 'licensed_platform', 'name_ar' => 'منصة مرخصة (فال)', 'name_en' => 'Licensed Platform (REGA)', 'icon' => 'certificate'],
                        ['id' => 'signboard', 'name_ar' => 'لوحة إعلانية موقعية', 'name_en' => 'On-site Signboard', 'icon' => 'signs-post'],
                        ['id' => 'social_media', 'name_ar' => 'منصات التواصل الاجتماعي', 'name_en' => 'Social Media Platforms', 'icon' => 'share-nodes'],
                        ['id' => 'radio', 'name_ar' => 'الإذاعة والصحف', 'name_en' => 'Radio & Press', 'icon' => 'tower-broadcast'],
                        ['id' => 'other', 'name_ar' => 'قنوات تسويقية أخرى', 'name_en' => 'Other Channels', 'icon' => 'ellipsis'],
                    ];
                @endphp

                @foreach($channels as $ch)
                    <label style="border: 1px solid var(--border-light); border-radius: 12px; padding: 1.25rem 1rem; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 0.65rem; cursor: pointer; background: #ffffff; transition: all 0.2s ease;">
                        <input type="checkbox" name="advertising_channels[]" value="{{ $ch['id'] }}" checked style="width: 18px; height: 18px; accent-color: var(--accent-bronze);">
                        <i class="fa-solid fa-{{ $ch['icon'] }}" style="font-size: 1.5rem; color: var(--accent-bronze);"></i>
                        <span style="font-size: 0.88rem; font-weight: 700; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? $ch['name_ar'] : $ch['name_en'] }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 3: BASIC DATA -->
    <div class="wizard-step-pane" id="step-3">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-layer-group text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'البيانات الأساسية وتصنيف العقار' : 'Basic Property Classification' }}</span>
            </h4>

            <!-- Title AR & EN -->
            <div class="form-grid-2" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عنوان العرض (عربي)' : 'Offer Title (Arabic)' }}</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: فيلا فاخرة بتصميم مودرن في حي الشاطئ (اختياري - يتم التوليد تلقائياً إذا تُرك فارغاً)' : 'e.g. Luxury Modern Villa in Al-Shati (Optional - auto-generated if left blank)' }}">
                </div>
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عنوان العرض (إنجليزي)' : 'Offer Title (English)' }}</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: Luxury Modern Villa in Al-Shati District (اختياري)' : 'e.g. Luxury Modern Villa in Al-Shati District (Optional)' }}">
                </div>
            </div>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'قسم العقار *' : 'Property Category *' }}</label>
                    <select name="property_category" required class="form-select">
                        @foreach($propertyCategories as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار في الصك *' : 'Property Type in Deed *' }}</label>
                    <select name="deed_property_type" required class="form-select">
                        @foreach($deedPropertyTypes as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع العقار التسويقي *' : 'Marketing Property Type *' }}</label>
                    <select name="property_type" required class="form-select">
                        @foreach($propertyTypes as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'فئة العقار' : 'Property Grade / Class' }}</label>
                    <select name="property_grade" class="form-select">
                        @foreach($propertyGrades as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الغرض التسويقي *' : 'Purpose *' }}</label>
                    <select name="purpose" required class="form-select">
                        <option value="sale">{{ app()->getLocale() === 'ar' ? 'للبيع' : 'For Sale' }}</option>
                        <option value="rent">{{ app()->getLocale() === 'ar' ? 'للإيجار' : 'For Rent' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد الأدوار' : 'Number of Floors' }}</label>
                    <select name="floors_count" class="form-select">
                        <option value="1">1 ({{ app()->getLocale() === 'ar' ? 'دور أرضي' : 'Ground Floor' }})</option>
                        <option value="2" selected>2 ({{ app()->getLocale() === 'ar' ? 'دوبلكس / دورين' : '2 Floors' }})</option>
                        <option value="3">3 {{ app()->getLocale() === 'ar' ? 'أدوار' : 'Floors' }}</option>
                        <option value="4">4+ {{ app()->getLocale() === 'ar' ? 'أدوار' : 'Floors' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'هل يوجد ملاحق علوية؟' : 'Upper Rooftop Annex?' }}</label>
                    <select name="has_upper_annex" class="form-select">
                        <option value="no">{{ app()->getLocale() === 'ar' ? 'لا' : 'No' }}</option>
                        <option value="yes" selected>{{ app()->getLocale() === 'ar' ? 'نعم (ملحق مع سطح مستقل)' : 'Yes' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'مكان العقار بالوحدة' : 'Position in Unit' }}</label>
                    <select name="unit_position" class="form-select">
                        @foreach($unitPositions as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'نوع التشطيب' : 'Finishing Type' }}</label>
                    <select name="finishing_type" class="form-select">
                        @foreach($finishingTypes as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'حالة العرض المبدئية *' : 'Initial Status *' }}</label>
                    <select name="status" required class="form-select">
                        <option value="available" selected>{{ app()->getLocale() === 'ar' ? 'متاح للعرض والبيع' : 'Available' }}</option>
                        <option value="reserved">{{ app()->getLocale() === 'ar' ? 'محجوز مؤقتاً' : 'Reserved' }}</option>
                        <option value="sold">{{ app()->getLocale() === 'ar' ? 'تم البيع' : 'Sold' }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: CATEGORIZED PROPERTY PHOTOS -->
    <div class="wizard-step-pane" id="step-4">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-camera text-gold"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'ألبوم صور العقار المبوب حسب الغرف والأقسام' : 'Categorized Room-by-Room Photo Gallery' }}</span>
                    </h4>
                    <p style="color: var(--text-muted); font-size: 0.88rem;">
                        {{ app()->getLocale() === 'ar' ? 'انقر على أي بطاقة لاختيار الصورة المخصصة لكل جزء من أجزاء العقار.' : 'Click any slot to select and preview photos for each area.' }}
                    </p>
                </div>

                <div style="font-size: 0.8rem; color: #ef4444; font-weight: 700;">
                    * {{ app()->getLocale() === 'ar' ? 'الحقول ذات الوسم (أساسي) يفضل تزويدها لإبراز جودة الإعلان.' : 'Slots marked (Required) enhance listing quality.' }}
                </div>
            </div>

            @php
                $slots = [
                    ['key' => 'facade_main', 'title_ar' => 'صورة الواجهة الرئيسية', 'title_en' => 'Main Facade', 'icon' => 'hotel', 'req' => true],
                    ['key' => 'facade_side', 'title_ar' => 'صورة الواجهة الجانبية', 'title_en' => 'Side Facade', 'icon' => 'building', 'req' => false],
                    ['key' => 'entrance', 'title_ar' => 'مدخل البناء من الداخل', 'title_en' => 'Building Entrance', 'icon' => 'door-open', 'req' => false],
                    ['key' => 'living_1', 'title_ar' => 'صورة صالة 1', 'title_en' => 'Living Room 1', 'icon' => 'couch', 'req' => true],
                    ['key' => 'living_2', 'title_ar' => 'صورة صالة 2', 'title_en' => 'Living Room 2', 'icon' => 'couch', 'req' => false],
                    ['key' => 'kitchen', 'title_ar' => 'صورة المطبخ', 'title_en' => 'Kitchen', 'icon' => 'kitchen-set', 'req' => true],
                    ['key' => 'bath_1', 'title_ar' => 'صورة دورة مياه 1', 'title_en' => 'Bathroom 1', 'icon' => 'bath', 'req' => true],
                    ['key' => 'bath_2', 'title_ar' => 'صورة دورة مياه 2', 'title_en' => 'Bathroom 2', 'icon' => 'bath', 'req' => false],
                    ['key' => 'room_1', 'title_ar' => 'صورة غرفة 1 (ماستر)', 'title_en' => 'Master Bedroom', 'icon' => 'bed', 'req' => true],
                    ['key' => 'room_2', 'title_ar' => 'صورة غرفة 2', 'title_en' => 'Bedroom 2', 'icon' => 'bed', 'req' => false],
                    ['key' => 'room_3', 'title_ar' => 'صورة غرفة 3', 'title_en' => 'Bedroom 3', 'icon' => 'bed', 'req' => false],
                    ['key' => 'stairs_inner', 'title_ar' => 'درج داخلي', 'title_en' => 'Internal Stairs', 'icon' => 'stairs', 'req' => false],
                    ['key' => 'annex', 'title_ar' => 'صورة الملحق', 'title_en' => 'Annex', 'icon' => 'warehouse', 'req' => false],
                    ['key' => 'pool', 'title_ar' => 'صورة المسبح', 'title_en' => 'Swimming Pool', 'icon' => 'water-ladder', 'req' => false],
                    ['key' => 'garden', 'title_ar' => 'صورة الحديقة', 'title_en' => 'Garden', 'icon' => 'tree', 'req' => false],
                    ['key' => 'laundry', 'title_ar' => 'غرفة غسيل', 'title_en' => 'Laundry Room', 'icon' => 'soap', 'req' => false],
                    ['key' => 'storage', 'title_ar' => 'غرفة تخزين', 'title_en' => 'Storage Room', 'icon' => 'boxes-stacked', 'req' => false],
                    ['key' => 'maid_room', 'title_ar' => 'غرفة خادمة', 'title_en' => 'Maid Room', 'icon' => 'person-shelter', 'req' => false],
                    ['key' => 'stairs_outer', 'title_ar' => 'درج خارجي', 'title_en' => 'External Stairs', 'icon' => 'stairs', 'req' => false],
                    ['key' => 'driver_room', 'title_ar' => 'غرفة سائق', 'title_en' => 'Driver Room', 'icon' => 'id-card', 'req' => false],
                    ['key' => 'elevator', 'title_ar' => 'صورة المصعد', 'title_en' => 'Elevator', 'icon' => 'elevator', 'req' => false],
                ];
            @endphp

            <div class="photo-slots-grid">
                @foreach($slots as $s)
                    <div class="photo-slot-card" onclick="document.getElementById('input_{{ $s['key'] }}').click()">
                        <img id="prev_{{ $s['key'] }}" class="photo-slot-preview" alt="Preview">
                        <div class="photo-slot-icon" id="icon_{{ $s['key'] }}">
                            <i class="fa-solid fa-{{ $s['icon'] }}"></i>
                        </div>
                        <div style="font-size: 0.82rem; font-weight: 700; color: var(--primary-900); z-index: 2;" id="label_{{ $s['key'] }}">
                            {{ app()->getLocale() === 'ar' ? $s['title_ar'] : $s['title_en'] }}
                        </div>
                        @if($s['req'])
                            <span class="slot-required-badge" id="req_{{ $s['key'] }}">{{ app()->getLocale() === 'ar' ? 'أساسي' : 'Required' }}</span>
                        @endif
                        <input type="file" name="categorized_images[{{ $s['key'] }}]" id="input_{{ $s['key'] }}" accept="image/*" style="display: none;" onchange="previewSlotImage(this, '{{ $s['key'] }}')">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 5: OFFICIAL REGA DOCUMENTS -->
    <div class="wizard-step-pane" id="step-5">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-stamp text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'الوثائق الرسمية والالتزامات النظامية (الهيئة العامة للعقار)' : 'Official Regulatory Compliance (REGA)' }}</span>
            </h4>

            <div class="form-grid-3">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'هل يوجد قيد على العقار؟ *' : 'Any Legal Restrictions?' }}</label>
                    <select name="has_restrictions" class="form-select">
                        <option value="0" selected>{{ app()->getLocale() === 'ar' ? 'لا (سليم نظامياً)' : 'No Restrictions' }}</option>
                        <option value="1">{{ app()->getLocale() === 'ar' ? 'نعم (يوجد قيد)' : 'Yes (Restricted)' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'هل يوجد رهن بنكي أو تمويلي؟ *' : 'Is Property Mortgaged?' }}</label>
                    <select name="has_mortgage" class="form-select">
                        <option value="0" selected>{{ app()->getLocale() === 'ar' ? 'لا (حر بدون رهن)' : 'No Mortgage' }}</option>
                        <option value="1">{{ app()->getLocale() === 'ar' ? 'نعم (مرهون لجهة تمويلية)' : 'Yes (Mortgaged)' }}</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم ترخيص الإعلان العقاري (فال)' : 'REGA Ad License Number' }}</label>
                    <input type="text" name="ad_license_number" class="form-input" placeholder="e.g. 7200194821">
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 6: PROPERTY FEATURES MATRIX -->
    <div class="wizard-step-pane" id="step-6">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-sparkles text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'المزايا والمرافق العقارية' : 'Property Features & Amenities' }}</span>
            </h4>

            @php
                $amenitiesMatrix = [
                    ['ملحق خارجي', 'Outdoor Annex'],
                    ['حوش', 'Courtyard / Yard'],
                    ['سطح', 'Rooftop Terrace'],
                    ['غرفة غسيل', 'Laundry Room'],
                    ['غرفة خادمة', 'Maid\'s Room'],
                    ['غرفة سائق', 'Driver\'s Room'],
                    ['مسبح', 'Swimming Pool'],
                    ['مدخل سيارة', 'Car Driveway'],
                    ['قبو', 'Basement'],
                    ['تأسيس مصعد', 'Elevator Provision'],
                    ['مصعد', 'Elevator Installed'],
                    ['تكييف مركزي', 'Central A/C'],
                    ['مطبخ خارجي', 'Outdoor Kitchen'],
                    ['نافورة خارجية', 'Outdoor Fountain'],
                    ['غرفة تخزين', 'Storage Room'],
                    ['حديقة', 'Garden'],
                    ['نوافذ زجاج كبيرة', 'Large Glass Windows'],
                    ['شرفة', 'Terrace'],
                    ['بلكونة', 'Balcony'],
                    ['مؤثث بالكامل', 'Fully Furnished'],
                    ['قريب من الخدمات', 'Near Amenities'],
                    ['موقف سيارات مظلل', 'Covered Car Parking'],
                ];
            @endphp

            <div class="form-grid-4">
                @foreach($amenitiesMatrix as $item)
                    <label style="display: flex; align-items: center; gap: 0.75rem; background: var(--primary-50); padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border-light); cursor: pointer; transition: all 0.2s;">
                        <input type="checkbox" name="features[]" value="{{ $item[0] }}" style="width: 17px; height: 17px; accent-color: var(--accent-bronze);">
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--primary-900);">
                            {{ app()->getLocale() === 'ar' ? $item[0] : $item[1] }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 7: PROPERTY INFO & SPECS -->
    <div class="wizard-step-pane" id="step-7">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-circle-info text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'المواصفات الفنية والمساحات والأسعار' : 'Technical Specifications & Valuation' }}</span>
            </h4>

            <div class="form-grid-4" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'السعر المطلوب (ر.س) *' : 'Price (SAR) *' }}</label>
                    <input type="number" step="0.01" name="price" required class="form-input" placeholder="e.g. 4500000">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'مساحة العقار (م²) *' : 'Area (sqm) *' }}</label>
                    <input type="number" step="0.01" name="area_sqm" required class="form-input" placeholder="e.g. 520">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'استخدام العقار' : 'Property Usage' }}</label>
                    <select name="property_usage" class="form-select">
                        @foreach($propertyUsages as $opt)
                            <option value="{{ $opt->value }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عمر العقار' : 'Property Age' }}</label>
                    <select name="property_age" class="form-select">
                        <option value="0">{{ app()->getLocale() === 'ar' ? 'جديد (أول ساكن)' : 'Brand New' }}</option>
                        <option value="1-3">{{ app()->getLocale() === 'ar' ? '1 إلى 3 سنوات' : '1 - 3 Years' }}</option>
                        <option value="3-5">{{ app()->getLocale() === 'ar' ? '3 إلى 5 سنوات' : '3 - 5 Years' }}</option>
                        <option value="5-10">{{ app()->getLocale() === 'ar' ? '5 إلى 10 سنوات' : '5 - 10 Years' }}</option>
                        <option value="10+">{{ app()->getLocale() === 'ar' ? 'أكثر من 10 سنوات' : '10+ Years' }}</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2" style="margin-bottom: 1.5rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد غرف النوم' : 'Bedrooms' }}</label>
                    <input type="number" name="bedrooms" value="5" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'عدد دورات المياه' : 'Bathrooms' }}</label>
                    <input type="number" name="bathrooms" value="6" class="form-input">
                </div>
            </div>

            <!-- UTILITIES CHECKBOXES -->
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الخدمات المتوفرة' : 'Available Utilities' }}</label>
                <div class="form-grid-4">
                    @foreach($utilities as $u)
                        <label style="display: flex; align-items: center; gap: 0.6rem; background: var(--bg-cream); padding: 0.6rem 0.85rem; border-radius: 8px; border: 1px solid var(--border-light); cursor: pointer;">
                            <input type="checkbox" name="utilities_services[]" value="{{ $u->value }}" checked style="accent-color: var(--accent-bronze);">
                            <span style="font-size: 0.84rem; font-weight: 600;">{{ $u->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-grid-3">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الضمانات المرفقة' : 'Warranties & Guarantees' }}</label>
                    <textarea name="guarantees" rows="2" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: 10 سنوات هيكل إنشائي، سنتين سباكة وكهرباء...' : 'e.g. 10 years structural guarantee...' }}"></textarea>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الالتزامات على العقار' : 'Property Liabilities' }}</label>
                    <textarea name="property_liabilities" rows="2" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: فواتير خدمات، رسوم خدمات مجمع...' : 'e.g. None or service charges...' }}"></textarea>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'النزاعات على العقار أو المنفعة' : 'Disputes on Property' }}</label>
                    <textarea name="property_disputes" rows="2" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'لا يوجد أي نزاع قضائي أو مالي' : 'No disputes recorded' }}"></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 8: ADDRESS, NATIONAL ADDRESS & MAP -->
    <div class="wizard-step-pane" id="step-8">
        <div class="luxury-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
                <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-map-location-dot text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'العنوان الوطني وإحداثيات الخريطة' : 'National Address & Interactive Map' }}</span>
                </h4>

                <button type="button" class="btn-outline-luxury btn-sm" onclick="locateUserGPS()">
                    <i class="fa-solid fa-crosshairs text-gold"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'موقعي الحالي' : 'My Current Location' }}</span>
                </button>
            </div>

            <!-- MAP CONTAINER -->
            <div id="propertyMap" style="height: 380px; width: 100%; border-radius: 14px; border: 1px solid var(--border-light); margin-bottom: 1.5rem; z-index: 10;"></div>

            <div class="form-grid-4" style="margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المنطقة *' : 'Region *' }}</label>
                    <input type="text" name="region" value="{{ app()->getLocale() === 'ar' ? 'منطقة مكة المكرمة' : 'Makkah Region' }}" required class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'المدينة *' : 'City *' }}</label>
                    <input type="text" name="city" value="{{ app()->getLocale() === 'ar' ? 'جدة' : 'Jeddah' }}" required class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الحي بجدة *' : 'District *' }}</label>
                    <select name="district" id="offerDistrictSelect" required class="form-select">
                        @foreach($districts as $d)
                            <option value="{{ $d->value }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم الشارع' : 'Street Name' }}</label>
                    <input type="text" name="street_name" id="offerStreetInput" class="form-input" placeholder="e.g. شارع الأمير سلطان">
                </div>
            </div>

            <div class="form-grid-4" style="margin-bottom: 1.25rem;">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم المبنى' : 'Building No.' }}</label>
                    <input type="text" name="building_number" class="form-input" placeholder="e.g. 7421">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الرمز البريدي' : 'Postal Code' }}</label>
                    <input type="text" name="postal_code" class="form-input" placeholder="e.g. 23512">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الرقم الإضافي' : 'Additional No.' }}</label>
                    <input type="text" name="additional_number" class="form-input" placeholder="e.g. 3120">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رابط جوجل ماب' : 'Google Maps Link' }}</label>
                    <input type="text" name="map_link" id="offerMapLink" class="form-input" placeholder="https://maps.google.com/...">
                </div>
            </div>

            <div class="form-grid-2">
                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'خط العرض (Latitude)' : 'Latitude' }}</label>
                    <input type="text" name="latitude" id="offerLatInput" value="21.543333" class="form-input">
                </div>

                <div>
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'خط الطول (Longitude)' : 'Longitude' }}</label>
                    <input type="text" name="longitude" id="offerLngInput" value="39.172778" class="form-input">
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 9: VIDEO -->
    <div class="wizard-step-pane" id="step-9">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-video text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'فيديو جولة العقار' : 'Property Video Tour' }}</span>
            </h4>

            <div>
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رابط فيديو العقار (يوتيوب / فيميو / منصة سحابية)' : 'Video Tour URL (YouTube, Vimeo, Cloud MP4)' }}</label>
                <input type="url" name="video_url" class="form-input" placeholder="https://www.youtube.com/watch?v=...">
            </div>
        </div>
    </div>

    <!-- TAB 10: NOTES & REMARKS -->
    <div class="wizard-step-pane" id="step-10">
        <div class="luxury-card" style="padding: 2rem;">
            <h4 style="font-size: 1.15rem; color: var(--primary-900); font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-clipboard-list text-gold"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'الملاحظات الداخلية وسجل المسوق' : 'Internal Notes & Remarks' }}</span>
            </h4>

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'ملاحظات فريق العمل والتسويق (سرية وغير ظاهرة للعموم)' : 'Private Team Notes' }}</label>
                <textarea name="internal_notes" rows="4" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'سجل هنا تفاصيل مالك العقار، مرونة التفاوض، أوقات المعاينة المفضلة...' : 'Record private details, negotiation boundaries, preferred viewing times...' }}"></textarea>
            </div>

            <div>
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الوصف التسويقي العام للعقار (يظهر في الموقع)' : 'Public Marketing Description' }}</label>
                <textarea name="description" rows="4" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب نبذة تسويقية جذابة تشرح تميز موقع العقار وإطلالته وجودة تشطيبه...' : 'Write an appealing description highlighting property features...' }}"></textarea>
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

    // Update tab buttons
    const btns = document.querySelectorAll('.wizard-tab-btn');
    btns.forEach((btn, index) => {
        if (index + 1 === step) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Update panes
    const panes = document.querySelectorAll('.wizard-step-pane');
    panes.forEach((pane, index) => {
        if (index + 1 === step) {
            pane.classList.add('active');
        } else {
            pane.classList.remove('active');
        }
    });

    currentStep = step;

    // Toggle button visibility
    document.getElementById('btnPrevTab').style.display = currentStep > 1 ? 'inline-flex' : 'none';
    if (currentStep === totalSteps) {
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

function resetForm() {
    if (confirm('{{ app()->getLocale() === "ar" ? "هل ترغب فعلاً في تفريغ حقول النموذج؟" : "Are you sure you want to reset the form?" }}')) {
        document.getElementById('createOfferForm').reset();
        goToStep(1);
    }
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
                label.style.background = 'rgba(0,0,0,0.6)';
                label.style.color = '#fff';
                label.style.padding = '2px 6px';
                label.style.borderRadius = '4px';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updateFileLabel(input, labelId) {
    if (input.files && input.files[0]) {
        document.getElementById(labelId).innerText = input.files[0].name;
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
