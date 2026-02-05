<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded = [];

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
