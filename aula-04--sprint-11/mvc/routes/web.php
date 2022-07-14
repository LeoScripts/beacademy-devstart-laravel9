<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ViaCepController,
    UserController,
    PostController
};

require __DIR__.'/auth.php';

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {

    Route::get('/posts',[PostController::class, 'index'])->name('posts.index');
    Route::get('/users/{id}/posts', [PostController::class, 'show'])->name('posts.show');

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
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [UserController::class, 'admin'])->name('admin');
});
