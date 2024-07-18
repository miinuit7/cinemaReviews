<?php

use App\Http\Controllers\PopularController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchContoller;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

use Illuminate\Support\Facades\Route;

Route::get('/', [PopularController::class, 'index'])->name('index');


Route::get('/detail/{id}', [PostController::class, 'showMovieDetails'])->name('detail.show');
Route::post('/detail/review/store',[ReviewController::class, 'store'])->name('review.store');

Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');

Route::middleware('auth')->group(function () {
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

Route::get('/search', [SearchContoller::class, 'search'])->name('search');


Route::get('dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
