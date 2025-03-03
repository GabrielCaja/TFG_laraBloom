<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Articulos;

class ArticulosController extends Controller
{
    private $articulo;
    public function __construct(Articulos $articulo) {
        $this->articulo = $articulo;
    }
    /**s
     * Display a listing of the resource.
     */
    public function index()
    {
        $articulo = $this->articulo->all();
        return response()->json($articulo);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            "titulo" => "required|string",
            "contenido" => "required|string",
            "rutaImg" => "required|string"
        ],
        [
            "titulo.required" => "El titulo es requerido",
            "titulo.string" => "El titulo debe ser un string",
            "contenido.required" => "El contenido es requerido",
            "contenido.string" => "El contenido debe ser un string",
            "autor_id.integer" => "El autor debe ser un ID entero"
        ]);

        $articulo = $this->articulo->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $articulo = $this->articulo->findOrFail($id);
        return response()->json($articulo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            "titulo" => "required|string",
            "contenido" => "required|string",
            "autor_id" => "integer",
            "rutaImg" => "string"
        ],
        [
            "titulo.required" => "El titulo es requerido",
            "titulo.string" => "El titulo debe ser un string",
            "contenido.required" => "El contenido es requerido",
            "contenido.string" => "El contenido debe ser un string",
            "autor_id.integer" => "El autor debe ser un ID entero"
        ]);

        $articulo = $this->articulo->findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $articulo = $this->articulo->findOrFail($id)->delete();
    }
}
