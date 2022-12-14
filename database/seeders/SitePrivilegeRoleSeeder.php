<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitePrivilegeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_privilege_roles')->insert([
            [
                'site_privilege_id'=>1,
                'site_role_id'=>1
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>2
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>3
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>4
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>5
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>6
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>7
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>8
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>9
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>10
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>11
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>12
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>13
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>14
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>15
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>16
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>17
            ],
            [
                'site_privilege_id'=>1,
                'site_role_id'=>18
            ]
        ]);
    }
}
