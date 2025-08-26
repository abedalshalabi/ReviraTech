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
            // Add indexes for searchable and sortable columns
            $table->index('name');
            $table->index('sku');
            $table->index('brand');
            $table->index('price');
            $table->index('created_at');
            $table->index(['name', 'is_active']);
            $table->index(['sku', 'is_active']);
            $table->index(['brand', 'is_active']);
            $table->index(['price', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['name']);
            $table->dropIndex(['sku']);
            $table->dropIndex(['brand']);
            $table->dropIndex(['price']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['name', 'is_active']);
            $table->dropIndex(['sku', 'is_active']);
            $table->dropIndex(['brand', 'is_active']);
            $table->dropIndex(['price', 'is_active']);
        });
    }
};