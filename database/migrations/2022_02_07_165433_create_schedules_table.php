<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('day_id')->constrained();
            $table->foreignId('pair_number_id')->constrained();
            $table->softDeletes();
            $table->unsignedBigInteger('deletion_author_id')->nullable(); //ID удалившего пользователя
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
        Schema::table("schedules", function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('schedules');
    }
}
