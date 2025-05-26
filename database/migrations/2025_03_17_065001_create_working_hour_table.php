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
        Schema::create('working_hour', function (Blueprint $table) {
            $table->id();
            $table->integer('minutes')->nullable();
            $table->decimal('equivalent_day',10, 3)->nullable();
            $table->timestamps();
        });
        $this->working();
    }
    private function working(): void
    {
        DB::table('working_hour')->insert([
            'minutes' => '1',
            'equivalent_day' => '0.002',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '2',
            'equivalent_day' => '0.004',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '3',
            'equivalent_day' => '0.006',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '4',
            'equivalent_day' => '0.008',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '5',
            'equivalent_day' => '0.010',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '6',
            'equivalent_day' => '0.012',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '7',
            'equivalent_day' => '0.015',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '8',
            'equivalent_day' => '0.017',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '9',
            'equivalent_day' => '0.019',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '10',
            'equivalent_day' => '0.021',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '11',
            'equivalent_day' => '0.023',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '12',
            'equivalent_day' => '0.025',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '13',
            'equivalent_day' => '0.027',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '14',
            'equivalent_day' => '0.029',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '15',
            'equivalent_day' => '0.031',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '16',
            'equivalent_day' => '0.033',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '17',
            'equivalent_day' => '0.035',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '18',
            'equivalent_day' => '0.037',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '19',
            'equivalent_day' => '0.040',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '20',
            'equivalent_day' => '0.042',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '21',
            'equivalent_day' => '0.046',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '22',
            'equivalent_day' => '0.047',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '23',
            'equivalent_day' => '0.048',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '24',
            'equivalent_day' => '0.050',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '25',
            'equivalent_day' => '0.052',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '26',
            'equivalent_day' => '0.054',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '27',
            'equivalent_day' => '0.056',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '28',
            'equivalent_day' => '0.058',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '29',
            'equivalent_day' => '0.060',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '30',
            'equivalent_day' => '0.062',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('working_hour')->insert([
            'minutes' => '31',
            'equivalent_day' => '0.065',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '32',
            'equivalent_day' => '0.067',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '33',
            'equivalent_day' => '0.069',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '34',
            'equivalent_day' => '0.071',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '35',
            'equivalent_day' => '0.073',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '36',
            'equivalent_day' => '0.075',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '37',
            'equivalent_day' => '0.077',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '38',
            'equivalent_day' => '0.079',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '39',
            'equivalent_day' => '0.081',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '40',
            'equivalent_day' => '0.083',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '41',
            'equivalent_day' => '0.085',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '42',
            'equivalent_day' => '0.087',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '43',
            'equivalent_day' => '0.090',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '44',
            'equivalent_day' => '0.092',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '45',
            'equivalent_day' => '0.094',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '46',
            'equivalent_day' => '0.096',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '47',
            'equivalent_day' => '0.098',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '48',
            'equivalent_day' => '0.100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '49',
            'equivalent_day' => '0.102',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '50',
            'equivalent_day' => '0.104',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '51',
            'equivalent_day' => '0.106',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '52',
            'equivalent_day' => '0.108',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '53',
            'equivalent_day' => '0.110',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '54',
            'equivalent_day' => '0.112',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '55',
            'equivalent_day' => '0.115',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '56',
            'equivalent_day' => '0.117',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '57',
            'equivalent_day' => '0.119',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '58',
            'equivalent_day' => '0.121',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '59',
            'equivalent_day' => '0.123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('working_hour')->insert([
            'minutes' => '60',
            'equivalent_day' => '0.125',
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
        Schema::dropIfExists('working_hour');
    }
};
