<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('property_categories')->insert([
            [
                'id' => Str::upper(Str::random(5)),
                'name' => 'Apartment',
            ],
            [
                'id' => Str::upper(Str::random(5)),
                'name' => 'House',
            ],
            [
                'id' => Str::upper(Str::random(5)),
                'name' => 'Villa',
            ],
            [
                'id' => Str::upper(Str::random(5)),
                'name' => 'Condo',
            ],
        ]);
    }
}
