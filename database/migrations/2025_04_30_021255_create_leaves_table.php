<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('name')->nullable();
            $table->string('date')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->decimal('monthly_salary', 20, 2)->nullable();
            // $table->decimal('constant_factor', 8, 7)->nullable();
            $table->decimal('vl', 5, 3)->nullable();
            $table->decimal('fl', 5, 3)->nullable();
            $table->decimal('sl', 5, 3)->nullable(); 
            $table->decimal('spl', 5, 3)->nullable(); 
            $table->decimal('other', 5, 3)->nullable(); 

            $table->decimal('vl_earned', 5, 3)->nullable(); 
            $table->decimal('vl_absences_withpay', 5, 3)->nullable(); 
            $table->decimal('vl_balance', 5, 3)->nullable(); 
            $table->decimal('vl_absences_withoutpay', 5, 3)->nullable(); 

            $table->decimal('sl_earned', 5, 3)->nullable(); 
            $table->decimal('sl_absences_withpay', 5, 3)->nullable(); 
            $table->decimal('sl_balance', 5, 3)->nullable(); 
            $table->decimal('sl_absences_withoutpay', 5, 3)->nullable(); 

            $table->decimal('total_leave_earned', 5, 3)->nullable();
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
        Schema::dropIfExists('leaves');
    }
};
