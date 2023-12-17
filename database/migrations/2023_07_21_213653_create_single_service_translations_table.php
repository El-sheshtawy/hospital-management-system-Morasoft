<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('single_service_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->foreignId('single_service_id')->constrained('single_services')->cascadeOnDelete();
            $table->unique(['single_service_id', 'locale']);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('service_translations');
    }
};
