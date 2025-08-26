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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم التصنيف
            $table->string('slug')->unique(); // slug للرابط
            $table->text('description')->nullable(); // وصف التصنيف
            $table->string('image')->nullable(); // صورة التصنيف
            $table->unsignedBigInteger('parent_id')->nullable(); // التصنيف الأب
            $table->integer('sort_order')->default(0); // ترتيب التصنيف
            $table->boolean('is_active')->default(true); // تفعيل التصنيف
            $table->boolean('is_featured')->default(false); // تصنيف مميز
            $table->string('meta_title')->nullable(); // عنوان SEO
            $table->text('meta_description')->nullable(); // وصف SEO
            $table->text('meta_keywords')->nullable(); // كلمات مفتاحية SEO
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
