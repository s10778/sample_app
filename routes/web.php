<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NiceController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\MyCommentController;
use App\Http\Controllers\MyNiceController;
use App\Http\Controllers\ShowContactController;
use App\Http\Controllers\ReadController;



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
})->name('top');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('post/mypost', [MyPostController::class, 'index'])->name('mypost.index');

Route::get('post/mycomment', [MyCommentController::class, 'index'])->name('mycomment.index');

Route::get('post/mynice', [MyNiceController::class, 'index'])->name('mynice.index');

Route::resource('post',PostController::class);

Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');

Route::get('nice/{post}', [NiceController::class, 'nice'])->name('nice');
Route::get('unnice/{post}', [NiceController::class, 'unnice'])->name('unnice');

Route::get('contact/create', [ContactController::class,'create'])->name('contact.create')->middleware('guest');
Route::post('contact/store', [ContactController::class,'store'])->name('contact.store');

Route::get('profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

Route::patch('roles/{user}/attach', [RoleController::class, 'attach'])->name('role.attach');
Route::patch('roles/{user}/detach', [RoleController::class, 'detach'])->name('role.detach');

Route::middleware(['can:admin'])->group(function() {
    Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::delete('profile/{user}', [ProfileController::class, 'delete'])->name('profile.delete');

    Route::get('showContact/index', [ShowContactController::class, 'index'])->name('showContact.index');
    Route::get('showContact/{contact}', [ShowContactController::class, 'show'])->name('showContact.show');
    Route::delete('showContact/{contact}', [ShowContactController::class, 'destroy'])->name('showContact.delete');
});
