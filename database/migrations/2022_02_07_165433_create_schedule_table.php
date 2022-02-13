<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();

            $table->foreignId('group_id')->constrained();
            $table->foreignId('day_id')->constrained();
            $table->foreignId('pair_number_id')->constrained();

            $table->unsignedBigInteger('even_teacher_id');
            $table->foreign('even_teacher_id')->references('user_id')->on('teachers');
            $table->unsignedBigInteger('even_subject_id');
            $table->foreign('even_subject_id')->references('id')->on('subjects');

            $table->unsignedBigInteger('odd_teacher_id');
            $table->foreign('odd_teacher_id')->references('user_id')->on('teachers');
            $table->unsignedBigInteger('odd_subject_id');
            $table->foreign('odd_subject_id')->references('id')->on('subjects');

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
        Schema::dropIfExists('schedule');
    }
}
