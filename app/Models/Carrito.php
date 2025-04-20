<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';
    protected $fillable = ['id', 'user_id'];
    public $timestamps = false; // Si tu tabla no tiene timestamps

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function productos()
    {
        return $this->hasMany(ProductosCarrito::class, 'carrito_id');
    }
}