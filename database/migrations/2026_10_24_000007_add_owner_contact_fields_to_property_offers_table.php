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
            $table->string('owner_name')->nullable()->after('contract_duration_months');
            $table->string('owner_phone')->nullable()->after('owner_name');
            $table->string('owner_national_id')->nullable()->after('owner_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_offers', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'owner_phone', 'owner_national_id']);
        });
    }
};
