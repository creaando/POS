<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre', 'tipo_documento', 'num_documento', 'direccion', 'ciudad', 'telefono', 'email', 'nota'];

    public function proveedor() 
    {
        return $this->hasOne('App\Proveedor', 'id');
    }
}
