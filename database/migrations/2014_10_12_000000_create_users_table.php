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
        Schema::create('users', function (Blueprint $table) {
            $table->enum('type', ['consultant', 'user'])->default('user');
            $table->increments('id');            
            $table->string('username');
            $table->integer('age');
            $table->string('email')->unique();
            $table->string('password');
            $table->string("img_profile")->default("");
            $table->integer("poin")->default(0);
            $table->timestamp('email_verified_at')->nullable();            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
