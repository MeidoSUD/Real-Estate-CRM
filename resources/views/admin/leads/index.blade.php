@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'خدمة العملاء والطلبات' : 'Customer Service & Leads')
@section('page_title', app()->getLocale() === 'ar' ? 'خدمة العملاء / مسار الاستفسارات والمهتمين' : 'Customer Care / Leads & Inquiries Pipeline')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h3 style="font-size: 1.5rem; color: var(--primary-900); font-family: 'Playfair Display', serif;">
            {{ app()->getLocale() === 'ar' ? 'استفسارات العملاء وطلبات الشراء والبيع' : 'Client Inquiries & CRM Leads' }}
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            {{ app()->getLocale() === 'ar' ? 'مساحة عمل فريق خدمة العملاء للتواصل مع الملاك والمشترين ومتابعة المعاينات اليومية في جدة.' : 'Customer Service workspace to contact property owners, follow up with buyers, and manage viewings.' }}
        </p>
    </div>
</div>

<!-- STATS CARDS -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 2rem;">
    <a href="{{ route('admin.leads.index') }}" style="text-decoration: none;">
        <div class="luxury-card" style="padding: 1.25rem; text-align: center; border-bottom: 3px solid var(--accent-bronze);">
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-900); font-family: 'Playfair Display', serif;">{{ $counts['total'] }}</div>
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'كافة الطلبات' : 'All Leads' }}
            </div>
        </div>
    </a>

    <a href="{{ route('admin.leads.index', ['status' => 'new']) }}" style="text-decoration: none;">
        <div class="luxury-card" style="padding: 1.25rem; text-align: center; border-bottom: 3px solid #f59e0b;">
            <div style="font-size: 1.8rem; font-weight: 800; color: #b45309; font-family: 'Playfair Display', serif;">{{ $counts['new'] }}</div>
            <div style="font-size: 0.8rem; color: #b45309; font-weight: 700;">
                {{ app()->getLocale() === 'ar' ? 'طلبات جديدة بالانتظار' : 'Pending Inquiries' }}
            </div>
        </div>
    </a>

    <a href="{{ route('admin.leads.index', ['type' => 'buyer']) }}" style="text-decoration: none;">
        <div class="luxury-card" style="padding: 1.25rem; text-align: center; border-bottom: 3px solid var(--accent-gold);">
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-900); font-family: 'Playfair Display', serif;">{{ $counts['buyers'] }}</div>
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'مشترون ومستثمرون' : 'Prospective Buyers' }}
            </div>
        </div>
    </a>

    <a href="{{ route('admin.leads.index', ['type' => 'owner']) }}" style="text-decoration: none;">
        <div class="luxury-card" style="padding: 1.25rem; text-align: center; border-bottom: 3px solid #10b981;">
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-900); font-family: 'Playfair Display', serif;">{{ $counts['owners'] }}</div>
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'مُلّاك عقارات' : 'Property Owners' }}
            </div>
        </div>
    </a>
</div>

<!-- FILTER -->
<div class="luxury-card" style="padding: 1.25rem; margin-bottom: 2rem;">
    <form action="{{ route('admin.leads.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <div style="flex-grow: 1; min-width: 250px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="{{ app()->getLocale() === 'ar' ? 'البحث باسم العميل، البريد، الجوال، أو تفاصيل الرسالة...' : 'Search by client name, email, phone, or message...' }}">
        </div>

        <div style="width: 190px;">
            <select name="type" class="form-select">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كافة أنواع الطلبات' : 'All Types' }}</option>
                <option value="buyer" {{ request('type') === 'buyer' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مشتري / مستثمر' : 'Buyer / Investor' }}</option>
                <option value="owner" {{ request('type') === 'owner' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مالك عقار' : 'Property Owner' }}</option>
                <option value="inquiry" {{ request('type') === 'inquiry' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'استفسار عام' : 'General Inquiry' }}</option>
            </select>
        </div>

        <div style="width: 190px;">
            <select name="status" class="form-select">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كافة الحالات' : 'All Statuses' }}</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'جديد (بانتظار التواصل)' : 'New' }}</option>
                <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'تم التواصل' : 'Contacted' }}</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'قيد المتابعة / معاينة' : 'In Progress' }}</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مكتمل / تم البيع' : 'Closed' }}</option>
            </select>
        </div>

        <button type="submit" class="btn-luxury" style="padding: 0.75rem 1.25rem;">
            <i class="fa-solid fa-filter"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'تصفية' : 'Filter' }}</span>
        </button>

        @if(request()->hasAny(['search', 'type', 'status']))
            <a href="{{ route('admin.leads.index') }}" class="btn-outline-luxury" style="padding: 0.75rem 1rem;">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>
