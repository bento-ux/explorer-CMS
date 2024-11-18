<?php

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
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\TokenUmumController; 
use App\Http\Controllers\TokenProgramController; 

// Route::get('/', function () {
//     return view('welcome');
// });

Route::fallback(function () {
 return "Maaf, alamat tidak ditemukan";
});

Route::domain('{subdomain}.techoke')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/token-umum',[TokenUmumController::class, 'listTokenUmum'])->name('token-umum')->name('token-umum');

    Route::get('/token-umum/{tokenName}',[TokenUmumController::class, 'detailTokenUmum'])->name('token-umum-detail');
    
    Route::get('/token-umum/tx/{txhash}',[TokenUmumController::class, 'detailCampaign'])->name('token.detailCampaign');

    Route::get('/token-program',[TokenProgramController::class, 'listTokenProgram'])->name('token-program')->name('token-program');

    Route::get('/token-program/{program}',[TokenProgramController::class, 'detailTokenProgram']);

    Route::get('/token-program/distribusi/tx/{txhash}',[TokenProgramController::class, 'distribusiToken']);

});

