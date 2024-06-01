<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CategoryController;


// public routes
Route::get('/', function () {
    return redirect()->route('topics.index');
});

// protected routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::put('topics/toggle-like/{topic}', [TopicController::class, 'toggleLike'])->name('topics.toggle-like');
    Route::resource('topics', TopicController::class);
    Route::resource('categories', CategoryController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
