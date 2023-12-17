<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('appointment_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->unique(['appointment_id', 'locale']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('appointment_translations');
    }
};
