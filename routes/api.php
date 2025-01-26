<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsuarioController;


//CRUD Usuario
Route::resource("usuario", UsuarioController::class);
// //CRUD Produtos
// Route::resource("usuario", UsuarioController::class);
// //CRUD Categorias
// Route::resource("usuario", UsuarioController::class);
// //Crud Carrito
// Route::resource("usuario", UsuarioController::class);
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
