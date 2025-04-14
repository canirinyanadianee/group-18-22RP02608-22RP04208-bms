<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('blood_bank_id')->constrained('blood_banks');
            $table->string('patient_name');
            $table->string('blood_type');
            $table->integer('quantity_ml');
            $table->date('required_date');
            $table->text('reason');
            $table->enum('urgency', ['low', 'medium', 'high', 'emergency']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_requests');
    }
}; 