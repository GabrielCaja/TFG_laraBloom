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
