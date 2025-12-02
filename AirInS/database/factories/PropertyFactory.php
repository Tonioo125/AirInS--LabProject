<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\AirUser;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $dummyPath = public_path('dummy_properties');

        $files = collect(File::files($dummyPath))
            ->map(fn($file) => $file->getFilename());

        // Ensure we have at least one source image; otherwise keep photos null
        $selected = $files->isNotEmpty() ? $files->random() : null;

        $newPhotoPath = null;
        if ($selected) {
            $sourcePath = $dummyPath . DIRECTORY_SEPARATOR . $selected;
            $ext = pathinfo($selected, PATHINFO_EXTENSION) ?: 'jpg';
            $newName = 'property_' . (string) Str::uuid() . '.' . $ext;
            Storage::disk('public')->put('properties/' . $newName, File::get($sourcePath));
            $newPhotoPath = 'properties/' . $newName;
        }

        return [
            'id' => Str::upper(Str::random(5)), // tambahkan id string 5 karakter
            'user_id' => AirUser::inRandomOrder()->first()->id ?? 'A0001',
            'category_id' => PropertyCategory::inRandomOrder()->first()->id ?? 'C0001',
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(200),
            'photos' => $newPhotoPath,
            'location' => $this->faker->city(),
            'price' => $this->faker->numberBetween(100000, 10000000),
            'is_available' => $this->faker->boolean(90),
        ];
    }
}