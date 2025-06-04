<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    // Obtener pedidos del usuario autenticado
    public function misPedidos()
    {
        $userId = Auth::id();
        
        $pedidos = Orders::where('user_id', $userId)
            ->with(['productos' => function($query) {
                $query->select(
                    'productos_order.*',
                    'productos.nombre',
                    'productos.rutaImg'
                );
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($pedidos);
    }

    // Obtener detalles de un pedido específico
    public function verPedido($id)
    {
        $userId = Auth::id();
        
        $pedido = Orders::where('user_id', $userId)
            ->where('id', $id)
            ->with(['productos' => function($query) {
                $query->join('productos', 'productos_order.producto_id', '=', 'productos.id')
                    ->select(
                        'productos_order.*',
                        'productos.nombre',
                        'productos.rutaImg',
                        'productos.descripcion'
                    );
            }])
            ->first();

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido);
    }
}