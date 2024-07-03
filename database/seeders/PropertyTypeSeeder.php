<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['bungalow', 'apartment', 'villa', 'duplex'];

        foreach ($types as $type) {
            PropertyType::create(['type' => $type]);
        }
    }
}
