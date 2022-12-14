<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorePrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_privileges')->insert([
            [
                'name_ar'=>'أدمن',
                'name_en'=>'Admin',
                'is_default'=>1
            ],
            [
                'name_ar'=>'مدير',
                'name_en'=>'manager',
                'is_default'=>0
            ],
            [
                'name_ar'=>'مشرف',
                'name_en'=>'Super Visor',
                'is_default'=>0
            ]
        ]);
    }
}
