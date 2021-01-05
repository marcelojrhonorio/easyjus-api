<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_objects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained();
            $table->unsignedBigInteger('ordering');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique('subject_id', 'ordering');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_objects');
    }
}
