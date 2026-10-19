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
        Schema::create('sidebar_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('icon')->default('circle');
            $table->string('route')->nullable();
            $table->string('permission_slug')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('sub_sidebar_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidebar_menu_id')->constrained('sidebar_menus')->cascadeOnDelete();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('route');
            $table->string('permission_slug')->nullable();
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
        Schema::dropIfExists('sub_sidebar_menus');
        Schema::dropIfExists('sidebar_menus');
    }
};
