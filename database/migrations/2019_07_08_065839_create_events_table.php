<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('event_id');
            $table->string('category')->nullable();
            $table->foreign('category')->references('category')->on('categories')->onDelete('cascade');
            $table->string('event_name');
            $table->text('event_description');
            $table->string('event_location')->nullable(); 
            $table->string('event_date')->nullable();
            $table->string('event_host')->nullable();
            $table->string('event_time')->nullable();
            $table->string('event_artists')->nullable();
            $table->string('event_poster')->nullable();
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
        Schema::dropIfExists('events');
    }
}
