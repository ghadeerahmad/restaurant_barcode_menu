<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_roles')->truncate();
        DB::table('store_roles')->insert([
            0 => [
                'name' => 'update Store',
                'code' => 'update_store',
                'group' => 'general'
            ],
            1 => [
                'name' => 'delete Store',
                'code' => 'delete_store',
                'group' => 'general'
            ],

            2 => [
                'name' => 'view branch',
                'code' => 'view_branch',
                'group' => 'branches'
            ],
            3 => [
                'name' => 'Create branch',
                'code' => 'create_branch',
                'group' => 'branches'
            ],
            4 => [
                'name' => 'update branch',
                'code' => 'update_branch',
                'group' => 'branches'
            ],
            5 => [
                'name' => 'delete branch',
                'code' => 'delete_branch',
                'group' => 'branches'
            ],
            6 => [
                'name' => 'view table',
                'code' => 'view_table',
                'group' => 'tables'
            ],
            7 => [
                'name' => 'Create table',
                'code' => 'create_table',
                'group' => 'tables'
            ],
            8 => [
                'name' => 'update table',
                'code' => 'update_table',
                'group' => 'tables'
            ],
            9 => [
                'name' => 'delete table',
                'code' => 'delete_table',
                'group' => 'tables'
            ],
            10 => [
                'name' => 'view coupon',
                'code' => 'view_coupon',
                'group' => 'coupons'
            ],
            11 => [
                'name' => 'Create coupon',
                'code' => 'create_coupon',
                'group' => 'coupons'
            ],
            12 => [
                'name' => 'update coupon',
                'code' => 'update_coupon',
                'group' => 'coupons'
            ],
            13 => [
                'name' => 'delete coupon',
                'code' => 'delete_coupon',
                'group' => 'coupons'
            ],
            14 => [
                'name' => 'view product',
                'code' => 'view_product',
                'group' => 'products'
            ],
            15 => [
                'name' => 'create product',
                'code' => 'create_product',
                'group' => 'products'
            ],
            16 => [
                'name' => 'update product',
                'code' => 'update_product',
                'group' => 'products'
            ],
            17 => [
                'name' => 'delete product',
                'code' => 'delete_product',
                'group' => 'products'
            ],
            18 => [
                'name' => 'view category',
                'code' => 'view_category',
                'group' => 'categories'
            ],
            19 => [
                'name' => 'create category',
                'code' => 'create_category',
                'group' => 'categories'
            ],
            20 => [
                'name' => 'update category',
                'code' => 'update_category',
                'group' => 'categories'
            ],

            21 => [
                'name' => 'delete category',
                'code' => 'delete_category',
                'group' => 'categories'
            ],

            21 => [
                'name' => 'view expense',
                'code' => 'view_expense',
                'group' => 'expenses'
            ],
            22 => [
                'name' => 'create expense',
                'code' => 'create_expense',
                'group' => 'expenses'
            ],
            23 => [
                'name' => 'update expense',
                'code' => 'update_expense',
                'group' => 'expenses'
            ],
            24 => [
                'name' => 'delete expense',
                'code' => 'delete_expense',
                'group' => 'expenses'
            ],
            25 => [
                'name' => 'view order',
                'code' => 'view_order',
                'group' => 'orders'
            ],
            26 => [
                'name' => 'create order',
                'code' => 'create_order',
                'group' => 'orders'
            ],
            27 => [
                'name' => 'update order',
                'code' => 'update_order',
                'group' => 'orders'
            ],
            28 => [
                'name' => 'delete order',
                'code' => 'delete_order',
                'group' => 'orders'
            ],
            29 => [
                'name' => 'view customer',
                'code' => 'view_customer',
                'group' => 'customers'
            ],
            30 => [
                'name' => 'create customer',
                'code' => 'create_customer',
                'group' => 'customers'
            ],
            31 => [
                'name' => 'update customer',
                'code' => 'update_customer',
                'group' => 'customers'
            ],
            32 => [
                'name' => 'delete customer',
                'code' => 'delete_customer',
                'group' => 'customers'
            ],
            33 => [
                'name' => 'view plans',
                'code' => 'view_plan',
                'group' => 'Subscription Plans'
            ],
            44 => [
                'name' => 'modify plans',
                'code' => 'modify_plan',
                'group' => 'Subscription Plans'
            ],
            
            45 => [
                'name' => 'view users',
                'code' => 'view_user',
                'group' => 'Users'
            ],
            46 => [
                'name' => 'create users',
                'code' => 'create_user',
                'group' => 'Users'
            ],
            47 => [
                'name' => 'update users',
                'code' => 'update_user',
                'group' => 'Users'
            ],
            48 => [
                'name' => 'delete users',
                'code' => 'delete_user',
                'group' => 'Users'
            ],
            49 => [
                'name' => 'view themes',
                'code' => 'view_theme',
                'group' => 'Themes'
            ],
            50 => [
                'name' => 'create themes',
                'code' => 'create_theme',
                'group' => 'Themes'
            ],
            51 => [
                'name' => 'update themes',
                'code' => 'update_theme',
                'group' => 'Themes'
            ],
            52 => [
                'name' => 'delete themes',
                'code' => 'delete_theme',
                'group' => 'Themes'
            ],
        ]);
    }
}
