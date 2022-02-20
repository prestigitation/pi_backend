<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Helpers\Enums\TeacherPositions;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('education_level_id')->constrained();
            $table->enum('position', TeacherPositions::getValues(TeacherPositions::cases()));
            $table->string('avatar_path')->nullable();
            $table->string('education');
            $table->string('proof_document_link')->nullable();
            $table->text('dissertation_proof')->nullable();
            $table->text('professional_interests')->nullable();
            $table->smallInteger('publications_count');
            $table->smallInteger('projects_count');
            $table->smallInteger('conferences_count');
            $table->smallInteger('diploma_projects_count');
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
        Schema::dropIfExists('teachers');
    }
}
