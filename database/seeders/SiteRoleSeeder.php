<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_roles')->truncate();
        DB::table('site_roles')->insert([
            [
                'name' => 'view store privilege',
                'code' => 'view_store_privilege',
                'group' => 'Stores'
            ],
            [
                'name' => 'create store privilege',
                'code' => 'create_store_privilege',
                'group' => 'Stores'
            ],
            [
                'name' => 'update store privilege',
                'code' => 'update_store_privilege',
                'group' => 'Stores'
            ],
            [
                'name' => 'delete store privilege',
                'code' => 'delete_store_privilege',
                'group' => 'Stores'
            ],
            [
                'name' => 'view site privilege',
                'code' => 'view_site_privilege',
                'group' => 'Site Adminstration'
            ],
            [
                'name' => 'create site privilege',
                'code' => 'create_site_privilege',
                'group' => 'Site Adminstration'
            ],
            [
                'name' => 'update site privilege',
                'code' => 'update_site_privilege',
                'group' => 'Site Adminstration'
            ],
            [
                'name' => 'delete site privilege',
                'code' => 'delete_site_privilege',
                'group' => 'Site Adminstration'
            ],
            [
                'name' => 'view store',
                'code' => 'view_store',
                'group' => 'Stores'
            ],
            [
                'name' => 'update store',
                'code' => 'update_store',
                'group' => 'Stores'
            ],
            [
                'name' => 'delete store',
                'code' => 'delete_store',
                'group' => 'Stores'
            ],
            [
                'name' => 'view plan',
                'code' => 'view_plan',
                'group' => 'Plans'
            ],
            [
                'name' => 'create plan',
                'code' => 'create_plan',
                'group' => 'Plans'
            ],

            [
                'name' => 'update plan',
                'code' => 'update_plan',
                'group' => 'Plans'
            ],

            [
                'name' => 'delete plan',
                'code' => 'delete_plan',
                'group' => 'Plans'
            ],
            [
                'name' => 'view plan order',
                'code' => 'view_plan_order',
                'group' => 'Plans Orders'
            ],
            [
                'name' => 'update plan order',
                'code' => 'update_plan_order',
                'group' => 'Plans Orders'
            ],
            
            [
                'name' => 'delete plan order',
                'code' => 'delete_plan_order',
                'group' => 'Plans Orders'
            ],
            [
                'name' => 'view admins',
                'code' => 'view_admin',
                'group' => 'Site Admins'
            ],
            [
                'name' => 'update admins',
                'code' => 'update_admin',
                'group' => 'Site Admins'
            ],
            
            [
                'name' => 'create admins',
                'code' => 'create_admin',
                'group' => 'Site Admins'
            ],
            [
                'name' => 'delete admins',
                'code' => 'delete_admin',
                'group' => 'Site Admins'
            ],
            [
                'name' => 'view users',
                'code' => 'view_user',
                'group' => 'users'
            ],
            [
                'name' => 'update users',
                'code' => 'update_user',
                'group' => 'users'
            ],
            [
                'name' => 'create users',
                'code' => 'create_user',
                'group' => 'users'
            ],
            [
                'name' => 'delete users',
                'code' => 'delete_user',
                'group' => 'users'
            ],
            [
                'name' => 'view themes',
                'code' => 'view_theme',
                'group' => 'Themes'
            ],
            [
                'name' => 'create themes',
                'code' => 'create_theme',
                'group' => 'Themes'
            ],
            [
                'name' => 'update themes',
                'code' => 'update_theme',
                'group' => 'Themes'
            ],
            [
                'name' => 'delete themes',
                'code' => 'delete_theme',
                'group' => 'Themes'
            ],
            [
                'name' => 'Update Site Settings',
                'code' => 'update_settings',
                'group' => 'Settings'
            ],
            [
                'name' => 'View Questions',
                'code' => 'view_question',
                'group' => 'Questions'
            ],
            [
                'name' => 'create Questions',
                'code' => 'create_question',
                'group' => 'Questions'
            ],
            [
                'name' => 'update Questions',
                'code' => 'update_question',
                'group' => 'Questions'
            ],
            [
                'name' => 'delete Questions',
                'code' => 'delete_question',
                'group' => 'Questions'
            ],
        ]);
    }
}
