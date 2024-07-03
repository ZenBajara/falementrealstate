<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'image_path'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getUrlAttribute()
    {
        if (!empty($this->attributes['image_path'])) {
            return asset('/storage/'.$this->attributes['image_path']);
        } else {
            return null;
        }
    }
}
