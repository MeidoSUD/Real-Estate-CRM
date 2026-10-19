<?php

namespace Database\Seeders;

use App\Models\PropertyDropdownOption;
use Illuminate\Database\Seeder;

class PropertyDropdownOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            // 1. Property Categories
            [
                'type' => 'property_category',
                'items' => [
                    ['name_ar' => 'سكني', 'name_en' => 'Residential', 'value' => 'residential', 'order' => 1],
                    ['name_ar' => 'تجاري', 'name_en' => 'Commercial', 'value' => 'commercial', 'order' => 2],
                    ['name_ar' => 'سكني تجاري', 'name_en' => 'Mixed Residential & Commercial', 'value' => 'mixed', 'order' => 3],
                    ['name_ar' => 'صناعي', 'name_en' => 'Industrial', 'value' => 'industrial', 'order' => 4],
                    ['name_ar' => 'زراعي', 'name_en' => 'Agricultural', 'value' => 'agricultural', 'order' => 5],
                ],
            ],

            // 2. Property Types
            [
                'type' => 'property_type',
                'items' => [
                    ['name_ar' => 'فيلا مستقلة', 'name_en' => 'Standalone Villa', 'value' => 'villa', 'order' => 1],
                    ['name_ar' => 'تاون هاوس', 'name_en' => 'Townhouse', 'value' => 'townhouse', 'order' => 2],
                    ['name_ar' => 'شقة فاخرة', 'name_en' => 'Luxury Apartment', 'value' => 'apartment', 'order' => 3],
                    ['name_ar' => 'بنتهاوس', 'name_en' => 'Penthouse', 'value' => 'penthouse', 'order' => 4],
                    ['name_ar' => 'دوبلكس', 'name_en' => 'Duplex', 'value' => 'duplex', 'order' => 5],
                    ['name_ar' => 'قصر فاره', 'name_en' => 'Palace', 'value' => 'palace', 'order' => 6],
                    ['name_ar' => 'قطعة أرض سكنية', 'name_en' => 'Residential Land Plot', 'value' => 'land_residential', 'order' => 7],
                    ['name_ar' => 'قطعة أرض تجارية', 'name_en' => 'Commercial Land Plot', 'value' => 'land_commercial', 'order' => 8],
                    ['name_ar' => 'عمارة سكنية', 'name_en' => 'Residential Building', 'value' => 'building_residential', 'order' => 9],
                    ['name_ar' => 'عمارة تجارية', 'name_en' => 'Commercial Building', 'value' => 'building_commercial', 'order' => 10],
                    ['name_ar' => 'مجمع سكني (كمباوند)', 'name_en' => 'Residential Compound', 'value' => 'compound', 'order' => 11],
                    ['name_ar' => 'مكتب تجاري', 'name_en' => 'Commercial Office', 'value' => 'office', 'order' => 12],
                    ['name_ar' => 'معرض / صالة تجارية', 'name_en' => 'Showroom', 'value' => 'showroom', 'order' => 13],
                    ['name_ar' => 'مستودع / هنجر', 'name_en' => 'Warehouse', 'value' => 'warehouse', 'order' => 14],
                ],
            ],

            // 3. Deed Property Types
            [
                'type' => 'deed_property_type',
                'items' => [
                    ['name_ar' => 'قطعة أرض', 'name_en' => 'Land Plot', 'value' => 'land', 'order' => 1],
                    ['name_ar' => 'فيلا', 'name_en' => 'Villa', 'value' => 'villa', 'order' => 2],
                    ['name_ar' => 'عمارة', 'name_en' => 'Building', 'value' => 'building', 'order' => 3],
                    ['name_ar' => 'شقة', 'name_en' => 'Apartment', 'value' => 'apartment', 'order' => 4],
                    ['name_ar' => 'دور سكني', 'name_en' => 'Residential Floor', 'value' => 'floor', 'order' => 5],
                    ['name_ar' => 'قصر', 'name_en' => 'Palace', 'value' => 'palace', 'order' => 6],
                    ['name_ar' => 'مجمع تجاري', 'name_en' => 'Commercial Complex', 'value' => 'complex', 'order' => 7],
                    ['name_ar' => 'مستودع', 'name_en' => 'Warehouse', 'value' => 'warehouse', 'order' => 8],
                ],
            ],

            // 4. Property Grades
            [
                'type' => 'property_grade',
                'items' => [
                    ['name_ar' => 'سوبر لوكس', 'name_en' => 'Super Luxury', 'value' => 'super_luxury', 'order' => 1],
                    ['name_ar' => 'فاخر VIP', 'name_en' => 'VIP Luxury', 'value' => 'vip_luxury', 'order' => 2],
                    ['name_ar' => 'استثماري واعد', 'name_en' => 'High-Yield Investment', 'value' => 'investment', 'order' => 3],
                    ['name_ar' => 'تجاري مميز', 'name_en' => 'Prime Commercial', 'value' => 'prime_commercial', 'order' => 4],
                    ['name_ar' => 'متوسط', 'name_en' => 'Standard', 'value' => 'standard', 'order' => 5],
                    ['name_ar' => 'اقتصادي', 'name_en' => 'Economy', 'value' => 'economy', 'order' => 6],
                ],
            ],

            // 5. Contract Types
            [
                'type' => 'contract_type',
                'items' => [
                    ['name_ar' => 'تسويق حصري', 'name_en' => 'Exclusive Marketing', 'value' => 'exclusive', 'order' => 1],
                    ['name_ar' => 'تسويق غير حصري', 'name_en' => 'Non-Exclusive Marketing', 'value' => 'non_exclusive', 'order' => 2],
                    ['name_ar' => 'وساطة عقارية', 'name_en' => 'Brokerage', 'value' => 'brokerage', 'order' => 3],
                    ['name_ar' => 'إدارة أملاك وتأجير', 'name_en' => 'Property Management', 'value' => 'property_management', 'order' => 4],
                ],
            ],

            // 6. Finishing Types
            [
                'type' => 'finishing_type',
                'items' => [
                    ['name_ar' => 'ألترا مودرن فاخر', 'name_en' => 'Ultra Modern Luxury', 'value' => 'ultra_modern', 'order' => 1],
                    ['name_ar' => 'سوبر ديلوكس', 'name_en' => 'Super Deluxe', 'value' => 'super_deluxe', 'order' => 2],
                    ['name_ar' => 'ديلوكس كامل', 'name_en' => 'Deluxe', 'value' => 'deluxe', 'order' => 3],
                    ['name_ar' => 'نصف تشطيب', 'name_en' => 'Semi-Finished', 'value' => 'semi_finished', 'order' => 4],
                    ['name_ar' => 'بدون تشطيب (عظم)', 'name_en' => 'Core & Shell (Raw)', 'value' => 'core_shell', 'order' => 5],
                ],
            ],

            // 7. Property Usages
            [
                'type' => 'property_usage',
                'items' => [
                    ['name_ar' => 'سكني', 'name_en' => 'Residential', 'value' => 'residential', 'order' => 1],
                    ['name_ar' => 'تجاري', 'name_en' => 'Commercial', 'value' => 'commercial', 'order' => 2],
                    ['name_ar' => 'سكني وتجاري', 'name_en' => 'Mixed Residential & Commercial', 'value' => 'mixed', 'order' => 3],
                    ['name_ar' => 'إداري ومكتبي', 'name_en' => 'Office & Administrative', 'value' => 'office', 'order' => 4],
                    ['name_ar' => 'سياحي وترفيهي', 'name_en' => 'Tourism & Hospitality', 'value' => 'hospitality', 'order' => 5],
                ],
            ],

            // 8. Unit Positions
            [
                'type' => 'unit_position',
                'items' => [
                    ['name_ar' => 'واجهة أمامية رئيسية', 'name_en' => 'Front Facade', 'value' => 'front', 'order' => 1],
                    ['name_ar' => 'زاوية (على شارعين)', 'name_en' => 'Corner (Two Streets)', 'value' => 'corner', 'order' => 2],
                    ['name_ar' => 'إطلالة بحرية مباشرة', 'name_en' => 'Direct Waterfront View', 'value' => 'waterfront', 'order' => 3],
                    ['name_ar' => 'واجهة خلفية هادئة', 'name_en' => 'Rear Quiet Facing', 'value' => 'rear', 'order' => 4],
                    ['name_ar' => 'دور كامل مستقل', 'name_en' => 'Full Private Floor', 'value' => 'full_floor', 'order' => 5],
                ],
            ],

            // 9. Districts
            [
                'type' => 'district',
                'items' => [
                    ['name_ar' => 'حي الشاطئ', 'name_en' => 'Al-Shati', 'value' => 'Al-Shati', 'order' => 1],
                    ['name_ar' => 'حي الروضة', 'name_en' => 'Al-Rawdah', 'value' => 'Al-Rawdah', 'order' => 2],
                    ['name_ar' => 'حي الحمراء', 'name_en' => 'Al-Hamra', 'value' => 'Al-Hamra', 'order' => 3],
                    ['name_ar' => 'أبحر الشمالية', 'name_en' => 'Obhur Al-Shamaliyah', 'value' => 'Obhur Al-Shamaliyah', 'order' => 4],
                    ['name_ar' => 'أبحر الجنوبية', 'name_en' => 'Obhur Al-Janubiyah', 'value' => 'Obhur Al-Janubiyah', 'order' => 5],
                    ['name_ar' => 'حي المحمدية', 'name_en' => 'Al-Mohammadiyah', 'value' => 'Al-Mohammadiyah', 'order' => 6],
                    ['name_ar' => 'حي المرجان', 'name_en' => 'Al-Murjan', 'value' => 'Al-Murjan', 'order' => 7],
                    ['name_ar' => 'حي السلامة', 'name_en' => 'Al-Salama', 'value' => 'Al-Salama', 'order' => 8],
                    ['name_ar' => 'حي البساتين', 'name_en' => 'Al-Basateen', 'value' => 'Al-Basateen', 'order' => 9],
                    ['name_ar' => 'حي الخالدية', 'name_en' => 'Al-Khalidiyah', 'value' => 'Al-Khalidiyah', 'order' => 10],
                    ['name_ar' => 'حي الأندلس', 'name_en' => 'Al-Andalus', 'value' => 'Al-Andalus', 'order' => 11],
                    ['name_ar' => 'حي النعيم', 'name_en' => 'Al-Naeem', 'value' => 'Al-Naeem', 'order' => 12],
                    ['name_ar' => 'حي الصفا', 'name_en' => 'Al-Safa', 'value' => 'Al-Safa', 'order' => 13],
                    ['name_ar' => 'الكورنيش الشمالي', 'name_en' => 'North Corniche', 'value' => 'North Corniche', 'order' => 14],
                ],
            ],

            // 10. Utilities & Services
            [
                'type' => 'utility',
                'items' => [
                    ['name_ar' => 'شبكة مياه وطنية', 'name_en' => 'Public Water Network', 'value' => 'water', 'order' => 1],
                    ['name_ar' => 'شبكة كهرباء', 'name_en' => 'Electricity Network', 'value' => 'electricity', 'order' => 2],
                    ['name_ar' => 'شبكة صرف صحي', 'name_en' => 'Sewage Network', 'value' => 'sewage', 'order' => 3],
                    ['name_ar' => 'ألياف بصرية (فايبر)', 'name_en' => 'Fiber Optic High-Speed Internet', 'value' => 'fiber', 'order' => 4],
                    ['name_ar' => 'إنارة شوارع', 'name_en' => 'Street Lighting', 'value' => 'street_lighting', 'order' => 5],
                    ['name_ar' => 'شوارع مسفلتة', 'name_en' => 'Paved Asphalt Roads', 'value' => 'paved_roads', 'order' => 6],
                    ['name_ar' => 'نظام تصريف سيول', 'name_en' => 'Stormwater Drainage', 'value' => 'drainage', 'order' => 7],
                ],
            ],
        ];

        foreach ($options as $group) {
            $type = $group['type'];
            foreach ($group['items'] as $item) {
                PropertyDropdownOption::updateOrCreate(
                    [
                        'type' => $type,
                        'value' => $item['value'],
                    ],
                    [
                        'name_ar' => $item['name_ar'],
                        'name_en' => $item['name_en'],
                        'order' => $item['order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
