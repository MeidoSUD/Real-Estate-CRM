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
        Schema::create('property_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('slug')->unique();
            $table->string('property_type'); // Villa, Apartment, Penthouse, Land, Commercial
            $table->enum('purpose', ['sale', 'rent'])->default('sale');
            $table->decimal('price', 14, 2);
            $table->string('currency')->default('SAR');
            $table->string('city')->default('Jeddah');
            $table->string('district'); // e.g. Al-Shati, Al-Rawdah, Obhur, Al-Hamra
            $table->text('address')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area_sqm', 10, 2);
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // Pool, Sea View, Smart Home, Garden, Maid Room, etc.
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->enum('status', ['available', 'reserved', 'sold', 'rented'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->enum('type', ['buyer', 'owner', 'inquiry'])->default('buyer');
            $table->foreignId('property_offer_id')->nullable()->constrained('property_offers')->nullOnDelete();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'in_progress', 'closed', 'cancelled'])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('property_offers');
    }
};
