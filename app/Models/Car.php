<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'model',
        'brand_id',
        'team_id',
        'year',
        'price',
        'description',
        'image_url',
        'top_speed',
        'acceleration',
        'engine',
        'horsepower',
        'transmission',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
