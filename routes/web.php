<?php

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

Route::get('/', function(){
    return redirect()->route('posts.index');
});

Route::get('/404NotFound', function(){
    return 'HALAMAN TIDAK DITEMUKAN!';
})->name('404');

Route::fallback(function(){
    return redirect()->route('404');
});

Route::resource('/posts', \App\Http\Controllers\PostController::class);