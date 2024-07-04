<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'property_type_id',
        'num_bathrooms',
        'num_bedrooms',
        'price',
        'is_featured',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

}
