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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
