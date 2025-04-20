<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\ProductoOrder;
use App\Models\Carrito;

class CarritoController extends Controller
{

    private $carrito;

    public function __construct(Carrito $carrito)
    {
        $this->carrito = $carrito;
    }

    public function index()
    {
        //Obtener todos los carritos con sus productos relacionados
        $carritos = $this->carrito->with(['productos' => function($query) {
            $query->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
                ->select('productos__carrito.*', 'productos.nombre', 'productos.rutaImg', 'productos.precio');
        }])->get();
        
        return response()->json($carritos);
    }

    public function show($id)
    {
        // Obtener un carrito específico por su ID
        $carrito = $this->carrito->with(['productos' => function($query) {
            $query->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
                ->select('productos__carrito.*', 'productos.nombre', 'productos.rutaImg', 'productos.precio');
        }])->find($id);
        
        if (!$carrito) {
            return response()->json(['message' => 'Carrito no encontrado'], 404);
        }
        
        return response()->json($carrito);
    }

public function store(Request $request)
{
    //Validar la solicitud
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
    ]);
    
    //Obtener el ID del usuario autenticado
    $userId = Auth::id();
    
    //Buscar si el usuario ya tiene un carrito
    $carrito = $this->carrito->where('user_id', $userId)->first();
    
    //Si no tiene carrito, crear uno nuevo
    if (!$carrito) {
        $carrito = new Carrito();
        $carrito->user_id = $userId;
        $carrito->save();
    }
    
    //Obtener el producto y su precio actual
    $producto = Productos::findOrFail($request->producto_id);
    
    //Verificar si el producto ya está en el carrito
    $productoEnCarrito = DB::table('productos__carrito')
        ->where('carrito_id', $carrito->id)
        ->where('producto_id', $request->producto_id)
        ->first();
    
    if ($productoEnCarrito) {
        //Actualizar la cantidad si ya existe
        DB::table('productos__carrito')
            ->where('id', $productoEnCarrito->id)
            ->update([
                'cantidad' => $productoEnCarrito->cantidad + $request->cantidad
            ]);
    } else {
        //Agregar nuevo producto al carrito
        DB::table('productos__carrito')->insert([
            'carrito_id' => $carrito->id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_actual' => $producto->precio
        ]);
    }
    
    //Deevolver el carrito actualizado con sus productos
    $carritoActualizado = $this->carrito->with(['productos' => function($query) {
        $query->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
            ->select('productos__carrito.*', 'productos.nombre', 'productos.rutaImg', 'productos.precio');
    }])->find($carrito->id);
    
    return response()->json($carritoActualizado, 201);
}
    public function miCarrito()
    {
        //Obtener el ID del usuario autenticado
        $userId = Auth::id();
        
        //Buscar el carrito del usuario autenticado
        $carrito = $this->carrito->where('user_id', $userId)
            ->with(['productos' => function($query) {
                $query->join('productos', 'productos__carrito.producto_id', '=', 'productos.id')
                    ->select('productos__carrito.*', 'productos.nombre', 'productos.rutaImg', 'productos.precio');
            }])
            ->first();
        
        if (!$carrito) {
            // Si no existe un carrito, devolver uno vacío
            return response()->json(['message' => 'No tienes un carrito activo', 'productos' => []], 200);
        }
        
        return response()->json($carrito);
    }
    public function destroy($id)
    {
        //Eliminar un producto del carrito
        $productoEnCarrito = DB::table('productos__carrito')->where('id', $id)->first();
        
        if (!$productoEnCarrito) {
            return response()->json(['message' => 'Producto no encontrado en el carrito'], 404);
        }
        
        DB::table('productos__carrito')->where('id', $id)->delete();
        
        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }
    public function eliminarProducto($productoId)
    {
    //Obtener el ID del usuario autenticado
    $userId = Auth::id();
    
    //Buscar el carrito del usuario
    $carrito = $this->carrito->where('user_id', $userId)->first();
    
    if (!$carrito) {
        return response()->json(['message' => 'No tienes un carrito activo'], 404);
    }
    
    //Verificar que el producto a eliminar pertenece al carrito del usuario autenticado
    $productoEnCarrito = DB::table('productos__carrito')
                        ->where('producto_id', $productoId)
                        ->where('carrito_id', $carrito->id)
                        ->first();
    
    if (!$productoEnCarrito) {
        return response()->json(['message' => 'Producto no encontrado en tu carrito'], 404);
    }
    
    //Eliminar el producto del carrito basado en producto_id
    DB::table('productos__carrito')
        ->where('producto_id', $productoId)
        ->where('carrito_id', $carrito->id)
        ->delete();
    
    return response()->json(['message' => 'Producto eliminado del carrito'], 200);
}
    public function vaciarCarrito()
    {
        //Obtener el ID del usuario autenticado
        $userId = Auth::id();
        
        //Buscar el carrito del usuario
        $carrito = $this->carrito->where('user_id', $userId)->first();
        
        if (!$carrito) {
            return response()->json(['message' => 'No tienes un carrito activo'], 404);
        }
        
        //Eliminar todos los productos del carrito
        DB::table('productos__carrito')->where('carrito_id', $carrito->id)->delete();
        
        return response()->json(['message' => 'Carrito vaciado'], 200);
    }
    public function actualizarProducto(Request $request)
    {
        try {
            //Validar la petición
            $request->validate([
                'producto_id' => 'required|integer|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
            ]);

            //Obtener el ID del usuario autenticado
            $userId = Auth::id();
            
            //Obtener el carrito del usuario autenticado
            $carrito = $this->carrito->where('user_id', $userId)->firstOrFail();

            //Buscar el producto en el carrito
            $productoEnCarrito = DB::table('productos__carrito')
                ->where('carrito_id', $carrito->id)
                ->where('producto_id', $request->producto_id)
                ->first();
                
            if (!$productoEnCarrito) {
                return response()->json(['message' => 'Producto no encontrado en el carrito'], 404);
            }

            //Actualizar la cantidad
            DB::table('productos__carrito')
                ->where('id', $productoEnCarrito->id)
                ->update(['cantidad' => $request->cantidad]);

            //Obtener el producto actualizado
            $productoActualizado = DB::table('productos__carrito')
                ->where('id', $productoEnCarrito->id)
                ->first();

            //Devolver respuesta exitosa
            return response()->json([
                'mensaje' => 'Cantidad actualizada correctamente',
                'carrito_producto' => $productoActualizado
            ]);
        } catch (\Exception $e) {
            //Manejar errores
            return response()->json([
                'error' => 'Error al actualizar la cantidad del producto: ' . $e->getMessage()
            ], 500);
        }
    }
}

