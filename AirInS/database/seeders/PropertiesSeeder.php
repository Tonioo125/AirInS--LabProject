<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class PropertiesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Sample images placed in: public/fake_property_images/
        $sampleImages = [
            'house_1.jpg',
            'house_2.jpg',
            'house_3.jpg',
            'villa_1.jpg',
            'apartment_1.jpg',
        ];

        foreach (range(1, 10) as $i) {

            // pick random sample image
            $randomImage = $faker->randomElement($sampleImages);

            // generate a new unique name for stored file
            $newName = 'property_' . uniqid() . '.jpg';

            // copy the sample image to storage/app/public/properties/
            Storage::disk('public')->put(
                'properties/' . $newName,
                file_get_contents(public_path('dummy_properties/' . $randomImage))
            );

            // Insert with your EXACT columns
            DB::table('properties')->insert([
                'user_id' => 1,                      // adjust if needed
                'category_id' => 1,                  // adjust if needed
                'title' => $faker->sentence(4),
                'description' => $faker->text(120),
                'photos' => 'properties/' . $newName, // path saved in DB
                'location' => $faker->city(),
                'price' => $faker->numberBetween(300000000, 2000000000),
                'is_available' => $faker->boolean(80),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
