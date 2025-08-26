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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // مفتاح الإعداد
            $table->text('value')->nullable(); // قيمة الإعداد
            $table->string('type')->default('text'); // نوع الإعداد (text, image, json, etc.)
            $table->string('group')->default('general'); // مجموعة الإعداد
            $table->text('description')->nullable(); // وصف الإعداد
            $table->boolean('is_translatable')->default(false); // قابل للترجمة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
