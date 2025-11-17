<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyCategory;

class PropertyCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        PropertyCategory::insert([
            ['name' => 'Apartment'],
            ['name' => 'House'],
            ['name' => 'Villa'],
            ['name' => 'Condo'],
        ]);
    }
}
