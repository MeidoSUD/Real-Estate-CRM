@extends('layouts.website')

@section('title', app()->getLocale() === 'ar' ? 'اتصل بنا | خدمة عملاء صفران العقارية' : 'Contact Us | Safran Real Estate')

@section('styles')
<style>
    .contact-hero {
        background: linear-gradient(180deg, var(--primary-950) 0%, var(--primary-900) 100%);
        color: #ffffff;
        padding: 4.5rem 1.5rem 3.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(200, 155, 83, 0.2);
    }
    .contact-container {
        max-width: 1280px;
        margin: -2rem auto 5rem;
        padding: 0 1.5rem;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1.2fr 1.8fr;
        gap: 2.5rem;
    }
    .info-card {
        background: var(--primary-900);
        color: #ffffff;
        border-radius: 20px;
        padding: 2.5rem;
        border: 1px solid rgba(200, 155, 83, 0.3);
        box-shadow: var(--shadow-card);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .info-item {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(200, 155, 83, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-gold);
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 2.5rem;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
    }
    @media (max-width: 992px) {
        .contact-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="contact-hero">
    <div style="max-width: 800px; margin: 0 auto;">
        <span class="badge-gold" style="margin-bottom: 1rem;"><i class="fa-solid fa-headset"></i> {{ app()->getLocale() === 'ar' ? 'مكتب خدمة العملاء والمستثمرين بجدة' : 'Jeddah Client Relations' }}</span>
        <h1 style="color: #ffffff; font-size: 2.8rem; margin-bottom: 1rem; font-weight: 900;">
            {{ app()->getLocale() === 'ar' ? 'تواصل مع فريقنا الاستشاري' : 'Get in Touch With Us' }}
        </h1>
        <p style="color: rgba(255, 255, 255, 0.85); font-size: 1.1rem; line-height: 1.7;">
            {{ app()->getLocale() === 'ar' ? 'سواء كنت مالكاً ترغب في تسويق عقارك، أو مشترياً تبحث عن فيلا أو شقة فاخرة، فريق خدمة العملاء جاهز للتواصل معك وتنسيق طلبك.' : 'Whether you are an owner looking to list a luxury property or an investor seeking prime assets in Jeddah, our customer service team is ready to assist.' }}
        </p>
    </div>
</div>

<div class="contact-container">
    <div class="contact-grid">
        <!-- CONTACT INFO CARD -->
        <div>
            <div class="info-card">
                <div>
                    <h3 style="color: #ffffff; font-size: 1.8rem; margin-bottom: 1rem; font-weight: 800;">
                        {{ app()->getLocale() === 'ar' ? 'المقر الرئيسي - جدة' : 'Jeddah Headquarters' }}
                    </h3>
                    <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 2.5rem; line-height: 1.7;">
                        {{ app()->getLocale() === 'ar' ? 'تقع مكاتبنا وصالات الاستقبال الاستشارية في برج طريق الملك بمدينة جدة.' : 'Our main showroom and executive brokerage offices are situated in the prestigious King Road Tower.' }}
                    </p>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.25rem;">{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Address' }}</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.92rem; line-height: 1.6;">
                                {{ app()->getLocale() === 'ar' ? 'الدور 18، برج طريق الملك، طريق الملك عبدالعزيز الفرعي، جدة، المملكة العربية السعودية' : 'Floor 18, King Road Tower, King Abdulaziz Branch Rd, Jeddah, Saudi Arabia' }}
                            </p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.25rem;">{{ app()->getLocale() === 'ar' ? 'خطوط الاتصال وخدمة العملاء' : 'Phone Lines' }}</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.92rem;">
                                {{ app()->getLocale() === 'ar' ? 'الهاتف الموحد: ' : 'Telephone: ' }}+966 12 609 8888<br>
                                {{ app()->getLocale() === 'ar' ? 'الجوال / واتساب: ' : 'WhatsApp: ' }}+966 50 123 4567
                            </p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.25rem;">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني للطلبات' : 'Email' }}</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.92rem;">
                                inquiries@safran-realestate.sa
                            </p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <h4 style="color: #ffffff; font-size: 1.05rem; margin-bottom: 0.25rem;">{{ app()->getLocale() === 'ar' ? 'ساعات العمل الرسمية' : 'Working Hours' }}</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.92rem;">
                                {{ app()->getLocale() === 'ar' ? 'الأحد – الخميس: 9:00 صباحاً – 6:00 مساءً' : 'Sunday – Thursday: 9:00 AM – 6:00 PM' }}<br>
                                {{ app()->getLocale() === 'ar' ? 'الجمعة والسبت: مغلق (متاح بالتنسيق المسبق لكبار الشخصيات)' : 'Friday – Saturday: Closed' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(255, 255, 255, 0.06); border-radius: 14px; padding: 1.25rem; border: 1px solid rgba(200, 155, 83, 0.2); margin-top: 1rem;">
                    <span style="font-size: 0.8rem; color: var(--accent-gold-light); text-transform: uppercase; font-weight: 700;">
                        {{ app()->getLocale() === 'ar' ? 'بوابة دخول الموظفين' : 'Staff Access' }}
                    </span>
                    <p style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.8); margin: 0.35rem 0 0.75rem;">
                        {{ app()->getLocale() === 'ar' ? 'هل أنت عضو في فريق التسويق أو خدمة العملاء؟' : 'Are you a member of our team?' }}
                    </p>
                    <a href="{{ route('login') }}" class="btn-luxury" style="padding: 0.5rem 1rem; font-size: 0.85rem; width: 100%; text-align: center;">
                        <i class="fa-solid fa-lock"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول للنظام CRM' : 'Sign In to CRM' }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- CONTACT INQUIRY FORM -->
        <div>
            <div class="form-card">
                <h3 style="font-size: 1.8rem; color: var(--primary-900); margin-bottom: 0.5rem; font-weight: 800;">
                    {{ app()->getLocale() === 'ar' ? 'أرسل استفسارك أو طلبك العقاري' : 'Send Us a Message' }}
                </h3>
                <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">
                    {{ app()->getLocale() === 'ar' ? 'أكمل النموذج وسيقوم منسق خدمة العملاء بالتواصل معك مباشرة عبر الهاتف أو الواتساب.' : 'Fill out the form below. Our customer service coordinator will connect with you immediately.' }}
                </p>

                @if(session('inquiry_success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('inquiry_success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'يرجى تصحيح الأخطاء أدناه والمحاولة مجدداً.' : 'Please fix the errors below.' }}</span>
                    </div>
                @endif

                <form action="{{ route('website.inquiry.store') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'أنا أتواصل بصفتي: *' : 'I am contacting as: *' }}</label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem;">
                            <label style="border: 1.5px solid var(--border-light); border-radius: var(--radius-md); padding: 0.85rem 0.5rem; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                                <input type="radio" name="type" value="buyer" checked style="accent-color: var(--accent-bronze);">
                                <span style="font-size: 0.9rem; font-weight: 700; color: var(--primary-900);">
                                    {{ app()->getLocale() === 'ar' ? 'مشتري / مستثمر' : 'Buyer / Investor' }}
                                </span>
                            </label>

                            <label style="border: 1.5px solid var(--border-light); border-radius: var(--radius-md); padding: 0.85rem 0.5rem; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                                <input type="radio" name="type" value="owner" {{ old('type') == 'owner' ? 'checked' : '' }} style="accent-color: var(--accent-bronze);">
                                <span style="font-size: 0.9rem; font-weight: 700; color: var(--primary-900);">
                                    {{ app()->getLocale() === 'ar' ? 'مالك عقار (عرض عقار)' : 'Property Owner' }}
                                </span>
                            </label>

                            <label style="border: 1.5px solid var(--border-light); border-radius: var(--radius-md); padding: 0.85rem 0.5rem; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                                <input type="radio" name="type" value="inquiry" {{ old('type') == 'inquiry' ? 'checked' : '' }} style="accent-color: var(--accent-bronze);">
                                <span style="font-size: 0.9rem; font-weight: 700; color: var(--primary-900);">
                                    {{ app()->getLocale() === 'ar' ? 'استفسار عام' : 'General Inquiry' }}
                                </span>
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div>
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label>
                            <input type="text" name="name" required class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: فيصل الشهري' : 'e.g. Faisal Al-Shehri' }}" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الجوال *' : 'Phone Number *' }}</label>
                            <input type="text" name="phone" required class="form-input" placeholder="+966 5X XXX XXXX" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div>
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                            <input type="email" name="email" class="form-input" placeholder="name@domain.com" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label class="form-label">{{ app()->getLocale() === 'ar' ? 'إشارة لعقار معين (اختياري)' : 'Reference a Property' }}</label>
                            <select name="property_offer_id" class="form-select">
                                <option value="">{{ app()->getLocale() === 'ar' ? 'لا يوجد / استفسار عام' : 'None / General' }}</option>
                                @foreach($propertyOffers as $pOffer)
                                    <option value="{{ $pOffer->id }}" {{ old('property_offer_id') == $pOffer->id ? 'selected' : '' }}>
                                        {{ (app()->getLocale() === 'ar' && $pOffer->title_ar) ? $pOffer->title_ar : $pOffer->title }} ({{ $pOffer->district }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.75rem;">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'تفاصيل رسالتك أو مواصفات العقار المراد عرضه/شراؤه *' : 'Your Message *' }}</label>
                        <textarea name="message" rows="4" required class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'يرجى كتابة تفاصيل ما تبحث عنه، أو بيانات العقار الذي ترغب في عرضه بجدة (الموقع، المساحة، السعر التقريبي)...' : 'Please describe what you are looking for...' }}">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-luxury" style="width: 100%; height: 50px; font-size: 1.05rem;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'إرسال الطلب لفريق خدمة العملاء' : 'Submit Inquiry to Customer Service' }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
