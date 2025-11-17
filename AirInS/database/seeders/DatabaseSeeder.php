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

        AirUser::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        // Create 20 property records with fake photos
        Property::factory(20)->create([
            'user_id' => 1
        ]);
    }
}
