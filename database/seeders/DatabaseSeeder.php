<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        $this->call(SettingsSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(StoreRoleSeeder::class);
        $this->call(SiteRoleSeeder::class);
        $this->call(StorePrivilegeSeeder::class);
        $this->call(SitePrivilegeSeeder::class);
        $this->call(SitePrivilegeRoleSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CountryCodeSeeder::class);
        $this->call(StorePrivilegeSeeder::class);
        $this->call(StorePrivilegeRoleSeeder::class);
    }
}
