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
        Schema::create('employee_salary', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->integer('salary')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->timestamps();
        });
        $this->salaries();
    }
    private function salaries(): void
    {

        DB::table('employee_salary')->insert([
            'email' => 'sample@gmail.com',
            'salary' => '14061',
            'month' => 'January',
            'year' => '2024',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        DB::table('employee_salary')->insert([
            'email' => 'sample@gmail.com',
            'salary' => '13061',
            'month' => 'February',
            'year' => '2024',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
          
        DB::table('employee_salary')->insert([
            'email' => 'sample@gmail.com',
            'salary' => '13061',
            'month' => 'February',
            'year' => '2023',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
          
        DB::table('employee_salary')->insert([
            'email' => 'sample@gmail.com',
            'salary' => '13061',
            'month' => 'March',
            'year' => '2024',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salary');
    }
};
