<?php

use App\Http\Controllers\AudienceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/audience', [AudienceController::class, 'index']);
Route::get('/generate-token', [AudienceController::class, 'createToken']);

Route::post('/audience/add', [AudienceController::class, 'store']);
Route::get('/audience/{id}', [AudienceController::class, 'show']);

Route::patch('/audience/update/{id}', [AudienceController::class, 'update']);
Route::delete('/audience/delete/{id}', [AudienceController::class, 'destroy']);

Route::get('/audience/show/trash', [AudienceController::class, 'trash']);
Route::get('/audience/trash/restore/{id}', [AudienceController::class, 'restore']);
Route::get('/audience/trash/delete/forever/{id}', [AudienceController::class, 'delete']);