<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    
    protected $fillable = [
        'user_id',
        'car_id',
        'quantity',
    ];

    // Relación: Un item del carrito pertenece a un usuario.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un item del carrito corresponde a un coche.
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
