<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rates')->insert([
            'pallet'=>0.11,
            'lines'=>0.09,
            'vip'=>3,
            'extraHour'=>6
        ]);
    }
}
