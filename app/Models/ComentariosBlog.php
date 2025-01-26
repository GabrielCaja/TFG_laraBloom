<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentariosBlog extends Model
{
    protected $table = 'comentarios_blog';
    protected $fillable = ['id', 'user_id', 'articulo_id', 'comentario'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function Usuario()
    {
        return $this->hasMany(Usuario::class);
    }

    public function Blog()
    {
        return $this->hasMany(Blog::class);
    }
}
