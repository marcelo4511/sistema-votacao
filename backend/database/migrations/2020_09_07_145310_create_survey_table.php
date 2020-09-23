<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->date('dateinicial')->nullable();
            $table->date('datefinal')->nullable();

            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();

            $table->integer('totaloption1')->default(0);
            $table->integer('totaloption2')->default(0);
            $table->integer('totaloption3')->default(0);

            $table->enum('status',['não iniciada','em andamento','finalizada'])->default('não iniciada');

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
        Schema::dropIfExists('survey');
    }
}
