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
        $request -> validate([
            "username" => "required|string",
            "email" => "required|email",
            "password" => "required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
            "admin" => "required|boolean",
            "newsletter" => "required|boolean",
        ],
        [
            "username.required" => "El campo username es obligatorio",
            "username.string" => "El campo username debe ser una cadena de texto",
            "email.required" => "El campo email es obligatorio",
            "email.email" => "El campo email debe ser un email",
            "password.required" => "El campo password es obligatorio",
            "password.string" => "El campo password debe ser una cadena de texto",
            "password.min" => "El campo password debe tener al menos 8 caracteres",
            "password.regex" => "El campo password debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial",
        ]
    );
        $usuario = $this->usuario->create($request->all());
        return response()->json($usuario, 201);
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
