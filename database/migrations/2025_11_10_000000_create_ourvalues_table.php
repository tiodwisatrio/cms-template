<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('our_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1); // 0: inactive, 1: active
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
    Schema::dropIfExists('our_values');
    }
};
