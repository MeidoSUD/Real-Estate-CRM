<?php

namespace App\Http\Controllers;

use App\Models\PropertyDropdownOption;
use App\Models\PropertyOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OfferController extends Controller
{
    /**
     * Display listings with filters.
     */
    public function index(Request $request): View
    {
        $query = PropertyOffer::with('creator');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('deed_number', 'like', "%{$search}%")
                  ->orWhere('ad_license_number', 'like', "%{$search}%")
                  ->orWhere('property_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('district')) {
            $query->where('district', $request->input('district'));
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->input('property_type'));
        }

        if ($request->filled('property_category')) {
            $query->where('property_category', $request->input('property_category'));
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->input('purpose'));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->filled('hide_sold') && $request->boolean('hide_sold')) {
            $query->whereNotIn('status', ['sold', 'rented']);
        }

        $offers = $query->latest()->paginate(12)->withQueryString();

        $districts = PropertyDropdownOption::getOptions('district');
        $propertyTypes = PropertyDropdownOption::getOptions('property_type');
        $propertyCategories = PropertyDropdownOption::getOptions('property_category');

        return view('admin.offers.index', compact('offers', 'districts', 'propertyTypes', 'propertyCategories'));
    }

    /**
     * Show form to create new offer matching the 10-tab wizard layout.
     */
    public function create(): View
    {
        $dropdowns = $this->loadDropdownOptions();
        return view('admin.offers.create', $dropdowns);
    }

    /**
     * Store newly created offer with all contract, REGA, categorized media, and address attributes.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'property_type' => ['required', 'string', 'max:100'],
            'property_category' => ['nullable', 'string', 'max:100'],
            'deed_property_type' => ['nullable', 'string', 'max:100'],
            'property_grade' => ['nullable', 'string', 'max:100'],
            'purpose' => ['required', Rule::in(['sale', 'rent'])],
            'price' => ['required', 'numeric', 'min:0'],
            'city' => ['required', 'string', 'max:100'],
            'region' => ['nullable', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'area_sqm' => ['required', 'numeric', 'min:1'],
            'status' => ['required', Rule::in(['available', 'reserved', 'sold', 'rented'])],

            // Contract & Owner Info
            'contract_type' => ['nullable', 'string', 'max:100'],
            'deed_number' => ['nullable', 'string', 'max:100'],
            'plan_number' => ['nullable', 'string', 'max:100'],
            'parcel_number' => ['nullable', 'string', 'max:100'],
            'contract_duration_months' => ['nullable', 'integer', 'min:1'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_phone' => ['nullable', 'string', 'max:50'],
            'owner_national_id' => ['nullable', 'string', 'max:50'],
            'has_agency_poa' => ['nullable', 'string', 'max:20'],
            'deed_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,pdf', 'max:5120'],

            // Basic Data
            'floors_count' => ['nullable', 'integer', 'min:0'],
            'has_upper_annex' => ['nullable', 'string', 'max:20'],
            'unit_position' => ['nullable', 'string', 'max:100'],
            'finishing_type' => ['nullable', 'string', 'max:100'],

            // Property Info
            'property_usage' => ['nullable', 'string', 'max:100'],
            'property_age' => ['nullable', 'string', 'max:100'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'guarantees' => ['nullable', 'string'],
            'property_liabilities' => ['nullable', 'string'],
            'property_disputes' => ['nullable', 'string'],

            // Official REGA
            'has_restrictions' => ['nullable', 'boolean'],
            'has_mortgage' => ['nullable', 'boolean'],
            'ad_license_number' => ['nullable', 'string', 'max:100'],

            // National Address & Map
            'street_name' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'building_number' => ['nullable', 'string', 'max:20'],
            'additional_number' => ['nullable', 'string', 'max:20'],
            'map_link' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],

            // Video & Notes
            'video_url' => ['nullable', 'string', 'max:500'],
            'internal_notes' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            // Arrays
            'advertising_channels' => ['nullable', 'array'],
            'features' => ['nullable', 'array'],
            'utilities_services' => ['nullable', 'array'],
            'categorized_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        // Auto-generate title if missing
        $titleAr = !empty($validated['title_ar'])
            ? $validated['title_ar']
            : (($validated['property_type'] ?? 'عقار') . ' فاخرة في ' . ($validated['district'] ?? ''));
        $titleEn = !empty($validated['title'])
            ? $validated['title']
            : (($validated['property_type'] ?? 'Property') . ' in ' . ($validated['district'] ?? ''));

        // Handle Deed Attachment
        $deedImagePath = null;
        if ($request->hasFile('deed_image')) {
            $deedImagePath = $request->file('deed_image')->store('properties/deeds', 'public');
        }

        // Handle Main Image fallback
        $mainImagePath = 'images/properties/villa_alshati.jpg';
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('properties', 'public');
        }

        // Handle Categorized Media Uploads
        $categorizedImages = [];
        if ($request->hasFile('categorized_images')) {
            foreach ($request->file('categorized_images') as $slot => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('properties/rooms', 'public');
                    $categorizedImages[$slot] = $path;

                    // If facade_main uploaded and main_image was not set, use it as main
                    if ($slot === 'facade_main' && !$request->hasFile('main_image')) {
                        $mainImagePath = $path;
                    }
                }
            }
        }

        $offer = PropertyOffer::create([
            'title' => $titleEn,
            'title_ar' => $titleAr,
            'slug' => Str::slug($titleEn) . '-' . rand(1000, 9999),
            'property_type' => $validated['property_type'],
            'property_category' => $validated['property_category'] ?? 'residential',
            'deed_property_type' => $validated['deed_property_type'] ?? null,
            'property_grade' => $validated['property_grade'] ?? null,
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'currency' => 'SAR',
            'city' => $validated['city'],
            'region' => $validated['region'] ?? 'منطقة مكة المكرمة',
            'district' => $validated['district'],
            'address' => !empty($validated['street_name']) ? ($validated['street_name'] . '، ' . $validated['district']) : $validated['district'],
            'street_name' => $validated['street_name'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'building_number' => $validated['building_number'] ?? null,
            'additional_number' => $validated['additional_number'] ?? null,
            'map_link' => $validated['map_link'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'area_sqm' => $validated['area_sqm'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->has('is_featured'),
            'main_image' => $mainImagePath,
            'created_by' => auth()->id(),

            // Extended Fields
            'contract_type' => $validated['contract_type'] ?? null,
            'deed_number' => $validated['deed_number'] ?? null,
            'plan_number' => $validated['plan_number'] ?? null,
            'parcel_number' => $validated['parcel_number'] ?? null,
            'contract_duration_months' => $validated['contract_duration_months'] ?? null,
            'owner_name' => $validated['owner_name'] ?? null,
            'owner_phone' => $validated['owner_phone'] ?? null,
            'owner_national_id' => $validated['owner_national_id'] ?? null,
            'has_agency_poa' => $validated['has_agency_poa'] ?? 'no',
            'deed_image' => $deedImagePath,
            'advertising_channels' => $validated['advertising_channels'] ?? [],
            'floors_count' => $validated['floors_count'] ?? null,
            'has_upper_annex' => $validated['has_upper_annex'] ?? 'no',
            'unit_position' => $validated['unit_position'] ?? null,
            'finishing_type' => $validated['finishing_type'] ?? null,
            'property_usage' => $validated['property_usage'] ?? null,
            'property_age' => $validated['property_age'] ?? null,
            'guarantees' => $validated['guarantees'] ?? null,
            'property_liabilities' => $validated['property_liabilities'] ?? null,
            'property_disputes' => $validated['property_disputes'] ?? null,
            'has_restrictions' => $request->boolean('has_restrictions'),
            'has_mortgage' => $request->boolean('has_mortgage'),
            'ad_license_number' => $validated['ad_license_number'] ?? null,
            'features' => $validated['features'] ?? [],
            'utilities_services' => $validated['utilities_services'] ?? [],
            'categorized_images' => $categorizedImages,
            'video_url' => $validated['video_url'] ?? null,
            'internal_notes' => $validated['internal_notes'] ?? null,
        ]);

        return redirect()->route('admin.offers.index')
            ->with('success', app()->getLocale() === 'ar' ? 'تم إنشاء وحفظ العرض العقاري بنجاح.' : 'Property offer created successfully.');
    }

    /**
     * Display internal CRM property offer details with role-based owner contact visibility.
     */
    public function show(PropertyOffer $offer): View
    {
        $offer->load('creator');
        return view('admin.offers.show', compact('offer'));
    }

    /**
     * Show form to edit an existing offer.
     */
    public function edit(PropertyOffer $offer): View
    {
        $dropdowns = $this->loadDropdownOptions();
        $dropdowns['offer'] = $offer;
        return view('admin.offers.edit', $dropdowns);
    }

    /**
     * Update an existing offer.
     */
    public function update(Request $request, PropertyOffer $offer): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'property_type' => ['required', 'string', 'max:100'],
            'property_category' => ['nullable', 'string', 'max:100'],
            'deed_property_type' => ['nullable', 'string', 'max:100'],
            'property_grade' => ['nullable', 'string', 'max:100'],
            'purpose' => ['required', Rule::in(['sale', 'rent'])],
            'price' => ['required', 'numeric', 'min:0'],
            'city' => ['required', 'string', 'max:100'],
            'region' => ['nullable', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'area_sqm' => ['required', 'numeric', 'min:1'],
            'status' => ['required', Rule::in(['available', 'reserved', 'sold', 'rented'])],

            // Contract & Owner Info
            'contract_type' => ['nullable', 'string', 'max:100'],
            'deed_number' => ['nullable', 'string', 'max:100'],
            'plan_number' => ['nullable', 'string', 'max:100'],
            'parcel_number' => ['nullable', 'string', 'max:100'],
            'contract_duration_months' => ['nullable', 'integer', 'min:1'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_phone' => ['nullable', 'string', 'max:50'],
            'owner_national_id' => ['nullable', 'string', 'max:50'],
            'has_agency_poa' => ['nullable', 'string', 'max:20'],
            'deed_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,pdf', 'max:5120'],

            // Basic Data
            'floors_count' => ['nullable', 'integer', 'min:0'],
            'has_upper_annex' => ['nullable', 'string', 'max:20'],
            'unit_position' => ['nullable', 'string', 'max:100'],
            'finishing_type' => ['nullable', 'string', 'max:100'],

            // Property Info
            'property_usage' => ['nullable', 'string', 'max:100'],
            'property_age' => ['nullable', 'string', 'max:100'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'guarantees' => ['nullable', 'string'],
            'property_liabilities' => ['nullable', 'string'],
            'property_disputes' => ['nullable', 'string'],

            // Official REGA
            'has_restrictions' => ['nullable', 'boolean'],
            'has_mortgage' => ['nullable', 'boolean'],
            'ad_license_number' => ['nullable', 'string', 'max:100'],

            // National Address & Map
            'street_name' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'building_number' => ['nullable', 'string', 'max:20'],
            'additional_number' => ['nullable', 'string', 'max:20'],
            'map_link' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],

            // Video & Notes
            'video_url' => ['nullable', 'string', 'max:500'],
            'internal_notes' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            // Arrays
            'advertising_channels' => ['nullable', 'array'],
            'features' => ['nullable', 'array'],
            'utilities_services' => ['nullable', 'array'],
            'categorized_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $data = [
            'title' => !empty($validated['title']) ? $validated['title'] : $offer->title,
            'title_ar' => !empty($validated['title_ar']) ? $validated['title_ar'] : $offer->title_ar,
            'property_type' => $validated['property_type'],
            'property_category' => $validated['property_category'] ?? $offer->property_category,
            'deed_property_type' => $validated['deed_property_type'] ?? $offer->deed_property_type,
            'property_grade' => $validated['property_grade'] ?? $offer->property_grade,
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'city' => $validated['city'],
            'region' => $validated['region'] ?? $offer->region,
            'district' => $validated['district'],
            'address' => !empty($validated['street_name']) ? ($validated['street_name'] . '، ' . $validated['district']) : ($offer->address ?? $validated['district']),
            'street_name' => $validated['street_name'] ?? $offer->street_name,
            'postal_code' => $validated['postal_code'] ?? $offer->postal_code,
            'building_number' => $validated['building_number'] ?? $offer->building_number,
            'additional_number' => $validated['additional_number'] ?? $offer->additional_number,
            'map_link' => $validated['map_link'] ?? $offer->map_link,
            'latitude' => $validated['latitude'] ?? $offer->latitude,
            'longitude' => $validated['longitude'] ?? $offer->longitude,
            'bedrooms' => $validated['bedrooms'] ?? $offer->bedrooms,
            'bathrooms' => $validated['bathrooms'] ?? $offer->bathrooms,
            'area_sqm' => $validated['area_sqm'],
            'description' => $validated['description'] ?? $offer->description,
            'status' => $validated['status'],
            'is_featured' => $request->has('is_featured'),

            // Extended
            'contract_type' => $validated['contract_type'] ?? $offer->contract_type,
            'deed_number' => $validated['deed_number'] ?? $offer->deed_number,
            'plan_number' => $validated['plan_number'] ?? $offer->plan_number,
            'parcel_number' => $validated['parcel_number'] ?? $offer->parcel_number,
            'contract_duration_months' => $validated['contract_duration_months'] ?? $offer->contract_duration_months,
            'has_agency_poa' => $validated['has_agency_poa'] ?? $offer->has_agency_poa,
            'advertising_channels' => $validated['advertising_channels'] ?? ($offer->advertising_channels ?: []),
            'floors_count' => $validated['floors_count'] ?? $offer->floors_count,
            'has_upper_annex' => $validated['has_upper_annex'] ?? $offer->has_upper_annex,
            'unit_position' => $validated['unit_position'] ?? $offer->unit_position,
            'finishing_type' => $validated['finishing_type'] ?? $offer->finishing_type,
            'property_usage' => $validated['property_usage'] ?? $offer->property_usage,
            'property_age' => $validated['property_age'] ?? $offer->property_age,
            'guarantees' => $validated['guarantees'] ?? $offer->guarantees,
            'property_liabilities' => $validated['property_liabilities'] ?? $offer->property_liabilities,
            'property_disputes' => $validated['property_disputes'] ?? $offer->property_disputes,
            'has_restrictions' => $request->boolean('has_restrictions'),
            'has_mortgage' => $request->boolean('has_mortgage'),
            'ad_license_number' => $validated['ad_license_number'] ?? $offer->ad_license_number,
            'features' => $validated['features'] ?? ($offer->features ?: []),
            'utilities_services' => $validated['utilities_services'] ?? ($offer->utilities_services ?: []),
            'video_url' => $validated['video_url'] ?? $offer->video_url,
        ];

        // Owner confidential details: only users with permission can update them
        if (auth()->user()->canViewOwnerContact()) {
            $data['owner_name'] = $validated['owner_name'] ?? $offer->owner_name;
            $data['owner_phone'] = $validated['owner_phone'] ?? $offer->owner_phone;
            $data['owner_national_id'] = $validated['owner_national_id'] ?? $offer->owner_national_id;
            $data['internal_notes'] = $validated['internal_notes'] ?? $offer->internal_notes;
        } else {
            // Preserve existing owner details and notes intact
            $data['owner_name'] = $offer->owner_name;
            $data['owner_phone'] = $offer->owner_phone;
            $data['owner_national_id'] = $offer->owner_national_id;
            $data['internal_notes'] = $offer->internal_notes;
        }

        // Handle Deed Attachment (only if user has permission to view/manage owner documents)
        if (auth()->user()->canViewOwnerContact() && $request->hasFile('deed_image')) {
            $data['deed_image'] = $request->file('deed_image')->store('properties/deeds', 'public');
        }

        // Handle Main Image
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('properties', 'public');
        }

        // Handle Categorized Media Uploads
        $categorizedImages = $offer->categorized_images ?: [];
        if ($request->hasFile('categorized_images')) {
            foreach ($request->file('categorized_images') as $slot => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('properties/rooms', 'public');
                    $categorizedImages[$slot] = $path;

                    if ($slot === 'facade_main' && !$request->hasFile('main_image')) {
                        $data['main_image'] = $path;
                    }
                }
            }
        }
        $data['categorized_images'] = $categorizedImages;

        $offer->update($data);

        return redirect()->route('admin.offers.index')
            ->with('success', app()->getLocale() === 'ar' ? 'تم تحديث بيانات العرض العقاري بنجاح.' : 'Property offer updated successfully.');
    }

    /**
     * Delete an offer.
     */
    public function destroy(PropertyOffer $offer): RedirectResponse
    {
        if ($offer->main_image && !str_starts_with($offer->main_image, 'images/') && Storage::disk('public')->exists($offer->main_image)) {
            Storage::disk('public')->delete($offer->main_image);
        }

        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', app()->getLocale() === 'ar' ? 'تم حذف العرض العقاري بنجاح.' : 'Property offer deleted successfully.');
    }

    /**
     * Helper to load all active lookup options for forms.
     */
    private function loadDropdownOptions(): array
    {
        return [
            'propertyCategories' => PropertyDropdownOption::getOptions('property_category'),
            'propertyTypes' => PropertyDropdownOption::getOptions('property_type'),
            'deedPropertyTypes' => PropertyDropdownOption::getOptions('deed_property_type'),
            'propertyGrades' => PropertyDropdownOption::getOptions('property_grade'),
            'contractTypes' => PropertyDropdownOption::getOptions('contract_type'),
            'finishingTypes' => PropertyDropdownOption::getOptions('finishing_type'),
            'propertyUsages' => PropertyDropdownOption::getOptions('property_usage'),
            'unitPositions' => PropertyDropdownOption::getOptions('unit_position'),
            'districts' => PropertyDropdownOption::getOptions('district'),
            'utilities' => PropertyDropdownOption::getOptions('utility'),
        ];
    }
}
