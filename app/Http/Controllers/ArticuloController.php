<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticuloController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()) return redirect('/');

        $buscar   = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar=='') {
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->join('unidadmedidas','articulos.unidadmedida_id','=','unidadmedidas.id')
            ->select('articulos.*', 'categorias.nombre as nombre_categoria', 'unidadmedidas.nombre as nombre_unidad')
            // ->select('articulos.id','articulos.categoria_id', 'articulos.codigo', 'articulos.nombre', 'articulos.unidadmedida_id', 'articulos.precio_compra', 'articulos.precio_venta', 'articulos.stock', 'articulos.stock_minimo', 'articulos.descripcion','articulos.condicion', 'categorias.nombre as nombre_categoria', 'unidadmedidas.nombre as nombre_unidad' )
            ->orderBy('articulos.id', 'desc')->paginate(12);
        }
        else {
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->join('unidadmedidas','articulos.unidadmedida_id','=','unidadmedidas.id')
            ->select('articulos.*', 'categorias.nombre as nombre_categoria', 'unidadmedidas.nombre as nombre_unidad')
            // ->select('articulos.id','articulos.categoria_id', 'articulos.codigo', 'articulos.nombre', 'articulos.unidadmedida_id', 'articulos.precio_compra', 'articulos.precio_venta', 'articulos.stock', 'articulos.stock_minimo','articulos.descripcion','articulos.condicion', 'categorias.nombre as nombre_categoria', 'unidadmedidas.nombre as nombre_unidad' )
            ->where('articulos.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulos.id', 'desc')->paginate(12);
        }

        // $articulos = Categoria::paginate(10); //por eloquent
        return[
            'pagination' => [
                'total'        => $articulos ->total(),
                'current_page' => $articulos -> currentPage(),
                'per_page'     => $articulos -> perPage(),
                'last_page'    => $articulos -> lastPage(),
                'from'         => $articulos -> firstItem(),
                'to'           => $articulos -> lastItem(),
            ],
            'articulos' => $articulos
        ];
        // $Categoria::all();
        // return $categorias;
    }
    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');

        $articulo = new Articulo();

        $articulo->categoria_id = $request->categoria_id;
        // $articulo->nombre_categoria = $request->nombre_categoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->unidadmedida_id = $request->unidad_id;
        // $articulo->nombre_unidad = $request->nombre_unidad;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->stock_minimo = $request->stock_minimo;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function update(Request $request){
        // if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::findOrFail($request->id);

        $articulo->categoria_id = $request->categoria_id;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->unidadmedida_id = $request->unidad_id;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->stock_minimo = $request->stock_minimo;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }
}
