<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('group_pivot_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_service_id')->constrained('group_services')->cascadeOnDelete();
            $table->foreignId('single_service_id')->constrained('single_services')->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_service');
    }
};
