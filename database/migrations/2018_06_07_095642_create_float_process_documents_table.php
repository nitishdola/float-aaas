<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloatProcessDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('float_process_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('float_process_id',false, true);
            $table->integer('float_requirement_id',false, true);
            $table->integer('float_requirement_value',false, true);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('float_process_id')->references('id')->on('float_processes');
            $table->foreign('float_requirement_id')->references('id')->on('float_requirements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('float_process_documents');
    }
}
