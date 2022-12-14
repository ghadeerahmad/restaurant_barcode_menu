<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitePrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_privileges')->insert([
            [
                'name_ar'=>'أدمن',
                'name_en'=>'Admin'
            ],
            [
                'name_ar'=>'مدير',
                'name_en'=>'manager'
            ],
            [
                'name_ar'=>'مشرف',
                'name_en'=>'Super Visor'
            ]
        ]);
    }
}
