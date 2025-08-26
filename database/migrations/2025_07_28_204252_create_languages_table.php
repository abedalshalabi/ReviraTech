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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم اللغة
            $table->string('code', 5)->unique(); // رمز اللغة (ar, en, fr)
            $table->string('locale', 10)->unique(); // locale (ar_SA, en_US)
            $table->string('flag')->nullable(); // علم الدولة
            $table->boolean('is_rtl')->default(false); // دعم RTL
            $table->boolean('is_active')->default(true); // تفعيل اللغة
            $table->boolean('is_default')->default(false); // اللغة الافتراضية
            $table->integer('sort_order')->default(0); // ترتيب اللغة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
