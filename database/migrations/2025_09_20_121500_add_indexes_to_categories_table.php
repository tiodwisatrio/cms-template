<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Add compound indexes for better performance
            $table->index(['type', 'is_active', 'sort_order'], 'categories_type_active_order');
            $table->index(['type', 'slug'], 'categories_type_slug');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_type_active_order');
            $table->dropIndex('categories_type_slug');
        });
    }
};