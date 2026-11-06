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

            // 9. Cities & Governorates Across Saudi Arabia (مدن ومحافظات المملكة)
            [
                'type' => 'city',
                'items' => [
                    ['name_ar' => 'الرياض', 'name_en' => 'Riyadh', 'value' => 'Riyadh', 'order' => 1],
                    ['name_ar' => 'جدة', 'name_en' => 'Jeddah', 'value' => 'Jeddah', 'order' => 2],
                    ['name_ar' => 'مكة المكرمة', 'name_en' => 'Makkah', 'value' => 'Makkah', 'order' => 3],
                    ['name_ar' => 'المدينة المنورة', 'name_en' => 'Madinah', 'value' => 'Madinah', 'order' => 4],
                    ['name_ar' => 'الدمام', 'name_en' => 'Dammam', 'value' => 'Dammam', 'order' => 5],
                    ['name_ar' => 'الخبر', 'name_en' => 'Khobar', 'value' => 'Khobar', 'order' => 6],
                    ['name_ar' => 'الظهران', 'name_en' => 'Dhahran', 'value' => 'Dhahran', 'order' => 7],
                    ['name_ar' => 'الأحساء', 'name_en' => 'Al-Ahsa', 'value' => 'Al-Ahsa', 'order' => 8],
                    ['name_ar' => 'الجبيل', 'name_en' => 'Jubail', 'value' => 'Jubail', 'order' => 9],
                    ['name_ar' => 'الطائف', 'name_en' => 'Taif', 'value' => 'Taif', 'order' => 10],
                    ['name_ar' => 'ينبع', 'name_en' => 'Yanbu', 'value' => 'Yanbu', 'order' => 11],
                    ['name_ar' => 'الدرعية', 'name_en' => 'Diriyah', 'value' => 'Diriyah', 'order' => 12],
                    ['name_ar' => 'الخرج', 'name_en' => 'Al-Kharj', 'value' => 'Al-Kharj', 'order' => 13],
                    ['name_ar' => 'بريدة', 'name_en' => 'Buraidah', 'value' => 'Buraidah', 'order' => 14],
                    ['name_ar' => 'عنيزة', 'name_en' => 'Unaizah', 'value' => 'Unaizah', 'order' => 15],
                    ['name_ar' => 'أبها', 'name_en' => 'Abha', 'value' => 'Abha', 'order' => 16],
                    ['name_ar' => 'خميس مشيط', 'name_en' => 'Khamis Mushait', 'value' => 'Khamis-Mushait', 'order' => 17],
                    ['name_ar' => 'تبوك', 'name_en' => 'Tabuk', 'value' => 'Tabuk', 'order' => 18],
                    ['name_ar' => 'نيوم', 'name_en' => 'NEOM', 'value' => 'NEOM', 'order' => 19],
                    ['name_ar' => 'حائل', 'name_en' => 'Hail', 'value' => 'Hail', 'order' => 20],
                    ['name_ar' => 'جازان', 'name_en' => 'Jazan', 'value' => 'Jazan', 'order' => 21],
                    ['name_ar' => 'نجران', 'name_en' => 'Najran', 'value' => 'Najran', 'order' => 22],
                    ['name_ar' => 'سكاكا', 'name_en' => 'Sakaka', 'value' => 'Sakaka', 'order' => 23],
                    ['name_ar' => 'عرعر', 'name_en' => 'Arar', 'value' => 'Arar', 'order' => 24],
                    ['name_ar' => 'الباحة', 'name_en' => 'Al-Baha', 'value' => 'Al-Baha', 'order' => 25],
                ],
            ],

            // 10. Districts & Locations Across Saudi Arabia (أحياء ومناطق المملكة)
            [
                'type' => 'district',
                'items' => [
                    // === RIYADH (الرياض) ===
                    ['name_ar' => 'حي الملقا', 'name_en' => 'Al-Malqa', 'value' => 'Al-Malqa', 'parent_value' => 'Riyadh', 'order' => 1],
                    ['name_ar' => 'حي النرجس', 'name_en' => 'Al-Narjis', 'value' => 'Al-Narjis', 'parent_value' => 'Riyadh', 'order' => 2],
                    ['name_ar' => 'حي الياسمين', 'name_en' => 'Al-Yasmin', 'value' => 'Al-Yasmin', 'parent_value' => 'Riyadh', 'order' => 3],
                    ['name_ar' => 'حي حطين', 'name_en' => 'Hittin', 'value' => 'Hittin', 'parent_value' => 'Riyadh', 'order' => 4],
                    ['name_ar' => 'حي العارض', 'name_en' => 'Al-Arid', 'value' => 'Al-Arid', 'parent_value' => 'Riyadh', 'order' => 5],
                    ['name_ar' => 'حي الصحافة', 'name_en' => 'Al-Sahafa', 'value' => 'Al-Sahafa', 'parent_value' => 'Riyadh', 'order' => 6],
                    ['name_ar' => 'حي الغدير', 'name_en' => 'Al-Ghadir', 'value' => 'Al-Ghadir', 'parent_value' => 'Riyadh', 'order' => 7],
                    ['name_ar' => 'حي العقيق', 'name_en' => 'Al-Aqiq', 'value' => 'Al-Aqiq', 'parent_value' => 'Riyadh', 'order' => 8],
                    ['name_ar' => 'حي العليا (الرياض)', 'name_en' => 'Al-Olaya (Riyadh)', 'value' => 'Al-Olaya', 'parent_value' => 'Riyadh', 'order' => 9],
                    ['name_ar' => 'حي النخيل', 'name_en' => 'Al-Nakheel', 'value' => 'Al-Nakheel', 'parent_value' => 'Riyadh', 'order' => 10],
                    ['name_ar' => 'حي الرمال', 'name_en' => 'Al-Rimal', 'value' => 'Al-Rimal', 'parent_value' => 'Riyadh', 'order' => 11],
                    ['name_ar' => 'حي المونسية', 'name_en' => 'Al-Mounsiya', 'value' => 'Al-Mounsiya', 'parent_value' => 'Riyadh', 'order' => 12],
                    ['name_ar' => 'حي اليرموك', 'name_en' => 'Al-Yarmouk', 'value' => 'Al-Yarmouk', 'parent_value' => 'Riyadh', 'order' => 13],
                    ['name_ar' => 'حي قرطبة', 'name_en' => 'Qurtubah', 'value' => 'Qurtubah', 'parent_value' => 'Riyadh', 'order' => 14],
                    ['name_ar' => 'حي الروضة (الرياض)', 'name_en' => 'Al-Rawdah (Riyadh)', 'value' => 'Al-Rawdah-Riyadh', 'parent_value' => 'Riyadh', 'order' => 15],
                    ['name_ar' => 'حي الحمراء (الرياض)', 'name_en' => 'Al-Hamra (Riyadh)', 'value' => 'Al-Hamra-Riyadh', 'parent_value' => 'Riyadh', 'order' => 16],
                    ['name_ar' => 'حي الشفا', 'name_en' => 'Al-Shifa', 'value' => 'Al-Shifa', 'parent_value' => 'Riyadh', 'order' => 17],
                    ['name_ar' => 'حي السويدي', 'name_en' => 'Al-Suwaidi', 'value' => 'Al-Suwaidi', 'parent_value' => 'Riyadh', 'order' => 18],
                    ['name_ar' => 'حي ظهرة لبن', 'name_en' => 'Dhahrat Laban', 'value' => 'Dhahrat-Laban', 'parent_value' => 'Riyadh', 'order' => 19],
                    ['name_ar' => 'حي النسيم', 'name_en' => 'Al-Naseem', 'value' => 'Al-Naseem', 'parent_value' => 'Riyadh', 'order' => 20],

                    // === JEDDAH (جدة) ===
                    ['name_ar' => 'حي الشاطئ', 'name_en' => 'Al-Shati', 'value' => 'Al-Shati', 'parent_value' => 'Jeddah', 'order' => 21],
                    ['name_ar' => 'حي الروضة', 'name_en' => 'Al-Rawdah', 'value' => 'Al-Rawdah', 'parent_value' => 'Jeddah', 'order' => 22],
                    ['name_ar' => 'حي الحمراء', 'name_en' => 'Al-Hamra', 'value' => 'Al-Hamra', 'parent_value' => 'Jeddah', 'order' => 23],
                    ['name_ar' => 'أبحر الشمالية', 'name_en' => 'Obhur Al-Shamaliyah', 'value' => 'Obhur Al-Shamaliyah', 'parent_value' => 'Jeddah', 'order' => 24],
                    ['name_ar' => 'أبحر الجنوبية', 'name_en' => 'Obhur Al-Janubiyah', 'value' => 'Obhur Al-Janubiyah', 'parent_value' => 'Jeddah', 'order' => 25],
                    ['name_ar' => 'حي المحمدية', 'name_en' => 'Al-Mohammadiyah', 'value' => 'Al-Mohammadiyah', 'parent_value' => 'Jeddah', 'order' => 26],
                    ['name_ar' => 'حي المرجان', 'name_en' => 'Al-Murjan', 'value' => 'Al-Murjan', 'parent_value' => 'Jeddah', 'order' => 27],
                    ['name_ar' => 'حي السلامة', 'name_en' => 'Al-Salama', 'value' => 'Al-Salama', 'parent_value' => 'Jeddah', 'order' => 28],
                    ['name_ar' => 'حي البساتين', 'name_en' => 'Al-Basateen', 'value' => 'Al-Basateen', 'parent_value' => 'Jeddah', 'order' => 29],
                    ['name_ar' => 'حي الخالدية', 'name_en' => 'Al-Khalidiyah', 'value' => 'Al-Khalidiyah', 'parent_value' => 'Jeddah', 'order' => 30],
                    ['name_ar' => 'حي الأندلس', 'name_en' => 'Al-Andalus', 'value' => 'Al-Andalus', 'parent_value' => 'Jeddah', 'order' => 31],
                    ['name_ar' => 'حي النعيم', 'name_en' => 'Al-Naeem', 'value' => 'Al-Naeem', 'parent_value' => 'Jeddah', 'order' => 32],
                    ['name_ar' => 'حي الصفا', 'name_en' => 'Al-Safa', 'value' => 'Al-Safa', 'parent_value' => 'Jeddah', 'order' => 33],
                    ['name_ar' => 'الكورنيش الشمالي', 'name_en' => 'North Corniche', 'value' => 'North Corniche', 'parent_value' => 'Jeddah', 'order' => 34],
                    ['name_ar' => 'حي الزهراء', 'name_en' => 'Al-Zahra', 'value' => 'Al-Zahra', 'parent_value' => 'Jeddah', 'order' => 35],
                    ['name_ar' => 'حي الحمدانية', 'name_en' => 'Al-Hamadaniyah', 'value' => 'Al-Hamadaniyah', 'parent_value' => 'Jeddah', 'order' => 36],
                    ['name_ar' => 'حي السامر', 'name_en' => 'Al-Samer', 'value' => 'Al-Samer', 'parent_value' => 'Jeddah', 'order' => 37],
                    ['name_ar' => 'حي الفردوس', 'name_en' => 'Al-Firdous', 'value' => 'Al-Firdous', 'parent_value' => 'Jeddah', 'order' => 38],
                    ['name_ar' => 'حي طيبة', 'name_en' => 'Taybah', 'value' => 'Taybah', 'parent_value' => 'Jeddah', 'order' => 39],
                    ['name_ar' => 'حي الرحيلي', 'name_en' => 'Al-Rehaily', 'value' => 'Al-Rehaily', 'parent_value' => 'Jeddah', 'order' => 40],

                    // === MAKKAH (مكة المكرمة) ===
                    ['name_ar' => 'حي العوالي', 'name_en' => 'Al-Awali', 'value' => 'Al-Awali', 'parent_value' => 'Makkah', 'order' => 41],
                    ['name_ar' => 'حي بطحاء قريش', 'name_en' => 'Batha Quraish', 'value' => 'Batha-Quraish', 'parent_value' => 'Makkah', 'order' => 42],
                    ['name_ar' => 'حي الشوقية', 'name_en' => 'Al-Shawqiyyah', 'value' => 'Al-Shawqiyyah', 'parent_value' => 'Makkah', 'order' => 43],
                    ['name_ar' => 'حي العزيزية (مكة)', 'name_en' => 'Al-Aziziyah (Makkah)', 'value' => 'Al-Aziziyah-Makkah', 'parent_value' => 'Makkah', 'order' => 44],
                    ['name_ar' => 'حي النوارية', 'name_en' => 'Al-Nawariyyah', 'value' => 'Al-Nawariyyah', 'parent_value' => 'Makkah', 'order' => 45],
                    ['name_ar' => 'حي الرصيفة', 'name_en' => 'Al-Rusaifah', 'value' => 'Al-Rusaifah', 'parent_value' => 'Makkah', 'order' => 46],
                    ['name_ar' => 'حي الزايدي', 'name_en' => 'Al-Zaydi', 'value' => 'Al-Zaydi', 'parent_value' => 'Makkah', 'order' => 47],
                    ['name_ar' => 'حي كدي', 'name_en' => 'Kudai', 'value' => 'Kudai', 'parent_value' => 'Makkah', 'order' => 48],
                    ['name_ar' => 'حي العمرة', 'name_en' => 'Al-Umrah', 'value' => 'Al-Umrah', 'parent_value' => 'Makkah', 'order' => 49],

                    // === MADINAH (المدينة المنورة) ===
                    ['name_ar' => 'حي العريض', 'name_en' => 'Al-Areed', 'value' => 'Al-Areed', 'parent_value' => 'Madinah', 'order' => 50],
                    ['name_ar' => 'حي الهدا (المدينة)', 'name_en' => 'Al-Hada (Madinah)', 'value' => 'Al-Hada-Madinah', 'parent_value' => 'Madinah', 'order' => 51],
                    ['name_ar' => 'حي باقدو', 'name_en' => 'Baqdo', 'value' => 'Baqdo', 'parent_value' => 'Madinah', 'order' => 52],
                    ['name_ar' => 'حي الخالدية (المدينة)', 'name_en' => 'Al-Khalidiyah (Madinah)', 'value' => 'Al-Khalidiyah-Madinah', 'parent_value' => 'Madinah', 'order' => 53],
                    ['name_ar' => 'حي الرانوناء', 'name_en' => 'Al-Ranoona', 'value' => 'Al-Ranoona', 'parent_value' => 'Madinah', 'order' => 54],
                    ['name_ar' => 'حي الدفاع', 'name_en' => 'Al-Difa', 'value' => 'Al-Difa', 'parent_value' => 'Madinah', 'order' => 55],
                    ['name_ar' => 'حي قباء', 'name_en' => 'Quba', 'value' => 'Quba', 'parent_value' => 'Madinah', 'order' => 56],
                    ['name_ar' => 'حي الملك فهد', 'name_en' => 'King Fahd (Madinah)', 'value' => 'King-Fahd-Madinah', 'parent_value' => 'Madinah', 'order' => 57],

                    // === DAMMAM (الدمام) ===
                    ['name_ar' => 'حي الشاطئ الشرقي', 'name_en' => 'Al-Shati Al-Sharqi', 'value' => 'Al-Shati-Al-Sharqi', 'parent_value' => 'Dammam', 'order' => 58],
                    ['name_ar' => 'حي الشاطئ الغربي', 'name_en' => 'Al-Shati Al-Gharbi', 'value' => 'Al-Shati-Al-Gharbi', 'parent_value' => 'Dammam', 'order' => 59],
                    ['name_ar' => 'حي الفيصلية (الدمام)', 'name_en' => 'Al-Faisaliyah (Dammam)', 'value' => 'Al-Faisaliyah-Dammam', 'parent_value' => 'Dammam', 'order' => 60],
                    ['name_ar' => 'حي المزروعية', 'name_en' => 'Al-Mazrouiyah', 'value' => 'Al-Mazrouiyah', 'parent_value' => 'Dammam', 'order' => 61],
                    ['name_ar' => 'حي الفاخرية (الدمام)', 'name_en' => 'Al-Fakhriyah (Dammam)', 'value' => 'Al-Fakhriyah-Dammam', 'parent_value' => 'Dammam', 'order' => 62],
                    ['name_ar' => 'حي الشعلة', 'name_en' => 'Al-Shoulla', 'value' => 'Al-Shoulla', 'parent_value' => 'Dammam', 'order' => 63],
                    ['name_ar' => 'حي الضباب (الدمام)', 'name_en' => 'Al-Dhabab (Dammam)', 'value' => 'Al-Dhabab-Dammam', 'parent_value' => 'Dammam', 'order' => 64],
                    ['name_ar' => 'حي النورس', 'name_en' => 'Al-Nawras', 'value' => 'Al-Nawras', 'parent_value' => 'Dammam', 'order' => 65],
                    ['name_ar' => 'حي أحد', 'name_en' => 'Uhud', 'value' => 'Uhud', 'parent_value' => 'Dammam', 'order' => 66],
                    ['name_ar' => 'حي بدر', 'name_en' => 'Badr', 'value' => 'Badr', 'parent_value' => 'Dammam', 'order' => 67],

                    // === KHOBAR (الخبر) ===
                    ['name_ar' => 'حي الحزام الذهبي', 'name_en' => 'Al-Hizam Al-Dhahabi', 'value' => 'Al-Hizam-Al-Dhahabi', 'parent_value' => 'Khobar', 'order' => 68],
                    ['name_ar' => 'حي الحزام الأخضر', 'name_en' => 'Al-Hizam Al-Akhdar', 'value' => 'Al-Hizam-Al-Akhdar', 'parent_value' => 'Khobar', 'order' => 69],
                    ['name_ar' => 'حي الراكة الجنوبية', 'name_en' => 'Al-Rakah Al-Janubiyah', 'value' => 'Al-Rakah-Al-Janubiyah', 'parent_value' => 'Khobar', 'order' => 70],
                    ['name_ar' => 'حي العليا (الخبر)', 'name_en' => 'Al-Olaya (Khobar)', 'value' => 'Al-Olaya-Khobar', 'parent_value' => 'Khobar', 'order' => 71],
                    ['name_ar' => 'حي الكورنيش (الخبر)', 'name_en' => 'Corniche Khobar', 'value' => 'Corniche-Khobar', 'parent_value' => 'Khobar', 'order' => 72],
                    ['name_ar' => 'حي التحلية (الخبر)', 'name_en' => 'Al-Tahliah (Khobar)', 'value' => 'Al-Tahliah-Khobar', 'parent_value' => 'Khobar', 'order' => 73],
                    ['name_ar' => 'حي الصواري / العزيزية', 'name_en' => 'Al-Sawari / Aziziyah', 'value' => 'Al-Sawari-Khobar', 'parent_value' => 'Khobar', 'order' => 74],
                    ['name_ar' => 'حي الجسر', 'name_en' => 'Al-Jisr', 'value' => 'Al-Jisr', 'parent_value' => 'Khobar', 'order' => 75],
                    ['name_ar' => 'حي القيروان (الخبر)', 'name_en' => 'Al-Qairawan (Khobar)', 'value' => 'Al-Qairawan-Khobar', 'parent_value' => 'Khobar', 'order' => 76],

                    // === DHAHRAN (الظهران) ===
                    ['name_ar' => 'حي الدوحة الجنوبية', 'name_en' => 'Al-Dawhah', 'value' => 'Al-Dawhah', 'parent_value' => 'Dhahran', 'order' => 77],
                    ['name_ar' => 'حي الدانة', 'name_en' => 'Al-Danah', 'value' => 'Al-Danah', 'parent_value' => 'Dhahran', 'order' => 78],
                    ['name_ar' => 'حي القصور', 'name_en' => 'Al-Qusoor', 'value' => 'Al-Qusoor', 'parent_value' => 'Dhahran', 'order' => 79],
                    ['name_ar' => 'حي تلال الدوحة', 'name_en' => 'Telal Al-Dawhah', 'value' => 'Telal-Al-Dawhah', 'parent_value' => 'Dhahran', 'order' => 80],

                    // === AL-AHSA (الأحساء) ===
                    ['name_ar' => 'حي المبرز', 'name_en' => 'Al-Mubarraz', 'value' => 'Al-Mubarraz', 'parent_value' => 'Al-Ahsa', 'order' => 81],
                    ['name_ar' => 'حي الهفوف', 'name_en' => 'Al-Hofuf', 'value' => 'Al-Hofuf', 'parent_value' => 'Al-Ahsa', 'order' => 82],
                    ['name_ar' => 'حي السلمانية (الأحساء)', 'name_en' => 'Al-Salmaniyah', 'value' => 'Al-Salmaniyah', 'parent_value' => 'Al-Ahsa', 'order' => 83],
                    ['name_ar' => 'حي البندرية', 'name_en' => 'Al-Bandariyah', 'value' => 'Al-Bandariyah', 'parent_value' => 'Al-Ahsa', 'order' => 84],

                    // === JUBAIL (الجبيل) ===
                    ['name_ar' => 'حي جلمودة', 'name_en' => 'Jalmudah', 'value' => 'Jalmudah', 'parent_value' => 'Jubail', 'order' => 85],
                    ['name_ar' => 'حي الفردوس (الجبيل)', 'name_en' => 'Al-Firdous (Jubail)', 'value' => 'Al-Firdous-Jubail', 'parent_value' => 'Jubail', 'order' => 86],
                    ['name_ar' => 'حي الدفي', 'name_en' => 'Al-Deffi', 'value' => 'Al-Deffi', 'parent_value' => 'Jubail', 'order' => 87],
                    ['name_ar' => 'حي الفناتير', 'name_en' => 'Fanateer', 'value' => 'Fanateer', 'parent_value' => 'Jubail', 'order' => 88],
                    ['name_ar' => 'الجبيل البلد', 'name_en' => 'Jubail Downtown', 'value' => 'Jubail-Downtown', 'parent_value' => 'Jubail', 'order' => 89],

                    // === TAIF (الطائف) ===
                    ['name_ar' => 'حي شهار', 'name_en' => 'Shehar', 'value' => 'Shehar', 'parent_value' => 'Taif', 'order' => 90],
                    ['name_ar' => 'حي الحوية', 'name_en' => 'Al-Hawiyah', 'value' => 'Al-Hawiyah', 'parent_value' => 'Taif', 'order' => 91],
                    ['name_ar' => 'حي الوسام', 'name_en' => 'Al-Wissam', 'value' => 'Al-Wissam', 'parent_value' => 'Taif', 'order' => 92],
                    ['name_ar' => 'حي جبرة', 'name_en' => 'Jibrah', 'value' => 'Jibrah', 'parent_value' => 'Taif', 'order' => 93],
                    ['name_ar' => 'حي الهدا (الطائف)', 'name_en' => 'Al-Hada (Taif)', 'value' => 'Al-Hada-Taif', 'parent_value' => 'Taif', 'order' => 94],

                    // === YANBU (ينبع) ===
                    ['name_ar' => 'ينبع الصناعية (الهيئة الملكية)', 'name_en' => 'Yanbu Industrial', 'value' => 'Yanbu-Industrial', 'parent_value' => 'Yanbu', 'order' => 95],
                    ['name_ar' => 'ينبع البحر', 'name_en' => 'Yanbu Al-Bahr', 'value' => 'Yanbu-Al-Bahr', 'parent_value' => 'Yanbu', 'order' => 96],
                    ['name_ar' => 'حي الشاطئ (ينبع)', 'name_en' => 'Al-Shati (Yanbu)', 'value' => 'Al-Shati-Yanbu', 'parent_value' => 'Yanbu', 'order' => 97],

                    // === DIRIYAH (الدرعية) ===
                    ['name_ar' => 'حي طريف', 'name_en' => 'At-Turaif', 'value' => 'At-Turaif', 'parent_value' => 'Diriyah', 'order' => 98],
                    ['name_ar' => 'حي البجيري', 'name_en' => 'Al-Bujairi', 'value' => 'Al-Bujairi', 'parent_value' => 'Diriyah', 'order' => 99],
                    ['name_ar' => 'حي الخالدية (الدرعية)', 'name_en' => 'Al-Khalidiyah (Diriyah)', 'value' => 'Al-Khalidiyah-Diriyah', 'parent_value' => 'Diriyah', 'order' => 100],

                    // === AL-KHARJ (الخرج) ===
                    ['name_ar' => 'حي الخزامى (الخرج)', 'name_en' => 'Al-Khozama (Al-Kharj)', 'value' => 'Al-Khozama-Al-Kharj', 'parent_value' => 'Al-Kharj', 'order' => 101],
                    ['name_ar' => 'حي الورود (الخرج)', 'name_en' => 'Al-Wurood (Al-Kharj)', 'value' => 'Al-Wurood-Al-Kharj', 'parent_value' => 'Al-Kharj', 'order' => 102],
                    ['name_ar' => 'حي الأندلس (الخرج)', 'name_en' => 'Al-Andalus (Al-Kharj)', 'value' => 'Al-Andalus-Al-Kharj', 'parent_value' => 'Al-Kharj', 'order' => 103],

                    // === QASSIM (القصيم: بريدة وعنيزة) ===
                    ['name_ar' => 'حي النهضة (بريدة)', 'name_en' => 'Al-Nahda (Buraidah)', 'value' => 'Al-Nahda-Buraidah', 'parent_value' => 'Buraidah', 'order' => 104],
                    ['name_ar' => 'حي الإسكان (بريدة)', 'name_en' => 'Al-Iskan (Buraidah)', 'value' => 'Al-Iskan-Buraidah', 'parent_value' => 'Buraidah', 'order' => 105],
                    ['name_ar' => 'حي الفايزية', 'name_en' => 'Al-Fayziyah', 'value' => 'Al-Fayziyah', 'parent_value' => 'Buraidah', 'order' => 106],
                    ['name_ar' => 'حي الفاخرية (عنيزة)', 'name_en' => 'Al-Fakhriyah (Unaizah)', 'value' => 'Al-Fakhriyah-Unaizah', 'parent_value' => 'Unaizah', 'order' => 107],
                    ['name_ar' => 'حي الأشرفية', 'name_en' => 'Al-Ashrafiyah', 'value' => 'Al-Ashrafiyah', 'parent_value' => 'Unaizah', 'order' => 108],

                    // === ASIR (عسير: أبها وخميس مشيط) ===
                    ['name_ar' => 'حي المنسك', 'name_en' => 'Al-Mansak', 'value' => 'Al-Mansak', 'parent_value' => 'Abha', 'order' => 109],
                    ['name_ar' => 'حي الضباب (أبها)', 'name_en' => 'Al-Dhabab (Abha)', 'value' => 'Al-Dhabab-Abha', 'parent_value' => 'Abha', 'order' => 110],
                    ['name_ar' => 'حي البديع', 'name_en' => 'Al-Badee', 'value' => 'Al-Badee', 'parent_value' => 'Abha', 'order' => 111],
                    ['name_ar' => 'حي حسام', 'name_en' => 'Hossam', 'value' => 'Hossam', 'parent_value' => 'Khamis-Mushait', 'order' => 112],
                    ['name_ar' => 'حي الرصراص', 'name_en' => 'Al-Rasras', 'value' => 'Al-Rasras', 'parent_value' => 'Khamis-Mushait', 'order' => 113],

                    // === TABUK & NEOM (تبوك ونيوم) ===
                    ['name_ar' => 'حي المروج (تبوك)', 'name_en' => 'Al-Murooj (Tabuk)', 'value' => 'Al-Murooj-Tabuk', 'parent_value' => 'Tabuk', 'order' => 114],
                    ['name_ar' => 'حي الورود (تبوك)', 'name_en' => 'Al-Wurood (Tabuk)', 'value' => 'Al-Wurood-Tabuk', 'parent_value' => 'Tabuk', 'order' => 115],
                    ['name_ar' => 'حي العليا (تبوك)', 'name_en' => 'Al-Olaya (Tabuk)', 'value' => 'Al-Olaya-Tabuk', 'parent_value' => 'Tabuk', 'order' => 116],
                    ['name_ar' => 'ذا لاين (نيوم)', 'name_en' => 'The Line (NEOM)', 'value' => 'The-Line-NEOM', 'parent_value' => 'NEOM', 'order' => 117],
                    ['name_ar' => 'جزيرة سندالة (نيوم)', 'name_en' => 'Sindalah Island', 'value' => 'Sindalah', 'parent_value' => 'NEOM', 'order' => 118],
                    ['name_ar' => 'أوكساجون (نيوم)', 'name_en' => 'Oxagon', 'value' => 'Oxagon', 'parent_value' => 'NEOM', 'order' => 119],
                    ['name_ar' => 'تروجينا (نيوم)', 'name_en' => 'Trojena', 'value' => 'Trojena', 'parent_value' => 'NEOM', 'order' => 120],

                    // === HAIL (حائل) ===
                    ['name_ar' => 'حي النقرة', 'name_en' => 'Al-Nuqrah', 'value' => 'Al-Nuqrah', 'parent_value' => 'Hail', 'order' => 121],
                    ['name_ar' => 'حي الوسيطاء', 'name_en' => 'Al-Waseeta', 'value' => 'Al-Waseeta', 'parent_value' => 'Hail', 'order' => 122],
                    ['name_ar' => 'حي صديان', 'name_en' => 'Sadyan', 'value' => 'Sadyan', 'parent_value' => 'Hail', 'order' => 123],

                    // === JAZAN (جازان) ===
                    ['name_ar' => 'حي الشاطئ (جازان)', 'name_en' => 'Al-Shati (Jazan)', 'value' => 'Al-Shati-Jazan', 'parent_value' => 'Jazan', 'order' => 124],
                    ['name_ar' => 'حي السويس', 'name_en' => 'Al-Suwais', 'value' => 'Al-Suwais', 'parent_value' => 'Jazan', 'order' => 125],

                    // === NAJRAN (نجران) ===
                    ['name_ar' => 'حي الفهد (نجران)', 'name_en' => 'Al-Fahd (Najran)', 'value' => 'Al-Fahd-Najran', 'parent_value' => 'Najran', 'order' => 126],
                    ['name_ar' => 'حي الخالدية (نجران)', 'name_en' => 'Al-Khalidiyah (Najran)', 'value' => 'Al-Khalidiyah-Najran', 'parent_value' => 'Najran', 'order' => 127],

                    // === SAKAKA (سكاكا - الجوف) ===
                    ['name_ar' => 'حي المحمدية (سكاكا)', 'name_en' => 'Al-Mohammadiyah (Sakaka)', 'value' => 'Al-Mohammadiyah-Sakaka', 'parent_value' => 'Sakaka', 'order' => 128],
                    ['name_ar' => 'حي اللقائط', 'name_en' => 'Al-Liqait', 'value' => 'Al-Liqait', 'parent_value' => 'Sakaka', 'order' => 129],

                    // === ARAR (عرعر - الحدود الشمالية) ===
                    ['name_ar' => 'حي المساعدية', 'name_en' => 'Al-Musaadiyah', 'value' => 'Al-Musaadiyah', 'parent_value' => 'Arar', 'order' => 130],
                    ['name_ar' => 'حي الخالدية (عرعر)', 'name_en' => 'Al-Khalidiyah (Arar)', 'value' => 'Al-Khalidiyah-Arar', 'parent_value' => 'Arar', 'order' => 131],

                    // === AL-BAHA (الباحة) ===
                    ['name_ar' => 'حي الظفير', 'name_en' => 'Al-Dhafeer', 'value' => 'Al-Dhafeer', 'parent_value' => 'Al-Baha', 'order' => 132],
                    ['name_ar' => 'حي رغدان', 'name_en' => 'Raghadan', 'value' => 'Raghadan', 'parent_value' => 'Al-Baha', 'order' => 133],
                ],
            ],

            // 11. Utilities & Services
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
                        'parent_value' => $item['parent_value'] ?? null,
                        'order' => $item['order'] ?? 0,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
