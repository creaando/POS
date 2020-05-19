<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidadmedida extends Model
{
    protected $fillable = ['nombre', 'prefijo', 'condicion'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
