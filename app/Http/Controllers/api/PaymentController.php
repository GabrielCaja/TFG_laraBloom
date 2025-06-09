<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\Orders;
use App\Models\ProductosOrder;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $carrito = Carrito::where('user_id', $userId)->first();

            if (!$carrito) {
                return response()->json(['error' => 'No se encontró el carrito'], 404);
            }

            $productos = $carrito->productos()
                ->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
                ->select(
                    'productos__carrito.*',
                    'productos.nombre',
                    'productos.precio',
                    'productos.precio as precio_actual'
                )
                ->get();

            if ($productos->isEmpty()) {
                return response()->json(['error' => 'El carrito está vacío'], 400);
            }

            $total = 0;
            foreach ($productos as $producto) {
                $total += $producto->precio_actual * $producto->cantidad;
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => round($total * 100),
                'currency' => 'eur',
                'metadata' => [
                    'user_id' => $userId,
                    'carrito_id' => $carrito->id
                ]
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'total' => $total,
                'productos' => $productos
            ]);

        } catch (Exception $e) {
            \Log::error('Error creating payment intent: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear el intent de pago: ' . $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        try {
            $request->validate([
                'payment_intent_id' => 'required|string'
            ]);

            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);
            
            if ($paymentIntent->status !== 'succeeded') {
                return response()->json(['error' => 'El pago no se completó correctamente'], 400);
            }

            $carrito = Carrito::where('user_id', $userId)->first();

            if (!$carrito) {
                return response()->json(['error' => 'Carrito no encontrado'], 404);
            }

            $productos = $carrito->productos()
                ->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
                ->select(
                    'productos__carrito.*',
                    'productos.nombre',
                    'productos.precio',
                    'productos.precio as precio_actual'
                )
                ->get();

            $ordenId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'costo' => $paymentIntent->amount / 100,
                'estado' => 'completado',
                'metodo_pago' => 'stripe',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($productos as $producto) {
                DB::table('productos_order')->insert([
                    'order_id' => $ordenId,
                    'producto_id' => $producto->producto_id,
                    'cantidad' => $producto->cantidad,
                    'precio_compra' => $producto->precio_actual,
                ]);

                DB::table('productos')
                    ->where('id', $producto->producto_id)
                    ->decrement('stock', $producto->cantidad);
            }

            DB::table('productos__carrito')->where('carrito_id', $carrito->id)->delete();

            return response()->json([
                'message' => 'Pago procesado correctamente',
                'order_id' => $ordenId
            ]);

        } catch (Exception $e) {
            \Log::error('Error confirming payment: ' . $e->getMessage());
            return response()->json(['error' => 'Error al confirmar el pago: ' . $e->getMessage()], 500);
        }
    }
}