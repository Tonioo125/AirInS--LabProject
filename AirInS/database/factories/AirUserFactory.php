<?php

namespace Database\Factories;

use App\Models\AirUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AirUserFactory extends Factory
{
    protected $model = AirUser::class;

    public function definition(): array
    {
        return [
            'id' => 'A0001',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'role' => 'admin',
            'password' => Hash::make('password'),
        ];
    }
}
