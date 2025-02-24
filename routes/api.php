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

//CRUD Usuario
Route::resource("usuario", UsuarioController::class)->middleware('auth:sanctum');
//CRUD Produtos
Route::resource("producto", ProductosController::class);
//CRUD Categorias
Route::resource("categoria", CategoriasController::class);
//Crud articulo
Route::resource("articulo", ArticulosController::class)->middleware('auth:sanctum');
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');