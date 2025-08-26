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
        Schema::table('products', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('category_id');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('is_new');
            $table->index('is_bestseller');
            $table->index('sort_order');
            $table->index(['is_active', 'is_featured']);
            $table->index(['is_active', 'is_new']);
            $table->index(['is_active', 'is_bestseller']);
            $table->index(['category_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_new']);
            $table->dropIndex(['is_bestseller']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['is_active', 'is_new']);
            $table->dropIndex(['is_active', 'is_bestseller']);
            $table->dropIndex(['category_id', 'is_active']);
        });
    }
};
