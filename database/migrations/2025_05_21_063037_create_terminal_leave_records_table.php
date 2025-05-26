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
        Schema::create('terminal_leave_records', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('month');
            $table->decimal('monthly_salary', 12, 2);
            $table->decimal('leave_credits', 8, 3)->nullable(); // Total leave credits earned (VL + SL)
            $table->decimal('payable_to_date', 12, 2)->nullable();
            $table->decimal('balance_previous_month', 12, 2)->nullable();
            $table->decimal('payable_current_month', 12, 2)->nullable();
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
        Schema::dropIfExists('terminal_leave_records');
    }
};
