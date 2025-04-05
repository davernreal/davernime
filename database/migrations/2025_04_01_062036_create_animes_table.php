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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anime_id')->unique();
            $table->string('title');
            $table->string('english_title')->nullable();
            $table->string('other_title')->nullable();
            $table->text('synopsis')->nullable();
            $table->enum('type', [
                'Unknown',
                'TV',
                'OVA',
                'Special',
                'CM',
                'ONA',
                'Music',
                'Movie',
                'TV Special',
                'PV'
            ])->nullable();
            $table->float('episodes')->nullable();
            $table->date('aired_from')->nullable();
            $table->date('aired_to')->nullable();
            $table->enum('premiered_season', ['winter', 'spring', 'summer', 'fall', 'unknown'])->nullable();
            $table->year('premiered_year')->nullable();
            $table->string('source')->nullable();
            $table->time('duration')->nullable();
            $table->enum('status', ['Finished Airing', 'Currently Airing', 'Not yet aired'])->nullable();
            $table->enum('rating', [
                'R - 17+ (violence & profanity)',
                'PG-13 - Teens 13 or older',
                'PG - Children',
                'R+ - Mild Nudity',
                'G - All Ages',
                'Rx - Hentai',
                'UNKNOWN'
            ])->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
