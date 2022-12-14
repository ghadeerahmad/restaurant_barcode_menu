<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->truncate();
        DB::table('themes')->insert([
            [
                'name'=>'Light',
                'information_class_background'=>'#ffffff',
                'information_class_color'=>'#000000',
                'info_product_class_background'=>'#ffffff',
                'info_product_class_color'=>'#000000',
                'primary_color'=>'#fcc02c',
                'secondary_color'=>null,
                'price_back_color'=>'#f9595a',
                'price_font_color'=>'#ffffff',
                'font_color'=>'#000000',
                'is_default'=>1
            ],
            [
                'name'=>'Dark',
                'information_class_background'=>'#ffffff',
                'information_class_color'=>'#000000',
                'info_product_class_background'=>'#ffffff',
                'info_product_class_color'=>'#000000',
                'primary_color'=>'#fcc02c',
                'secondary_color'=>null,
                'price_back_color'=>'#f9595a',
                'price_font_color'=>'#ffffff',
                'font_color'=>'#000000',
                'is_default'=>0
            ]
        ]);
    }
}
