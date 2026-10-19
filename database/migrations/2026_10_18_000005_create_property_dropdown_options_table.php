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
        Schema::create('property_dropdown_options', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index(); // property_category, property_type, deed_property_type, property_grade, contract_type, finishing_type, property_usage, district, utility
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('value')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_dropdown_options');
    }
};
