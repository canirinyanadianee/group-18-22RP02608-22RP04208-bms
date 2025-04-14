<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donation_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_drive_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('time_slot');
            $table->enum('status', ['registered', 'confirmed', 'completed', 'cancelled'])->default('registered');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate registrations
            $table->unique(['donation_drive_id', 'donor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('donation_registrations');
    }
};
