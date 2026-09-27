<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/categories', [PageController::class, 'categories'])->name('categories.index');
Route::get('/category/{category:slug}', [PageController::class, 'byCategory'])->name('category.show');
Route::get('/city/{city}', [PageController::class, 'byCity'])->name('city.show');
Route::get('/city/{city}/category/{category:slug}', [PageController::class, 'byCityAndCategory'])->name('city.category.show');
Route::get('/ajax/categories/{category}/subcategories', [PageController::class, 'subcategoriesOf'])->name('ajax.subcategories');
Route::get('/ajax/search-suggestions', [PageController::class, 'searchSuggestions'])->name('ajax.suggestions');

Route::get('/listing/{listing}', [ListingController::class, 'show'])->name('listings.show');

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated routes: posting & managing listings
Route::middleware('auth')->group(function () {
    Route::get('/my-listings', [ListingController::class, 'my'])->name('listings.my');
    Route::get('/post-ad', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/post-ad', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listing/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
});

// Storage fallback route for uploaded files (handles missing symlink on production platforms)
Route::get('/storage/{path}', function (string $path) {
    $filePath = storage_path('app/public/'.$path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*')->name('storage.local');

