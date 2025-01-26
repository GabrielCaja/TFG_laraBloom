<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductosOrder extends Model
{
    protected $table = 'productos_order';
    protected $fillable = ['id', 'order_id', 'producto_id', 'cantidad', 'precio_compra'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function Order()
    {
        return $this->hasMany(Order::class);
    }

    public function Producto()
    {
        return $this->hasMany(Producto::class);
    }
}
