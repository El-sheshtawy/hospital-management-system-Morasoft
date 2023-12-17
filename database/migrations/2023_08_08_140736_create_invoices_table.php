<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_number');
            $table->tinyInteger('invoice_type');   // ['single_service' => 0, 'group_services' => 1]);
            $table->tinyInteger('payment_method'); // ['cash' => 1, 'deferred' => 0]);
            $table->tinyInteger('invoice_status'); // ['pending' => 0, 'finish' => 1, 'revision' => 2]);
            $table->morphs('createable');
            $table->foreignId('booking_officer_id')->nullable()->constrained('booking_officers')
                ->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('single_service_id')->nullable()->constrained('single_services')->cascadeOnDelete();
            $table->foreignId('group_services_id')->nullable()->constrained('group_services')->cascadeOnDelete();
            $table->float('price', 8, 2)->default(0);
            $table->float('discount_value', 8, 2)->default(0);
            $table->float('tax_rate');
            $table->float('tax_value');
            $table->float('total_with_tax', 8, 2)->default(0);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('single_invoices');
    }
};
