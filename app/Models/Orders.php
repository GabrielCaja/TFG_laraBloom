<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'costo', 
        'estado',
        'metodo_pago',
        'stripe_payment_intent_id'
    ];   
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'user_id');
    }

    public function productos()
    {
        return $this->hasMany(ProductoOrder::class, 'order_id');
    }
}
