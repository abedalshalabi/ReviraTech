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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الوكيل
            $table->string('company_name'); // اسم الشركة
            $table->string('logo')->nullable(); // شعار الشركة
            $table->text('description')->nullable(); // وصف الوكيل
            $table->string('email')->nullable(); // البريد الإلكتروني
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('website')->nullable(); // الموقع الإلكتروني
            $table->string('address')->nullable(); // العنوان
            $table->string('city')->nullable(); // المدينة
            $table->string('country')->nullable(); // الدولة
            $table->decimal('latitude', 10, 8)->nullable(); // خط العرض
            $table->decimal('longitude', 11, 8)->nullable(); // خط الطول
            $table->json('working_hours')->nullable(); // ساعات العمل
            $table->boolean('is_active')->default(true); // تفعيل الوكيل
            $table->integer('sort_order')->default(0); // ترتيب الوكيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
