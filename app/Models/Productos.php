<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre',"descripcion",'precio', 'stock', 'categoria_id',"rutaImg","visible"];

    public function categoria()
    {
        return $this->hasMany(Categorias::class, 'categoria_id', 'id');
    }
}
