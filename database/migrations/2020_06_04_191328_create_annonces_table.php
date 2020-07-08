<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('annonces', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('title', 100);
            $table->string('type', 100);
            $table->string('description', 100);
            $table->double('price', 15, 8)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('city', 100);
            $table->string('position_map', 100)->nullable();
            $table->string('status', 100);
            $table->string('rent', 100);
            $table->boolean('premium')->default('0');


            $table->unsignedBigInteger('annoncer_id')->nullable();
            $table->foreign('annoncer_id')->references('id')->on('annoncers');

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
        Schema::dropIfExists('annonces');
    }
}
