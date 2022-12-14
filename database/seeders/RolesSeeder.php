<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            0=>array(
                'name'=>'Allow Branches',
                'code'=>'branches'
            ),
            1=>array(
                'name'=>'Allow Delivery',
                'code'=>'delivery'
            ),
            2=>array(
                'name'=>'Allow Tables',
                'code'=>'tables'
            )
        ]);
    }
}
