<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('country_codes')->truncate();
        DB::table('country_codes')->insert([
            [
                'name_ar'=>'سوريا',
                'name_en'=>'Syria',
                'short_name'=>'SYR',
                'code'=>'+963'
            ]
        ]);
    }
}
