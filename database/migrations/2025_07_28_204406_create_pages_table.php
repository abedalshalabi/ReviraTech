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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الصفحة
            $table->string('slug')->unique(); // slug للرابط
            $table->text('summary')->nullable(); // ملخص الصفحة
            $table->longText('content'); // محتوى الصفحة
            $table->string('image')->nullable(); // صورة الصفحة
            $table->string('template')->default('default'); // قالب الصفحة
            $table->json('meta_data')->nullable(); // بيانات إضافية
            $table->boolean('is_active')->default(true); // تفعيل الصفحة
            $table->boolean('is_homepage')->default(false); // الصفحة الرئيسية
            $table->integer('sort_order')->default(0); // ترتيب الصفحة
            $table->string('meta_title')->nullable(); // عنوان SEO
            $table->text('meta_description')->nullable(); // وصف SEO
            $table->text('meta_keywords')->nullable(); // كلمات مفتاحية SEO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
