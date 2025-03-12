<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('posts', [PostController::class, "index"]); // Recuperer tous les postes
Route::post('posts/create', [PostController::class, "store"]); // Creer un nouveau poste
Route::put('posts/edit/{post}', [PostController::class, 'update']); // Modifier un poste
Route::delete('posts/{post}', [PostController::class, 'destroy']); // Supprimer un poste

