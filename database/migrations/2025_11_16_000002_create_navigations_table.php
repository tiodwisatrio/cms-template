<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(1); // 0 inactive, 1 active
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigations');
    }
};
