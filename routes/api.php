<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    UsuarioController,
    ProductosController,
    CategoriasController,
    ArticulosController,
    ValoracionesController,
    ComentariosController,
    AuthController,
    DashboardController,
    CarritoController,
    OrdersController,
    ProductoOrderController,
    ContactoController,
    PaymentController
};

// RUTAS DE AUTENTICACIÓN
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// RUTAS PÚBLICAS
Route::resource('producto', ProductosController::class);
Route::resource('categoria', CategoriasController::class);
Route::resource('articulo', ArticulosController::class);
Route::resource('valoracion', ValoracionesController::class);
Route::resource('comentario', ComentariosController::class);
Route::post('/contacto', [ContactoController::class, 'store']);


// Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index']);


// RUTAS PROTEGIDAS (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('valoraciones', ValoracionesController::class);

    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Perfil de usuario
    Route::get('/usuario/perfil', [UsuarioController::class, 'perfil']);
    Route::put('/usuario/perfil', [UsuarioController::class, 'actualizarPerfil']);
    Route::resource('usuario', UsuarioController::class);
    
    // Carrito
    Route::prefix('carrito')->group(function () {
        Route::get('/mi-carrito', [CarritoController::class, 'miCarrito']);
        Route::delete('/producto/{productoId}', [CarritoController::class, 'eliminarProducto']);
        Route::delete('/vaciar', [CarritoController::class, 'vaciarCarrito']);
        Route::put('/actualizar', [CarritoController::class, 'actualizarProducto']);
    });
    Route::resource('carrito', CarritoController::class);
    
    // Pedidos
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/pedidos/mis-pedidos', [OrdersController::class, 'misPedidos']);
        Route::get('/pedidos/{id}', [OrdersController::class, 'verPedido']);;
    });
    
    // Pagos
    Route::prefix('payment')->group(function () {
        Route::post('/create-intent', [PaymentController::class, 'createPaymentIntent']);
        Route::post('/confirm', [PaymentController::class, 'confirmPayment']);
    });
    
    // Contacto (gestión admin)
    Route::resource('contacto', ContactoController::class)->except(['store']);
    
    // Dashboard con métricas
    Route::get('/metrics', [DashboardController::class, 'getMetrics']);
});