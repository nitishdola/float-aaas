<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFloatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floats', function (Blueprint $table) {
            $table->integer('assigned_to', false, true)->after('utr_date')->nullable();
            $table->string('current_status', 127)->after('assigned_to')->default('float_uploaded');
            $table->boolean('processed')->default(0);
            $table->boolean('status')->after('current_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floats', function (Blueprint $table) {
            //
        });
    }
}
