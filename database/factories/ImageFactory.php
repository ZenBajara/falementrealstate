<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'property_id' => \App\Models\Property::factory(), // Associate with a property
            'image_url' => $this->faker->imageUrl(640, 480, 'property', true, 'Faker'), // Random image URL
            'title' => $this->faker->word,
        ];
    }
}
