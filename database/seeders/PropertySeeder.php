<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Images;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $defaultImagePath = 'property_images/81Y3YsCAMmc3qDL7xDYz4BeuhO4LDCwzwFVF7zuc.webp';

        Property::factory()
            ->count(200)
            ->create()
            ->each(function ($property) use ($defaultImagePath) {
                $property->property_type_id = PropertyType::inRandomOrder()->first()->id;
                $property->save();
                foreach (range(1, 2) as $index) {
                    Images::create([
                        'property_id' => $property->id,
                        'image_path' => $defaultImagePath,
                    ]);
                }
            });
    }
}