</div>

<!-- LEADS TABLE -->
<div class="luxury-table-container">
    <table class="luxury-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ app()->getLocale() === 'ar' ? 'العميل ومعلومات الاتصال' : 'Client Name & Contact' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'نوع الطلب' : 'Inquiry Type' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'العقار المعني' : 'Referenced Property' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الرسالة وملاحظات الفريق' : 'Message & Notes' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الموظف المسؤول' : 'Assigned Agent' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                <th>{{ app()->getLocale() === 'ar' ? 'الإجراء' : 'Action' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">
                        #{{ $lead->id }}
                    </td>
                    <td>
                        <strong style="color: var(--primary-900); font-size: 0.95rem; display: block;">{{ $lead->name }}</strong>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.35rem;">
                            <a href="tel:{{ $lead->phone }}" style="color: var(--accent-bronze); font-size: 0.85rem; font-weight: 600; direction: ltr; display: inline-block;">
                                <i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> {{ $lead->phone }}
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" style="color: #16a34a; font-size: 0.88rem;" title="{{ app()->getLocale() === 'ar' ? 'محادثة واتساب' : 'WhatsApp Chat' }}">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                        @if($lead->email)
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; direction: ltr; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ $lead->email }}</div>
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
                    <td style="max-width: 180px;">
                        @if($lead->propertyOffer)
                            <a href="{{ route('admin.offers.show', $lead->propertyOffer->id) }}" style="color: var(--primary-900); font-weight: 700; font-size: 0.88rem; display: block; text-decoration: none;" title="{{ app()->getLocale() === 'ar' ? 'عرض تفاصيل العقار وتواصل المالك' : 'View Offer & Owner Contact' }}">
                                <i class="fa-solid fa-file-invoice text-gold"></i> {{ $lead->propertyOffer->title }}
                            </a>
                            <div style="display: flex; align-items: center; gap: 0.4rem; margin-top: 2px;">
                                <span style="font-size: 0.75rem; color: var(--accent-bronze); font-weight: 600;">{{ $lead->propertyOffer->district }}</span>
                                <a href="{{ route('website.offers.show', $lead->propertyOffer->slug) }}" target="_blank" style="color: var(--text-muted); font-size: 0.72rem;" title="{{ app()->getLocale() === 'ar' ? 'معاينة بالموقع العام' : 'Public Link' }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.82rem;">{{ app()->getLocale() === 'ar' ? 'تواصل عام مع الإدارة' : 'General Agency Contact' }}</span>
                        @endif
                    </td>
                    <td style="max-width: 250px;">
                        <p style="font-size: 0.85rem; color: var(--primary-900); line-height: 1.5; margin-bottom: 0.35rem;">
                            "{{ $lead->message }}"
                        </p>
                        @if($lead->notes)
                            <div style="font-size: 0.78rem; background: var(--primary-50); padding: 0.35rem 0.5rem; border-radius: 6px; color: var(--accent-bronze); border-inline-start: 2px solid var(--accent-bronze);">
                                <strong>{{ app()->getLocale() === 'ar' ? 'ملاحظة خدمة العملاء:' : 'CS Note:' }}</strong> {{ $lead->notes }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: var(--primary-800); font-weight: 500;">
                            {{ $lead->assignee ? $lead->assignee->name : (app()->getLocale() === 'ar' ? 'غير مسند' : 'Unassigned') }}
                        </span>
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
                    <td>
                        <button type="button" class="btn-luxury btn-sm" onclick="openLeadModal({{ $lead->id }}, '{{ addslashes($lead->name) }}', '{{ $lead->status }}', '{{ addslashes($lead->notes) }}', '{{ $lead->assigned_to }}')">
                            <i class="fa-solid fa-headset"></i>
                            <span>{{ app()->getLocale() === 'ar' ? 'متابعة' : 'Follow Up' }}</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد طلبات تطابق الفلترة المحددة.' : 'No leads found matching the filters.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem;">
    {{ $leads->links() }}
</div>

<!-- CUSTOMER SERVICE FOLLOW-UP DIALOG MODAL -->
<div id="leadModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="luxury-card" style="max-width: 550px; width: 100%; padding: 2rem; background: #ffffff; position: relative;">
        <button type="button" onclick="closeLeadModal()" style="position: absolute; top: 1.25rem; {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1.25rem; background: none; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 1.35rem; color: var(--primary-900); margin-bottom: 0.25rem; font-family: 'Playfair Display', serif;" id="modalClientTitle">
            {{ app()->getLocale() === 'ar' ? 'متابعة طلب العميل' : 'Customer Service Follow-up' }}
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            {{ app()->getLocale() === 'ar' ? 'تحديث حالة الطلب، وتدوين ملاحظات المحادثة أو إسناد المعاملة لموظف.' : 'Update lead status, customer notes, or assign to an agent.' }}
        </p>

        <form id="leadUpdateForm" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'حالة تقدم الطلب *' : 'Inquiry Progress Status *' }}</label>
                <select name="status" id="modalStatus" required class="form-select">
                    <option value="new">{{ app()->getLocale() === 'ar' ? 'جديد (بانتظار أول اتصال)' : 'New (Uncontacted)' }}</option>
                    <option value="contacted">{{ app()->getLocale() === 'ar' ? 'تم التواصل (مكالمة هاتفية / واتساب)' : 'Contacted (Initial Call/WhatsApp Made)' }}</option>
                    <option value="in_progress">{{ app()->getLocale() === 'ar' ? 'قيد المتابعة (تم تحديد موعد معاينة / فحص أوراق)' : 'In Progress (Viewing Booked / Documents Review)' }}</option>
                    <option value="closed">{{ app()->getLocale() === 'ar' ? 'مكتمل (صفقة ناجحة)' : 'Closed (Deal Completed)' }}</option>
                    <option value="cancelled">{{ app()->getLocale() === 'ar' ? 'ملغي / غير مهتم' : 'Cancelled / Inactive' }}</option>
                </select>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'إسناد لموظف خدمة العملاء' : 'Assign to Customer Service Agent' }}</label>
                <select name="assigned_to" id="modalAssignee" class="form-select">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'غير مسند' : 'Unassigned' }}</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->job_title ?: ($agent->role ? $agent->role->display_name : 'Agent') }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">{{ app()->getLocale() === 'ar' ? 'سجل وملاحظات خدمة العملاء' : 'Customer Service Log / Notes' }}</label>
                <textarea name="notes" id="modalNotes" rows="4" class="form-textarea" placeholder="{{ app()->getLocale() === 'ar' ? 'سجل نتائج المكالمة مع المالك أو المشتري، مواعيد المعاينة، تفاصيل التفاوض المالي...' : 'Record outcome of conversation with owner or buyer, requested viewing dates, price negotiation notes...' }}"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeLeadModal()" class="btn-outline-luxury">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Close' }}</button>
                <button type="submit" class="btn-luxury">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'حفظ التحديث' : 'Save Update' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openLeadModal(id, clientName, status, notes, assignedTo) {
    const isAr = {{ app()->getLocale() === 'ar' ? 'true' : 'false' }};
    document.getElementById('modalClientTitle').innerText = (isAr ? 'متابعة العميل: ' : 'Follow-up: ') + clientName;
    document.getElementById('modalStatus').value = status;
    document.getElementById('modalNotes').value = notes || '';
    document.getElementById('modalAssignee').value = assignedTo || '';
    document.getElementById('leadUpdateForm').action = '{{ url('/admin/leads') }}/' + id + '/status';
    document.getElementById('leadModal').style.display = 'flex';
}

function closeLeadModal() {
    document.getElementById('leadModal').style.display = 'none';
}
</script>
@endsection

