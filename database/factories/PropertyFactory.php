<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Property;
use App\Models\PropertyType;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        // Get all property type IDs from the database
        $types = PropertyType::all()->pluck('id')->toArray();

        return [
            'name' => $this->faker->word,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'pincode' => $this->faker->postcode,
            'property_type_id' => $this->faker->randomElement($types),
            'num_bathrooms' => $this->faker->numberBetween(1, 5),
            'num_bedrooms' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 100000, 1000000),
            'images' => [
                'property-images/Fr68eavzqW-real-estate-sign-2.webp'
            ],
        ];
    }
}
