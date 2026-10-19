<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDropdownOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name_ar',
        'name_en',
        'value',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get bilingual name according to current app locale.
     */
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?: $this->name_ar);
    }

    /**
     * Scope for active options only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Helper to get active options for a dropdown type.
     */
    public static function getOptions(string $type)
    {
        return static::active()
            ->ofType($type)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Types catalog with bilingual titles for the Admin management panel.
     */
    public static function getTypesCatalog(): array
    {
        return [
            'property_category' => [
                'name_ar' => 'أقسام العقار',
                'name_en' => 'Property Categories',
                'icon' => 'layer-group',
            ],
            'property_type' => [
                'name_ar' => 'أنواع العقار',
                'name_en' => 'Property Types',
                'icon' => 'building',
            ],
            'deed_property_type' => [
                'name_ar' => 'نوع العقار في الصك',
                'name_en' => 'Property Type in Deed',
                'icon' => 'file-contract',
            ],
            'property_grade' => [
                'name_ar' => 'فئات العقار',
                'name_en' => 'Property Grades / Classes',
                'icon' => 'crown',
            ],
            'contract_type' => [
                'name_ar' => 'أنواع العقود',
                'name_en' => 'Contract Types',
                'icon' => 'signature',
            ],
            'finishing_type' => [
                'name_ar' => 'أنواع التشطيب',
                'name_en' => 'Finishing Types',
                'icon' => 'paint-roller',
            ],
            'property_usage' => [
                'name_ar' => 'استخدامات العقار',
                'name_en' => 'Property Usages',
                'icon' => 'briefcase',
            ],
            'unit_position' => [
                'name_ar' => 'مكان العقار بالوحدة',
                'name_en' => 'Position in Unit',
                'icon' => 'compass',
            ],
            'district' => [
                'name_ar' => 'الأحياء والمناطق',
                'name_en' => 'Districts & Locations',
                'icon' => 'location-dot',
            ],
            'utility' => [
                'name_ar' => 'الخدمات والمرافق',
                'name_en' => 'Utilities & Services',
                'icon' => 'faucet-drip',
            ],
        ];
    }
}
