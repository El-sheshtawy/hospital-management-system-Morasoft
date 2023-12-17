<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->nullable()->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('super_admin')->default(0); // 0 => not super admin , 1 => super admin
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

     public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
