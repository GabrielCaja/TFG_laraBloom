<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    protected $table = 'articulos';
    protected $fillable = ['titulo', 'contenido', 'autor_id'];

    public function Usuario()
    {
        return $this->hasMany(Usuario::class);
    }
}
