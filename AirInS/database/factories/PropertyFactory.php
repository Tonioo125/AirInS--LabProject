<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\AirUser;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $dummyPath = storage_path('app/public/dummy_properties');

        $files = collect(File::files($dummyPath))
            ->map(fn($file) => $file->getFilename());
        return [
            'user_id' => AirUser::inRandomOrder()->first()->id ?? 1,
            'category_id' => PropertyCategory::inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(200),
            'photos' => 'dummy_properties/' . $files->random(),
            'location' => $this->faker->city(),
            'price' => $this->faker->numberBetween(100000, 10000000),
            'is_available' => $this->faker->boolean(90),
        ];
    }
}
