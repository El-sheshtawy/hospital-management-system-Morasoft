<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->text('doctor_description');
            $table->foreignId('rays_employee_id')->nullable()->constrained('rays_employees')->cascadeOnDelete();
            $table->text('rays_employee_description')->nullable();
            $table->tinyInteger('status')->default(0); //  ['pending' => 0, 'finish' => 1])
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('rays');
    }
};
