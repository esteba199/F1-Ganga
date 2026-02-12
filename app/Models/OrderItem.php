<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relación: Un item pertenece a una orden.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación: Un item corresponde a un coche.
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
