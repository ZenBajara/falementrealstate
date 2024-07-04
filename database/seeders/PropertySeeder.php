<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Image;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $defaultImagePath = 'property-images/Fr68eavzqW-real-estate-sign-2.webp';

        Property::factory()
            ->count(200)
            ->create();
    }
}
