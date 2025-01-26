<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = ['id', 'user_id', 'costo'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function Usuario()
    {
        return $this->hasMany(Usuario::class);
    }

    public function product()
    {
        return $this->hasMany(Productos::class);
    }
}
