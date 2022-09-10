<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_question_options', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('quiz_id')->nullable();
            $table->bigInteger('quiz_question_id')->nullable();
            $table->string('title',150)->nullable();
            $table->string('image',150)->nullable();
            $table->tinyInteger('is_correct')->default(0);
            $table->string('slug',50)->nullable();
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
        Schema::dropIfExists('quiz_question_options');
    }
}
