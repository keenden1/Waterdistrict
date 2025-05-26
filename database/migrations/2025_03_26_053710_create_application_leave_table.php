<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_leave', function (Blueprint $table) {
            $table->id();
            $table->string('officer_department')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('salary_grade')->nullable();
            $table->string('step_grade')->nullable();
            $table->date('date_filing')->nullable();
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
            $table->string('a_availed')->nullable();
            $table->string('a_availed_others')->nullable();

            $table->string('b_details')->nullable();
            $table->string('b_details_specify')->nullable();
            
            $table->string('c_working_days')->nullable();
            $table->string('c_inclusive_dates')->nullable();
            $table->string('d_commutation')->nullable();
      
            $table->string('seven_a_certification')->nullable();
            $table->string('seven_b_recommendation')->nullable();
            $table->string('seven_c_approved')->nullable();
            $table->string('seven_d_disapproved')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('application_leave');
    }
};
