<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relación: Una orden pertenece a un usuario.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una orden tiene muchos items.
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: Una orden tiene una transacción.
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
