<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'paypal_transaction_id',
        'amount',
        'status',
        'payment_method',
        'payment_details',
    ];

    /**
     * El atributo payment_details debe ser casteado a array/json automáticamente.
     */
    protected $casts = [
        'payment_details' => 'array',
    ];

    /**
     * Relación: Una transacción pertenece a una orden.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
