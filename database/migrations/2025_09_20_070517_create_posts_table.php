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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->longText('description')->nullable();
            
            // Category (Foreign Key) - will be added after categories table is created
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            // File uploads
            $table->string('featured_image')->nullable();
            $table->json('document_files')->nullable();
            
            // Price
            $table->decimal('price', 12, 2)->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Calendar/Date fields
            $table->date('publish_date')->nullable();
            $table->datetime('event_date')->nullable();
            $table->datetime('deadline')->nullable();
            
            // Additional fields
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            
            // User relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Add indexes
            $table->index('slug');
            $table->index(['status', 'publish_date']);
            $table->index(['category_id', 'status']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
