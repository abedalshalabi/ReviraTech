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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان السلايد
            $table->text('description')->nullable(); // وصف السلايد
            $table->string('image')->nullable(); // صورة السلايد
            $table->string('button_text')->nullable(); // نص الزر
            $table->string('button_url')->nullable(); // رابط الزر
            $table->string('video_url')->nullable(); // رابط الفيديو
            $table->integer('sort_order')->default(0); // ترتيب السلايد
            $table->boolean('is_active')->default(true); // تفعيل السلايد
            $table->timestamp('start_date')->nullable(); // تاريخ البداية
            $table->timestamp('end_date')->nullable(); // تاريخ النهاية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
