<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->id();

            // наименование направления - Педагогическое образование
            $table->string('name')->max(100);

            //код направления - 6.44.04.01
            $table->string('code')->max(20);

            //профиль - Информационные технологий в образовании
            $table->foreignId('profile_id')->constrained();

            $table->tinyInteger('years');
            $table->tinyInteger('months');

            $table->foreignId('study_form_id')->constrained();
            $table->foreignId('time_form_id')->constrained();
            $table->foreignId('payment_form_id')->constrained();

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
        Schema::dropIfExists('directions');
    }
}
