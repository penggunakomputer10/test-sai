<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        $this->call(GeneralSettingSeeder::class);
        $this->call(GroupSeeder::class);

        // Permission
        $this->call(DashboardPermissionSeeder::class);
        $this->call(UserGroupPermission::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(GeneralSettingPermissionSeeder::class);
        $this->call(ProvincePermissionSeeder::class);


        
        // Set Group To Permission List
        $this->call(SetGroupPermission::class);

        // Create Admin Account
        $this->call(AccountAdminSeeder::class);


    }
}
