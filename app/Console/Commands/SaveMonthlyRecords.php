<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SaveMonthlyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:monthly-records';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save monthly records automatically.';

    /**
     * Execute the console command.
     *
     * @return int
     */
  public function handle()
{
    $today = now()->startOfDay(); // normalize to avoid time issues

    $endOfThisMonth = now()->copy()->endOfMonth()->startOfDay();
    $oneWeekAfterLastMonthEnd = now()->copy()->startOfMonth()->subDay()->addWeek()->startOfDay();

    if ($today->equalTo($endOfThisMonth) || $today->equalTo($oneWeekAfterLastMonthEnd)) {
        DB::table('leaves')->insert([
            'employee_id' => '3',
            'name' => '123_' . now(),
            'vl'=> '1',
            'sl'=> '1',
            'spl'=> '1',
            'fl'=> '1',
            'other'=> '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->info('✅ Monthly records saved successfully.');
    } else {
        $this->info('⏭ Not the end of the month or 1 week after. Skipping.');
    }
}



}
