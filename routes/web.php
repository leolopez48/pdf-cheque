<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ConceptosController;

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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('pdf/{id}', [PDFController::class, 'generatePDF']);
    Route::get('download-pdf', [PDFController::class, 'downloadPDF']);

    Route::resource('api/cheque', ChequeController::class);
    Route::post('api/conceptos/cheque', [ConceptosController::class, 'getConceptosPorCheque']);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
