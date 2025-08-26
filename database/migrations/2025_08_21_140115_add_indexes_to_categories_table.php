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
        Schema::table('categories', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('parent_id');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index(['parent_id', 'is_active']);
            $table->index(['is_active', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['parent_id', 'is_active']);
            $table->dropIndex(['is_active', 'is_featured']);
        });
    }
};
