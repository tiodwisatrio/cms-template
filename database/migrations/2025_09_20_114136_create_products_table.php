<?php
// database/migrations/xxxx_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->string('status')->default('active'); // active, inactive, out_of_stock
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable(); // Multiple images
            $table->json('specifications')->nullable(); // Product specs
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable(); // LxWxH
            $table->boolean('is_featured')->default(false);
            $table->boolean('track_stock')->default(true);
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('order_count')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['status', 'is_featured']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};