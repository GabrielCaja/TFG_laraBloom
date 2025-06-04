<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;
use App\Models\Usuarios;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'costo', 
        'estado',
        'stripe_payment_intent_id',
        'metodo_pago'
    ];

    protected $casts = [
        'costo' => 'decimal:2'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'productos_order', 'order_id', 'producto_id')
                    ->withPivot('cantidad', 'precio_compra');
    }
}