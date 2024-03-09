<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User\User;
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

//        User::create([
//            'name' => 'testUser',
//            'email' => 'testuser@test.com',
//            'password' => bcrypt('12345')
//        ]);

        $this->call([
            RoleAndPermissionSeeder::class,
            AssignRolesSeeder::class,
            AddValuesToTermsSeeder::class,
        ]);
    }
}
