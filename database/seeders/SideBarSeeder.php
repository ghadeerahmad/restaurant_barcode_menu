<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SideBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table()->delete();
        DB::table()->insert([
            0=>array(
                'title'=>'dashboard',
                'url'=>'/dashboard',
                'admin'=>0
            ),
            1=>array(
                'title'=>'inventory',
                'url'=>'/inventory',
                'admin'=>0
            )
        ]);
    }
}
