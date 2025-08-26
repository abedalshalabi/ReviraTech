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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المنتج
            $table->string('slug')->unique(); // slug للرابط
            $table->text('short_description')->nullable(); // وصف مختصر
            $table->longText('description')->nullable(); // وصف مفصل
            $table->decimal('price', 10, 2)->nullable(); // السعر
            $table->decimal('sale_price', 10, 2)->nullable(); // سعر البيع
            $table->string('sku')->unique()->nullable(); // رمز المنتج
            $table->string('model')->nullable(); // موديل المنتج
            $table->string('brand')->nullable(); // العلامة التجارية
            $table->string('country_of_origin')->nullable(); // بلد المنشأ
            $table->unsignedBigInteger('category_id'); // التصنيف
            $table->json('technical_specifications')->nullable(); // المواصفات التقنية
            $table->json('features')->nullable(); // المميزات
            $table->json('applications')->nullable(); // التطبيقات
            $table->string('warranty')->nullable(); // الضمان
            $table->string('image')->nullable(); // صورة المنتج
            $table->string('video_url')->nullable(); // رابط الفيديو
            $table->string('catalog_url')->nullable(); // رابط الكتالوج
            $table->boolean('is_active')->default(true); // تفعيل المنتج
            $table->boolean('is_featured')->default(false); // منتج مميز
            $table->boolean('is_new')->default(false); // منتج جديد
            $table->boolean('is_bestseller')->default(false); // الأكثر مبيعاً
            $table->integer('sort_order')->default(0); // ترتيب المنتج
            $table->integer('views_count')->default(0); // عدد المشاهدات
            $table->string('meta_title')->nullable(); // عنوان SEO
            $table->text('meta_description')->nullable(); // وصف SEO
            $table->text('meta_keywords')->nullable(); // كلمات مفتاحية SEO
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
