<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('address');
            $table->date('birth_date');
            $table->tinyInteger('gender');  // ['male' => 1, 'female' => 0]
            $table->tinyInteger('blood_type'); // ['+O', '-O', '+A', '-A', '+B', '-B', '+AB', '-AB'] => 1,2,3,..);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

