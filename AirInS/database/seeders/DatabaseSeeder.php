<?php

namespace Database\Seeders;

use App\Models\AirUser;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $user = User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 1. Seed categories first
        $this->call(PropertyCategoriesSeeder::class);

        // 2. Create admin user
        $user = AirUser::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Create properties (Faker will choose valid category IDs)
        Property::factory(20)->create([
            'user_id' => $user->id,
        ]);
    }
}
