<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegularitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regularities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audience_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('type_id')->constrained();
            $table->bigInteger('pair_format_id')->nullable();
            $table->bigInteger('study_process_id')->nullable();
            $table->string('additional_info')->nullable()->max(20);
            $table->string('start_date_info')->nullable()->max(20);
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
        Schema::dropIfExists('regularities');
    }
}
