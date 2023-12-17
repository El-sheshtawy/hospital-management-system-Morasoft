<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_service_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('group_service_id')->constrained('group_services')->cascadeOnDelete();
            $table->unique(['locale', 'name', 'group_service_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('group_translations');
    }
};
