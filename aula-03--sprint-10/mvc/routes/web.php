<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ViaCepController,
    UserController,
    PostController
};

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/posts',[PostController::class, 'index'])->name('posts.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/user', [UserController::class, 'store'])->name('users.store');
// importante resaltar que se colocarmos a rota  com paramentro antes das demais
// quando tentarmos acessar uma rota apos o barra o laravel vai entender como um paramentro
// e vai direcionar pra neste caso /users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::get('/viacep',[ViaCepController::class,'index'])->name('viacep.index');
Route::post('/viacep',[ViaCepController::class,'index'])->name('viacep.index.post');
Route::get('/viacep/{cep}',[ViaCepController::class,'show'])->name('viacep.show');
