<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienceBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audience_borrows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audience_id')->nullable();
            $table->bigInteger('pair_number_id')->nullable();
            $table->date('date');
            $table->string('reason')->max(255);
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
        Schema::dropIfExists('audience_borrows');
    }
}
