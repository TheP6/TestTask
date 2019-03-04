<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string('uuid', 255);
            $table->string('authorUuid', 255);
            $table->string('publisherUuid', 255);
            $table->string('genreUuid', 255);
            $table->string('title', 255);
            $table->unsignedInteger('firstPublished');
            $table->unsignedBigInteger('wordCount');
            $table->decimal('averagePrice');

            $table->primary('uuid');
            $table->timestamps();

            $table->foreign('authorUuid')->references('uuid')->on('authors');
            $table->foreign('publisherUuid')->references('uuid')->on('publishers');
            $table->foreign('genreUuid')->references('uuid')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
