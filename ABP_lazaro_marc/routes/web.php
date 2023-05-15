<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursController;
use App\Http\Controllers\CicleController;
use App\Http\Controllers\ModulController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::resource('cicles', CicleController::class);
Route::resource('cursos', CursController::class);
Route::resource('modul', ModulController::class);
