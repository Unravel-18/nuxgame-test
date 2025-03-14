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
        Schema::create('lucky_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('page_token_id')->constrained('page_tokens');
            $table->boolean('is_winner');
            $table->integer('rand_number');
            $table->float('winner_sum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lucky_attempts');
    }
};
