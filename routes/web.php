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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard']);
Route::get('/spatie', [App\Http\Controllers\HomeController::class, 'spatie']);
Route::get('/transactionDetails', [App\Http\Controllers\TransactionDetailController::class, 'index']);
Route::get('/admins', [App\Http\Controllers\AdminController::class, 'dashboard']);


Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);
Route::resource('/publishers', App\Http\Controllers\PublisherController::class);
Route::resource('/authors', App\Http\Controllers\AuthorController::class);
Route::resource('/members', App\Http\Controllers\MemberController::class);
Route::resource('/books', App\Http\Controllers\BookController::class);
Route::resource('/details', App\Http\Controllers\TransactionDetailController::class);

Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index']);
Route::get('/transactions/create', [App\Http\Controllers\TransactionController::class, 'create']);
Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/transactions/{id}/edit', [App\Http\Controllers\TransactionController::class, 'edit']);
Route::put('/transactions/{id}', [App\Http\Controllers\TransactionController::class, 'update']);
Route::get('/transactions/{id}', [App\Http\Controllers\TransactionController::class, 'show']);
Route::delete('/transactions/{id}', [App\Http\Controllers\TransactionController::class, 'destroy']);

Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/details', [App\Http\Controllers\TransactionDetailController::class, 'api']);

