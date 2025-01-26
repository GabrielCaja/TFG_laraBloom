<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductosCarrito extends Model
{
    protected $table = 'productos_carrito';
    protected $fillable = ['id', 'carrito_id', 'producto_id', 'cantidad', 'precio_actual'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function Carrito()
    {
        return $this->hasMany(Carrito::class);
    }

    public function Producto()
    {
        return $this->hasMany(Producto::class);
    }
}
