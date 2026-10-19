<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('property_offers', function (Blueprint $table) {
            // 1. Contract Info
            $table->string('contract_type')->nullable()->after('property_type');
            $table->string('deed_number')->nullable()->after('contract_type');
            $table->string('plan_number')->nullable()->after('deed_number');
            $table->string('parcel_number')->nullable()->after('plan_number');
            $table->integer('contract_duration_months')->nullable()->after('parcel_number');
            $table->string('has_agency_poa')->default('no')->after('contract_duration_months');
            $table->string('deed_image')->nullable()->after('has_agency_poa');

            // 2. Advertising Channels
            $table->json('advertising_channels')->nullable()->after('deed_image');

            // 3. Basic Data
            $table->string('property_category')->nullable()->after('advertising_channels');
            $table->string('deed_property_type')->nullable()->after('property_category');
            $table->string('property_grade')->nullable()->after('deed_property_type');
            $table->integer('floors_count')->nullable()->after('property_grade');
            $table->string('has_upper_annex')->default('no')->after('floors_count');
            $table->string('unit_position')->nullable()->after('has_upper_annex');
            $table->string('finishing_type')->nullable()->after('unit_position');

            // 4. Property Information & Amenities
            $table->string('property_usage')->nullable()->after('finishing_type');
            $table->string('property_age')->nullable()->after('property_usage');
            $table->json('rooms_breakdown')->nullable()->after('property_age');
            $table->json('utilities_services')->nullable()->after('rooms_breakdown');
            $table->text('guarantees')->nullable()->after('utilities_services');
            $table->text('property_liabilities')->nullable()->after('guarantees');
            $table->text('property_disputes')->nullable()->after('property_liabilities');

            // 5. Official Documents & REGA
            $table->boolean('has_restrictions')->default(false)->after('property_disputes');
            $table->boolean('has_mortgage')->default(false)->after('has_restrictions');
            $table->string('ad_license_number')->nullable()->after('has_mortgage');

            // 6. Categorized Image Gallery
            $table->json('categorized_images')->nullable()->after('gallery');

            // 7. National Address & Coordinates
            $table->string('region')->default('منطقة مكة المكرمة')->after('city');
            $table->string('street_name')->nullable()->after('district');
            $table->string('postal_code')->nullable()->after('street_name');
            $table->string('building_number')->nullable()->after('postal_code');
            $table->string('additional_number')->nullable()->after('building_number');
            $table->text('map_link')->nullable()->after('additional_number');
            $table->decimal('latitude', 10, 8)->nullable()->after('map_link');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            // 8. Video & Internal Notes
            $table->string('video_url')->nullable()->after('categorized_images');
            $table->text('internal_notes')->nullable()->after('video_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_offers', function (Blueprint $table) {
            $table->dropColumn([
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
                'categorized_images',
                'region',
                'street_name',
                'postal_code',
                'building_number',
                'additional_number',
                'map_link',
                'latitude',
                'longitude',
                'video_url',
                'internal_notes',
            ]);
        });
    }
};
