<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blood_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_bank_id')->constrained()->onDelete('cascade');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->integer('quantity')->default(0);
            $table->timestamps();

            // Add unique constraint to prevent duplicate entries for same blood type in a bank
            $table->unique(['blood_bank_id', 'blood_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_inventories');
    }
}; 