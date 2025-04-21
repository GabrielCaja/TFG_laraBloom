<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsuarioController;
use App\Http\Controllers\api\ProductosController;
use App\Http\Controllers\api\CategoriasController;
use App\Http\Controllers\api\ArticulosController;
use App\Http\Controllers\api\ValoracionesController;
use App\Http\Controllers\api\ComentariosController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\CarritoController;
use App\Http\Controllers\api\OrdersController;
use App\Http\Controllers\api\ProductoOrderController;

//CRUD Usuario
// Rutas para el perfil del usuario
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuario/perfil', [UsuarioController::class, 'perfil']);
    Route::put('/usuario/perfil', [UsuarioController::class, 'actualizarPerfil']);
});
Route::resource("usuario", UsuarioController::class)->middleware('auth:sanctum');

//CRUD Produtos
Route::resource("producto", ProductosController::class);
//CRUD Categorias
Route::resource("categoria", CategoriasController::class);
//Crud articulo
Route::resource("articulo", ArticulosController::class);
//Crud carrito
Route::middleware('auth:sanctum')->get('/carrito/mi-carrito', [CarritoController::class, 'miCarrito']);
Route::delete('carrito/producto/{productoId}', [CarritoController::class, 'eliminarProducto'])->middleware('auth:sanctum');Route::delete('carrito/producto/{productoId}', [CarritoController::class, 'eliminarProducto'])->middleware('auth:sanctum');
Route::delete('carrito/vaciar', [CarritoController::class, 'vaciarCarrito'])->middleware('auth:sanctum');
Route::put('/carrito/actualizar', [CarritoController::class, 'actualizarProducto'])->middleware('auth:sanctum');

Route::resource("carrito", CarritoController::class)->middleware('auth:sanctum');
//Crud Valoraciones
Route::resource("valoracion", ValoracionesController::class);
//Crud ComentariosBlog
Route::resource("comentario", ComentariosController::class);
// //Crud Articulos
// Route::resource("usuario", UsuarioController::class);
// //Crud CoementariosBlog
// Route::resource("usuario", UsuarioController::class);

//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/metrics', [DashboardController::class, 'getMetrics'])->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');