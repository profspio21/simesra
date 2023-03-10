<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            OutletKitchensTableSeeder::class,
            RawMaterialCategoriesTableSeeder::class,
            RawMaterialsTableSeeder::class,
            ProductsTableSeeder::class,
            ProductRmTableSeeder::class,
            SalesTableSeeder::class,
            OkRmTableSeeder::class,
        ]);
    }
}
