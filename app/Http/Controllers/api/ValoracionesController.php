<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Valoraciones;

class ValoracionesController extends Controller
{

    private $valoracion;

    public function __construct(Valoraciones $valoracion)
    {
        $this->valoracion = $valoracion;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valoracion = $this->valoracion->all();
        return response()->json($valoracion);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            "user_id" => "required|integer",
            "producto_id" => "required|integer",
            "valoracion" => "required|integer",
            "comentario" => "required|string",
        ],
        [
            "user_id.required" => "El campo user_id es requerido",
            "user_id.integer" => "El campo user_id debe ser un entero",
            "producto_id.required" => "El campo producto_id es requerido",
            "producto_id.integer" => "El campo producto_id debe ser un entero",
            "valoracion.required" => "El campo valoracion es requerido",
            "valoracion.integer" => "El campo valoracion debe ser un entero",
            "comentario.required" => "El campo comentario es requerido",
            "comentario.string" => "El campo comentario debe ser un string",
        ]
    );

        $valoracion = $this->valoracion->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $valoracion = $this->valoracion->findOrFail($id);
        return response()->json($valoracion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            "user_id" => "required|integer",
            "producto_id" => "required|integer",
            "valoracion" => "required|integer",
            "comentario" => "required|string",
        ],
        [
            "user_id.required" => "El campo user_id es requerido",
            "user_id.integer" => "El campo user_id debe ser un entero",
            "producto_id.required" => "El campo producto_id es requerido",
            "producto_id.integer" => "El campo producto_id debe ser un entero",
            "valoracion.required" => "El campo valoracion es requerido",
            "valoracion.integer" => "El campo valoracion debe ser un entero",
            "comentario.required" => "El campo comentario es requerido",
            "comentario.string" => "El campo comentario debe ser un string",
        ]
    );

        $valoracion = $this->valoracion->findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $valoracion = $this->valoracion->findOrFail($id)->delete();
    }
}
