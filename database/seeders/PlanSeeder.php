<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            0=>array(
                'name_ar'=>'الباقة المجانية',
                'name_en'=>'Free Plan',
                'description_ar'=>'تسمح بإصافة أصناف ومنتجات',
                'description_en'=>'Allow Adding Products and categories',
                'max_branches'=>0,
                'price'=>0,
                'currency_id'=>1,
                'sub_type'=>'MONTH',
                'period'=>30,
                'is_default'=>1,
            )
        ]);
    }
}
