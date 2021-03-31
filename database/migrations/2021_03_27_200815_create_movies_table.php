<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('year', 20);
            $table->string('released', 20);
            $table->string('runtime', 50);
            $table->string('genre', 50);
            $table->string('director', 60);
            $table->longText('actors');
            $table->longText('plot');
            $table->string('language', 100);
            $table->string('country', 100);
            $table->string('type', 30);
            $table->string('imdbid', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
