<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsuarioController;
use App\Http\Controllers\api\ProductosController;
use App\Http\Controllers\api\CategoriasController;
use App\Http\Controllers\api\ArticulosController;

//CRUD Usuario
Route::resource("usuario", UsuarioController::class);
//CRUD Produtos
Route::resource("producto", ProductosController::class);
//CRUD Categorias
Route::resource("categoria", CategoriasController::class);
//Crud Carrito
Route::resource("articulo", ArticulosController::class);
// //Crud Orders
// Route::resource("usuario", UsuarioController::class);
// //Crud Valoraciones
// Route::resource("usuario", UsuarioController::class);
// //Crud Articulos
// Route::resource("usuario", UsuarioController::class);
// //Crud CoementariosBlog
// Route::resource("usuario", UsuarioController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
