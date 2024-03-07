<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('users_id');
            $table->unsignedInteger('patients')->nullable();
            $table->unsignedBigInteger('experience')->nullable();
            $table->longText('bio_data')->nullable();
            $table->string('status');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
