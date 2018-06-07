<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloatProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('float_processes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('float_id',false, true);
            $table->decimal('invoice_from_hospital', 20,2);
            $table->decimal('amount_as_per_package', 20,2);
            $table->decimal('implants', 20,2);
            $table->decimal('travelling_allowance', 20,2);
            $table->decimal('total_amount', 20,2);

            $table->decimal('deduction', 20,2);
            $table->decimal('tds_amount', 20,2);
            $table->decimal('amount_on_billing', 20,2);
            $table->integer('processed_by', false, true);

            $table->string('remarks', 500);
            $table->string('current_status', 50);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('float_id')->references('id')->on('floats');
            $table->foreign('processed_by')->references('id')->on('claims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('float_processes');
    }
}
