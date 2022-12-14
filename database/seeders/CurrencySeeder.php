<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();
        DB::table('currencies')->insert([
            0=>array(
                'name'=>'Syrian Pound',
                'code'=>'SP'
            )
        ]);
    }
}
