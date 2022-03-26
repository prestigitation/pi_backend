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
            $table->string('slug')->max(255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('education_level_id')->constrained()->nullable();
            $table->enum('position', TeacherPositions::getValues(TeacherPositions::cases()))->nullable();
            $table->string('avatar_path')->nullable()->max(255)->nullable();
            $table->string('education')->max(255)->nullable();
            $table->string('study_link')->max(255)->nullable();
            $table->string('proof_document_link')->nullable()->max(255);
            $table->text('dissertation_proof')->nullable();
            $table->text('professional_interests')->nullable();
            $table->smallInteger('publications_count')->nullable();
            $table->smallInteger('projects_count')->nullable();
            $table->smallInteger('conferences_count')->nullable();
            $table->smallInteger('diploma_projects_count')->nullable();
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
