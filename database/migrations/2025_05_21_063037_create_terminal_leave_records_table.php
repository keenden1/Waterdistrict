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
            $table->unsignedBigInteger('employee_id');
            $table->integer('month');
            $table->integer('year');
            $table->float('vl')->default(0);
            $table->float('sl')->default(0);
            $table->float('total')->default(0);
            $table->float('constant_factor')->default(0.0481927);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('salary', 15, 2)->default(0);
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
