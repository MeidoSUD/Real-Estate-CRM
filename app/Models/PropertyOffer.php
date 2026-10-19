<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PropertyOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'property_type',
        'purpose',
        'price',
        'currency',
        'city',
        'region',
        'district',
        'address',
        'street_name',
        'postal_code',
        'building_number',
        'additional_number',
        'map_link',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'description',
        'features',
        'main_image',
        'gallery',
        'categorized_images',
        'status',
        'is_featured',
        'created_by',

        // Extended Old CRM Fields
        'contract_type',
        'deed_number',
        'plan_number',
        'parcel_number',
        'contract_duration_months',
        'has_agency_poa',
        'deed_image',
        'advertising_channels',
        'property_category',
        'deed_property_type',
        'property_grade',
        'floors_count',
        'has_upper_annex',
        'unit_position',
        'finishing_type',
        'property_usage',
        'property_age',
        'rooms_breakdown',
        'utilities_services',
        'guarantees',
        'property_liabilities',
        'property_disputes',
        'has_restrictions',
        'has_mortgage',
        'ad_license_number',
        'video_url',
        'internal_notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area_sqm' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floors_count' => 'integer',
        'contract_duration_months' => 'integer',
        'features' => 'array',
        'gallery' => 'array',
        'categorized_images' => 'array',
        'advertising_channels' => 'array',
        'rooms_breakdown' => 'array',
        'utilities_services' => 'array',
        'is_featured' => 'boolean',
        'has_restrictions' => 'boolean',
        'has_mortgage' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($offer) {
            if (empty($offer->slug)) {
                $offer->slug = Str::slug($offer->title) . '-' . rand(1000, 9999);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0) . ' ' . $this->currency;
    }
}
