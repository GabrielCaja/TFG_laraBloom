<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    //Obtener pedidos del usuario autenticado
    public function misPedidos()
    {
        $userId = Auth::id();
        
        $pedidos = Orders::where('user_id', $userId)
            ->with(['productos' => function($query) {
                $query->select(
                    'productos.id',
                    'productos.nombre',
                    'productos.rutaImg',
                    'productos.descripcion',
                    'productos_order.cantidad',
                    'productos_order.precio_compra',
                    'productos_order.order_id'
                );
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        //Formatear los datos para el frontend
        $pedidos = $pedidos->map(function($pedido) {
            return [
                'id' => $pedido->id,
                'total' => $pedido->costo, 
                'estado' => $pedido->estado,
                'fecha_pedido' => $pedido->created_at,
                'created_at' => $pedido->created_at,
                'metodo_pago' => $pedido->metodo_pago,
                'productos' => $pedido->productos->map(function($producto) {
                    return [
                        'id' => $producto->id,
                        'nombre' => $producto->nombre,
                        'rutaImg' => $producto->rutaImg,
                        'descripcion' => $producto->descripcion,
                        'cantidad' => $producto->pivot->cantidad,
                        'precio' => $producto->pivot->precio_compra 
                    ];
                })
            ];
        });

        return response()->json($pedidos);
    }

    //Obtener detalles de un pedido específico
    public function verPedido($id)
    {
        $userId = Auth::id();
        
        $pedido = Orders::where('user_id', $userId)
            ->where('id', $id)
            ->with(['productos' => function($query) {
                $query->select(
                    'productos.id',
                    'productos.nombre',
                    'productos.rutaImg',
                    'productos.descripcion',
                    'productos_order.cantidad',
                    'productos_order.precio_compra', 
                    'productos_order.order_id'
                );
            }])
            ->first();

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        return response()->json([
            'id' => $pedido->id,
            'total' => $pedido->costo,
            'estado' => $pedido->estado,
            'fecha_pedido' => $pedido->created_at,
            'created_at' => $pedido->created_at,
            'metodo_pago' => $pedido->metodo_pago,
            'productos' => $pedido->productos->map(function($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'rutaImg' => $producto->rutaImg,
                    'descripcion' => $producto->descripcion,
                    'cantidad' => $producto->pivot->cantidad,
                    'precio' => $producto->pivot->precio_compra 
                ];
            })
        ]);
    }
}