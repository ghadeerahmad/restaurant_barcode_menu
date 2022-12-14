<?php

namespace Database\Seeders;

use App\Models\StoreRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorePrivilegeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_privilege_roles')->truncate();
        $store_roles = StoreRole::all();
        $data = [];
        foreach($store_roles as $role){
            array_push($data,['store_role_id'=>$role->id,'store_privilege_id'=>1]);
        }
        DB::table('store_privilege_roles')->insert($data);
    }
}
