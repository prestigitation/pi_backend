<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Helpers\Enums\TeacherPositions;

class CreateForeignTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->max(255);
            $table->string('surname')->max(255);
            $table->string('patronymic')->max(255);
            $table->string('slug')->max(255)->nullable();
            $table->enum('position', TeacherPositions::getValues(TeacherPositions::cases()))->nullable();
            $table->string('avatar_path')->nullable()->max(255)->nullable();
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
        Schema::dropIfExists('foreign_teachers');
    }
}
