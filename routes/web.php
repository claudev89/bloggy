<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [CategoryController::class, 'index']);

Route::resource('posts', PostController::class);
Route::resource('tags', TagController::class)->except(['index', 'show']);
Route::resource('categories', CategoryController::class);
Route::resource('contacto', ContactoController::class)->only(['index', 'store', 'enviar-formulario']);
Route::resource('users', UserController::class);
Route::get('/confirmar-suscripcion/{token}', [SuscripcionController::class, 'confirmSuscription']);
Route::get('notification/{notification}/{postId}', [NotificationController::class, 'show'])->name('notifications.show')->middleware(['auth', 'check.notification']);
Route::delete('comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');

Route::view('/admin/posts', 'admin.posts');
Route::view('/admin/posts/create', 'admin.posts-create')->name('admin.posts.create');

Route::post('/upload', [HomeController::class, 'upload'])
    ->name('summernote.upload');

Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tag.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
