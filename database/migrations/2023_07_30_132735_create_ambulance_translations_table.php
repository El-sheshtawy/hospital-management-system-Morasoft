<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulance_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('notes')->nullable();
            $table->foreignId('ambulance_id')->constrained('ambulances')->cascadeOnDelete();
            $table->unique(['ambulance_id','locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ambulance_translations');
    }
};
