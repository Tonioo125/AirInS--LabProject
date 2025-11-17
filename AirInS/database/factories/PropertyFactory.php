<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\AirUser;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'user_id' => AirUser::inRandomOrder()->first()->id ?? 1,
            'category_id' => PropertyCategory::inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'photos' => 'photos/' . $this->faker->image('storage/app/public/properties', 640, 480, null, false),
            'location' => $this->faker->city(),
            'price' => $this->faker->numberBetween(100000, 10000000),
            'is_available' => $this->faker->boolean(90),
        ];
    }
}
