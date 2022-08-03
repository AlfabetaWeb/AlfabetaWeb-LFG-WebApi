<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/// ELIMINATE THIS THREE LINES, WE WILL NOT USE THEM
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//GENERAL ACCESS USER
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(["middleware" => "jwt.auth"] , function() {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']); 
});

//ASIGN SUPERADMIN ROLE TO USER
Route::group(["middleware" => ["jwt.auth", "isSuperAdmin"]] , function() {    
    Route::post('/user/super_admin/{id}', [UserController::class, 'addSuperAdmminRoleToUser']);
    Route::post('/user/remove_super_admin/{id}', [UserController::class, 'removeSuperAdmminRoleToUser']);
});

// GAMES
Route::group(["middleware" => "jwt.auth"] , function() {
    Route::post('/game', [GameController::class, 'createGame']);
    Route::get('/games', [GameController::class, 'getAllGames']); 
  
});

////


Route::get('/tasks/{id}', [TaskController::class, 'getTaskById']);
Route::put('/tasks/{id}', [TaskController::class, 'updateTask']);
Route::get('/user/task/{id}', [TaskController::class, 'getUserByIdTask']);