<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoraciones extends Model
{
    protected $table = 'valoraciones';
    protected $fillable = ['id', 'user_id', 'producto_id', 'valoracion', 'comentario', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function Usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id', 'id');
    }
}
