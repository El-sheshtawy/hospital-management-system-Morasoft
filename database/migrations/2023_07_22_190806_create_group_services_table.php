<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_services', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_before_discount', 8, 2);
            $table->float('discount_value', 8, 2);
            $table->decimal('total_after_discount', 8, 2);
            $table->float('tax_rate');
            $table->decimal('total_with_tax', 8, 2);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
