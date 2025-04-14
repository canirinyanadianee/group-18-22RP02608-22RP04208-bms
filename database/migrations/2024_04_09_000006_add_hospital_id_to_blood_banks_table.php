<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blood_banks', function (Blueprint $table) {
            $table->foreignId('hospital_id')->nullable()->constrained('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('blood_banks', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropColumn('hospital_id');
        });
    }
};
