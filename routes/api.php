<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Authentification

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::post('/store', [UserController::class, 'store']);

Route::post('/store', [UserController::class, 'userStore']);
// Route::put('/update/{id}', [UserController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update/{id}', [UserController::class, 'userUpdate']);
});


Route::middleware('auth:sanctum')->group(function () {
Route::delete('/destroy', [UserController::class, 'UserDestroy']);
    // Route::apiResource('users', UserController::class);
    Route::post('/logout', [AuthController::class, 'userLogout']);
});



//contact

//Route::apiResource('contacts', ContactController::class);
Route::post('/contactStore', [ContactController::class, 'contactStore']);
Route::post('/contactIndex', [ContactController::class, 'contactIndex']);
Route::delete('/contactDestroy/{id}', [ContactController::class, 'contactDestroy']);
Route::post('/contactUpdate/{id}', [ContactController::class, 'contactUpdate']);

// route pour API Etudiant
Route::post('/etudiantStore', [EtudiantController::class, 'etudiantStore']);
