<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->admin) {
            return response()->json(['message' => 'No tienes permiso para acceder a esta página.'], 403);
        }

        // Aquí puedes agregar la lógica para mostrar el dashboard
        return response()->json(['message' => 'Bienvenido al dashboard de administrador.']);
    }
}