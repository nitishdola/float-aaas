<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floats', function (Blueprint $table) {
            $table->increments('id');

            $table->string('tpa_name', 125);
            $table->string('enr_urn', 125);
            $table->integer('beneficiary_district_id', false, true);

            $table->string('tpa_claim_reference_number', 125);
            $table->string('hof_name', 125)->nullable();
            $table->string('patient_name', 125);

            $table->float('patient_age', 10,2);
            $table->string('patient_gender', 30);
            //$table->string('hospital_name', 255);

            $table->integer('hospital_id', false, true);

            $table->string('hospital_type', 255);  
            $table->date('date_of_admission');    
            $table->date('date_of_discharge');   

            $table->string('package_code', 127);  
            $table->string('package_name', 600);  
            //$table->string('diagnosis', 255);  

            $table->integer('diagnosis_id', false, true);  

            $table->decimal('claim_amount_base', 20,2);  
            $table->decimal('approved_amount_base', 20,2);  
            $table->date('approval_date');        

            $table->decimal('deduction_amount_base', 20,2);  
            $table->string('deduction_remarks', 500)->nullable();
            $table->decimal('tds_amount', 10,2);  

            $table->date('p_intimation_date');
            $table->date('claim_upload_date');
            $table->string('hospital_pan_number', 127)->nullable();;

            $table->string('hospital_email_id', 127)->nullable();
            $table->string('hospital_mobile_number', 127)->nullable();


            $table->string('hospital_payee_name', 127);
            $table->string('payee_bank_name', 127);
            $table->string('payee_branch_address', 127);

            $table->string('payee_account_type', 127);
            $table->string('payee_bank_account_number', 127);
            $table->string('payee_bank_ifsc_code', 127);


            $table->integer('claim_id', false, true);
            //$table->string('float_number', 10);
            
            $table->integer('float_id', false, true);

            $table->decimal('net_payable', 10,2);

            $table->date('float_generated_date');
            $table->string('float_generated_by', 127);
            $table->string('utr_number', 127)->nullable();
            $table->date('utr_date')->nullable();

            $table->timestamps();

            $table->foreign('beneficiary_district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floats');
    }
}
