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
        Schema::create('employee_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('email')->nullable();
            $table->integer('lateness_day')->nullable();
            $table->integer('lateness_hour')->nullable();
            $table->integer('lateness_minutes')->nullable();
            $table->integer('lateness_times')->nullable();
            $table->integer('undertime_day')->nullable();
            $table->integer('undertime_hour')->nullable();
            $table->integer('undertime_minutes')->nullable();
            $table->integer('undertime_times')->nullable();
            $table->timestamps();
        });
        $this->attendance();
    }
    private function attendance(): void
    {

        DB::table('employee_attendance')->insert([
            'month' => 'january',
            'year' => '2025',
            'email' => 'sample@gmail.com',
            'lateness_day' => '1',
            'lateness_hour' => '1',
            'lateness_minutes' => '1',
            'lateness_times' => '1',
            'undertime_day' => '1',
            'undertime_hour' => '1',
            'undertime_minutes' => '1',
            'undertime_times' => '1',
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
        Schema::dropIfExists('employee_attendance');
    }
};
