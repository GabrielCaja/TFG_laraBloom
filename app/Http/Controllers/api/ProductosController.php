<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;



class ProductosController extends Controller
{
    private $producto;
    public function __construct(Productos $producto) {
        $this->producto = $producto;
    }


    public function index()
    {
        $producto = $this->producto->all();
        return response()->json($producto);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            "nombre" => "required|string",
            "precio" => "required|decimal:2",
            "stock" => "required|integer",
            "descripcion" => "required|string",
            "categoria_id" => "required|integer",
            "rutaImg" => "required|string",
            "visible" => "required|boolean"
        ],
        [
            "nombre.required" => "El nombre es requerido",
            "nombre.string" => "El nombre debe ser un string",
            "precio.required" => "El precio es requerido",
            "precio.decimal" => "El precio debe ser un decimal",
            "stock.required" => "El stock es requerido",
            "stock.integer" => "El stock debe ser un entero",
            "descripcion.required" => "La descripción es requerida",
            "descripcion.string" => "La descripción debe ser un string",
            "categoria_id.required" => "La categoría es requerida",
            "categoria_id.integer" => "La categoria debe ser un entero"

        ]);
        return response()->json($this->producto->create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = $this->producto->find($id);
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            "nombre" => "required|string",
            "precio" => "required|decimal:2",
            "stock" => "required|integer",
            "descripcion" => "required|string",
            "categoria_id" => "required|integer",
            "rutaImg" => "required|string",
            "visible" => "required|boolean"

        ],
        [
            "nombre.required" => "El nombre es requerido",
            "nombre.string" => "El nombre debe ser un string",
            "precio.required" => "El precio es requerido",
            "precio.decimal" => "El precio debe ser un decimal",
            "stock.required" => "El stock es requerido",
            "stock.integer" => "El stock debe ser un entero",
            "descripcion.required" => "La descripción es requerida",
            "descripcion.string" => "La descripción debe ser un string",
            "categoria_id.required" => "La categoría es requerida",
            "categoria_id.integer" => "La categoria debe ser un entero"

        ]);
     
        return response()->json($this->producto->find($id)->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = $this->producto->find($id);
        $producto->delete();
        
    }
}
