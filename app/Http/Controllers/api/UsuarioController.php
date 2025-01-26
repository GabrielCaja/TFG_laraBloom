<?php

namespace App\Http\Controllers\api;

use App\Models\Usuarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $usuario;

    public function __construct(Usuarios $usuario) {
        $this->usuario = $usuario;
    }
    


    public function index()
    {
        $usuario = $this->usuario->all();
        return response()->json($usuario, 200);
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
        $usuario = $this->usuario->find($id);
        return response()->json($usuario, 200);
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
