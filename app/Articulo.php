<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = ['categoria_id', 'codigo', 'nombre','unidadmedida_id', 'precio_compra', 'precio_venta', 'stock', 'stock_minimo','descripcion','condicion'];
    
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function unidadmedida(){
        return $this->belongsTo('App\Unidadmedida');
    }
}
