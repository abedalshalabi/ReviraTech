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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الخبر
            $table->string('slug')->unique(); // slug للرابط
            $table->text('summary')->nullable(); // ملخص الخبر
            $table->longText('content'); // محتوى الخبر
            $table->string('image')->nullable(); // صورة الخبر
            $table->string('author')->nullable(); // كاتب الخبر
            $table->string('source')->nullable(); // مصدر الخبر
            $table->string('source_url')->nullable(); // رابط المصدر
            $table->json('tags')->nullable(); // الوسوم
            $table->boolean('is_active')->default(true); // تفعيل الخبر
            $table->boolean('is_featured')->default(false); // خبر مميز
            $table->timestamp('published_at')->nullable(); // تاريخ النشر
            $table->integer('views_count')->default(0); // عدد المشاهدات
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
        Schema::dropIfExists('news');
    }
};
