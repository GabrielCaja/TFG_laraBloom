<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';
    protected $fillable = ['id', 'user_id'];

    public function Usuario()
    {
        return $this->hasMany(Usuario::class);
    }

}
