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
        Schema::create('question_games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("games_id");
            $table->string("title");
            $table->string("img-question");
            $table->string("answer");
            $table->integer("is_correct");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_games');
    }
};
