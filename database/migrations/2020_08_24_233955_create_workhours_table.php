<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkhoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workhours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('monday_start1')->nullable();
            $table->time('monday_end1')->nullable();
            $table->time('monday_start2')->nullable();
            $table->time('monday_end2')->nullable();

            $table->time('tuesday_start1')->nullable();
            $table->time('tuesday_end1')->nullable();
            $table->time('tuesday_start2')->nullable();
            $table->time('tuesday_end2')->nullable();

            $table->time('wednesday_start1')->nullable();
            $table->time('wednesday_end1')->nullable();
            $table->time('wednesday_start2')->nullable();
            $table->time('wednesday_end2')->nullable();

            $table->time('thursday_start1')->nullable();
            $table->time('thursday_end1')->nullable();
            $table->time('thursday_start2')->nullable();
            $table->time('thursday_end2')->nullable();

            $table->time('friday_start1')->nullable();
            $table->time('friday_end1')->nullable();
            $table->time('friday_start2')->nullable();
            $table->time('friday_end2')->nullable();

            $table->time('saturday_start1')->nullable();
            $table->time('saturday_end1')->nullable();
            $table->time('saturday_start2')->nullable();
            $table->time('saturday_end2')->nullable();

            $table->time('sunday_start1')->nullable();
            $table->time('sunday_end1')->nullable();
            $table->time('sunday_start2')->nullable();
            $table->time('sunday_end2')->nullable();
            $table->unsignedBigInteger('place_id')->index();
            $table->foreign('place_id')->references('id')->on('places');
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
        Schema::dropIfExists('workhours');
    }
}
