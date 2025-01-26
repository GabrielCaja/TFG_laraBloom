<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComentariosBlog;

class ComentariosController extends Controller
{
    private $comentario;

    public function __construct(ComentariosBlog $comentario)
    {
        $this->comentario = $comentario;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comentario = $this->comentario->all();
        return response()->json($comentario);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'comentario' => 'required|string',
            'articulo_id' => 'required|integer',
            'user_id' => 'required|integer'
        ],
        [
            'comentario.required' => 'El campo comentario es obligatorio',
            'articulo_id.required' => 'El campo articulo_id es obligatorio', 
            'user_id.required' => 'El campo user_id es obligatorio'
        ]
        );

        $comentario = $this->comentario->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comentario = $this->comentario->findOrFAil($id);
        return response()->json($comentario);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            'comentario' => 'required|string',
            'articulo_id' => 'required|integer',
            'user_id' => 'required|integer'
        ],
        [
            'comentario.required' => 'El campo comentario es obligatorio',
            'articulo_id.required' => 'El campo articulo_id es obligatorio', 
            'user_id.required' => 'El campo user_id es obligatorio'
        ]
        );

        $comentario = $this->comentario->findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comentario = $this->comentario->findOrFail($id)->delete();
    }
}
