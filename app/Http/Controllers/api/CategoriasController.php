<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorias;

class CategoriasController extends Controller
{

    private $categoria;

    public function __construct(Categorias $categoria) {
        $this->categoria = $categoria;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria= $this->categoria->all();
        return response()->json($categoria);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate(
            [
                "nombre" => "required|string",
                "descripcion" => "required|string",
            ],
            [
                "nombre.required" => "El nombre es requerido",
                "nombre.string" => "El nombre debe ser un texto",
                "descripcion.required" => "La descripcion es requerida",
                "descripcion.string" => "La descripcion debe ser un texto",
            ]);

        $categoria = $this->categoria->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = $this->categoria->find($id);   
        return response()->json($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate(
            [
                "nombre" => "required|string",
                "descripcion" => "required|string",
            ],
            [
                "nombre.required" => "El nombre es requerido",
                "nombre.string" => "El nombre debe ser un texto",
                "descripcion.required" => "La descripcion es requerida",
                "descripcion.string" => "La descripcion debe ser un texto",
            ]);

        $categoria = $this->categoria->find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
