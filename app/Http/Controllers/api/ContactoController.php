<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    private $contacto;

    public function __construct(Contacto $contacto)
    {
        $this->contacto = $contacto;
    }

    //Obtenemos todos los mensajes de contacto (para administradores)
    public function index()
    {
        $contactos = $this->contacto->orderBy('created_at', 'desc')->get();
        return response()->json($contactos);
    }

    //Guardar un nuevo mensaje de contacto (desde el frontend)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del email no es válido',
            'asunto.required' => 'El asunto es obligatorio',
            'mensaje.required' => 'El mensaje es obligatorio',
        ]);

        $contacto = $this->contacto->create($request->all());
        return response()->json([
            'message' => 'Mensaje enviado correctamente',
            'contacto' => $contacto
        ], 201);
    }

    //Ver un mensaje específico 
    public function show(string $id)
    {
        $contacto = $this->contacto->findOrFail($id);
        return response()->json($contacto);
    }

    //Actualizar mensaje como leído/no leído 
    public function update(Request $request, string $id)
    {
        $contacto = $this->contacto->findOrFail($id);
        $contacto->leido = $request->leido;
        $contacto->save();
        
        return response()->json([
            'message' => 'Estado actualizado',
            'contacto' => $contacto
        ]);
    }

    //Eliminar un mensaje
    public function destroy(string $id)
    {
        $contacto = $this->contacto->findOrFail($id);
        $contacto->delete();
        
        return response()->json([
            'message' => 'Mensaje eliminado correctamente'
        ]);
    }
}