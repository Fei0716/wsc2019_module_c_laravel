<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->tinyInteger('rating');
            $table->integer('event_id');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');

        });
        DB::statement('ALTER TABLE event_ratings ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');

        Schema::create('session_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('comment')->nullable();
            $table->tinyInteger('rating');
            $table->integer('session_id');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions');

        });
        DB::statement('ALTER TABLE session_ratings ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_ratings');
        Schema::dropIfExists('event_ratings');
    }
};
