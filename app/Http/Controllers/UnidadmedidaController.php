<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidadmedida;

class UnidadmedidaController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()) return redirect('/');

        $buscar   = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar=='') {
            $unidades = Unidadmedida::orderBy('id', 'desc')->paginate(12);
        }
        else {
            $unidades = Unidadmedida::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(12);
        }

        return[
            'pagination' => [
                'total'        => $unidades ->total(),
                'current_page' => $unidades -> currentPage(),
                'per_page'     => $unidades -> perPage(),
                'last_page'    => $unidades -> lastPage(),
                'from'         => $unidades -> firstItem(),
                'to'           => $unidades -> lastItem(),
            ],
            'unidades' => $unidades
        ];
        // Unidadmedida::all();
        // return $unidades;
    }
    public function selectUnidad(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $unidades = Unidadmedida::where('condicion', '=', '1')
        ->select('id', 'nombre')->orderBy('nombre','asc')->get();

        return['unidades'=>$unidades];
    }
    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');
        $unidad            = new Unidadmedida();
        $unidad->nombre    = $request->nombre;
        $unidad->prefijo   = $request->prefijo;
        $unidad->condicion = '1';
        $unidad->save();
    }
    public function update(Request $request){
        if (!$request->ajax()) return redirect('/');
        $unidad            = Unidadmedida::findOrFail($request->id);
        $unidad->nombre    = $request->nombre;
        $unidad->prefijo   = $request->prefijo;
        $unidad->condicion = '1';
        $unidad->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $unidad = Unidadmedida::findOrFail($request->id);
        $unidad->condicion = '0';
        $unidad->save();
    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $unidad = Unidadmedida::findOrFail($request->id);
        $unidad->condicion = '1';
        $unidad->save();
    }
}
