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
        Schema::create('employee_account', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('email')->unique();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('position')->nullable();
            $table->string('role')->nullable();
            $table->string('account_status')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('e_signature')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('employee_account');
    }
};
