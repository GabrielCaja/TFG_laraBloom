<?php

namespace App\Http\Controllers\api;

use App\Models\Usuarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
        ]);
        $usuario = $this->usuario->create($request->all());
        return response()->json($usuario, 201);
        }

    public function show(string $id)
    {
        $usuario = $this->usuario->find($id);
        return response()->json($usuario, 200);
    }


    public function update(Request $request, string $id)
    {
        $request -> validate([
            "username" => "required|string",
            "email" => "required|email",
            "password" => "string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
            "admin" => "required|boolean",
            "newsletter" => "required|boolean",
        ],
        [
            "username.required" => "El campo username es obligatorio",
            "username.string" => "El campo username debe ser una cadena de texto",
            "email.required" => "El campo email es obligatorio",
            "email.email" => "El campo email debe ser un email",
            "password.string" => "El campo password debe ser una cadena de texto",
            "password.min" => "El campo password debe tener al menos 8 caracteres",
            "password.regex" => "El campo password debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial",
        ]);
        $usuario = $this->usuario->find($id);

        $usuario->update($request->all());
        return response()->json($usuario, 201);
        }

    public function destroy(string $id)
    {
        $usuario = $this->usuario->find($id);

        $usuario->delete();
        return response()->json("Usuario eliminado: " . $usuario->username, 204);
    }

    //Modificar usuario desde el frontend
    public function perfil(Request $request)
    {
        //Log de debug
        Log::info('Acceso a perfil', [
            'has_user' => $request->user() ? true : false,
            'auth_check' => auth()->check(),
            'bearer_token' => $request->bearerToken() ? 'presente' : 'ausente',
            'headers' => $request->headers->all(),
        ]);
    
        //Intenta diferentes métodos para obtener el usuario
        $usuarioRequest = $request->user();
        $usuarioAuth = auth()->user();
        $usuarioAuthGuard = Auth::guard('sanctum')->user();
    
        //Log de resultados
        Log::info('Resultados de búsqueda de usuario', [
            'request_user' => $usuarioRequest ? $usuarioRequest->id : null,
            'auth_user' => $usuarioAuth ? $usuarioAuth->id : null,
            'auth_guard_user' => $usuarioAuthGuard ? $usuarioAuthGuard->id : null,
        ]);
    
        if ($usuarioRequest) {
            return response()->json($usuarioRequest, 200);
        } else if ($usuarioAuth) {
            return response()->json($usuarioAuth, 200);
        } else if ($usuarioAuthGuard) {
            return response()->json($usuarioAuthGuard, 200);
        } else {
            return response()->json([
                'error' => 'No hay usuario autenticado', 
                'auth_check' => auth()->check(),
                'token_presente' => $request->bearerToken() ? true : false
            ], 401);
        }
    }

    //Actualizar el perfil del usuario autenticado
    public function actualizarPerfil(Request $request)
    {
    //Obtenemos el usuario autenticado por el token
    $usuario = $request->user();
    
    //Validaciones
    $validaciones = [
        "username" => "required|string",
        "email" => "required|email",
        "newsletter" => "boolean"
    ];
    
    $mensajes = [
        "username.required" => "El nombre de usuario es obligatorio",
        "username.string" => "El nombre de usuario debe ser una cadena de texto",
        "email.required" => "El email es obligatorio",
        "email.email" => "El formato del email no es válido",
    ];
    
    //Si viene una contraseña, la validamos
    if ($request->filled('password')) {
        $validaciones["password"] = "string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        $mensajes["password.min"] = "La contraseña debe tener al menos 8 caracteres";
        $mensajes["password.regex"] = "La contraseña debe contener al menos una letra mayúscula, una minúscula, un número y un carácter especial";
    }
    
    $request->validate($validaciones, $mensajes);
    
    //Actualizamos los datos
    $datos = $request->only(['username', 'email', 'newsletter']);
    
    //Si viene contraseña, la actualizamos
    if ($request->filled('password')) {
        $datos['password'] = bcrypt($request->password);
    }
    
    $usuario->update($datos);
    
    return response()->json($usuario, 200);
}
}
