<?php

use App\Http\Controllers\RaceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return redirect('race');
});
Route::get('/add-results/{race}', [RaceController::class, 'add'])->name('race.add');
Route::post('/add-csv', [RaceController::class, 'csv'])->name('race.csv');

Route::resource('race', RaceController::class);