<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = false;
}
