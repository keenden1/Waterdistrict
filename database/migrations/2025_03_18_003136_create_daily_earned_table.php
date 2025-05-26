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
        Schema::create('daily_earned', function (Blueprint $table) {
            $table->id();
            $table->string('days')->nullable();
            $table->decimal('vacation_earned',10, 3)->nullable();
            $table->decimal('sick_earned',10, 3)->nullable();
            $table->timestamps();
        });
        $this->earned();
    }
    private function earned(): void
    {
        DB::table('daily_earned')->insert([
            'days' => '1',
            'vacation_earned' => '0.042',
            'sick_earned' => '0.042',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '2',
            'vacation_earned' => '0.083',
            'sick_earned' => '0.083',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '3',
            'vacation_earned' => '0.125',
            'sick_earned' => '0.125',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '4',
            'vacation_earned' => '0.167',
            'sick_earned' => '0.167',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '5',
            'vacation_earned' => '0.208',
            'sick_earned' => '0.208',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '6',
            'vacation_earned' => '0.250',
            'sick_earned' => '0.250',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '7',
            'vacation_earned' => '0.292',
            'sick_earned' => '0.292',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '8',
            'vacation_earned' => '0.333',
            'sick_earned' => '0.333',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '9',
            'vacation_earned' => '0.375',
            'sick_earned' => '0.375',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '10',
            'vacation_earned' => '0.417',
            'sick_earned' => '0.417',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '11',
            'vacation_earned' => '0.458',
            'sick_earned' => '0.458',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '12',
            'vacation_earned' => '0.500',
            'sick_earned' => '0.500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '13',
            'vacation_earned' => '0.542',
            'sick_earned' => '0.542',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '14',
            'vacation_earned' => '0.583',
            'sick_earned' => '0.583',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '15',
            'vacation_earned' => '0.625',
            'sick_earned' => '0.625',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '16',
            'vacation_earned' => '0.667',
            'sick_earned' => '0.667',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '17',
            'vacation_earned' => '0.708',
            'sick_earned' => '0.708',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '18',
            'vacation_earned' => '0.750',
            'sick_earned' => '0.750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '19',
            'vacation_earned' => '0.792',
            'sick_earned' => '0.792',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '20',
            'vacation_earned' => '0.833',
            'sick_earned' => '0.833',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '21',
            'vacation_earned' => '0.875',
            'sick_earned' => '0.875',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '22',
            'vacation_earned' => '0.917',
            'sick_earned' => '0.917',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '23',
            'vacation_earned' => '0.958',
            'sick_earned' => '0.958',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '24',
            'vacation_earned' => '1.000',
            'sick_earned' => '1.000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '25',
            'vacation_earned' => '1.042',
            'sick_earned' => '1.042',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '26',
            'vacation_earned' => '1.083',
            'sick_earned' => '1.083',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '27',
            'vacation_earned' => '1.125',
            'sick_earned' => '1.125',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '28',
            'vacation_earned' => '1.167',
            'sick_earned' => '1.042',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '29',
            'vacation_earned' => '1.208',
            'sick_earned' => '1.208',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('daily_earned')->insert([
            'days' => '30',
            'vacation_earned' => '1.250',
            'sick_earned' => '1.250',
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
        Schema::dropIfExists('daily_earned');
    }
};
