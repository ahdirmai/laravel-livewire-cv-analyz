<?php

use App\Models\Cv;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('/', 'welcome')->name('dashboard');


Route::view('generate-history', 'pages.generate-history')
    ->middleware(['auth'])
    ->name('generate-history.index');

Route::view('generate-history/{uuid}', 'pages.generate-history.show')
    ->middleware(['auth'])
    ->name('generate-history.show');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('download-file/{id}', function ($id) {
    $cv = Cv::findOrFail($id);
    return Storage::download($cv->path);
})->name('download.file');

// Route::get('show-file/{id}', function ($id) {
//     $cv = Cv::findOrFail($id);
//     return Storage::download($cv->path);
// })->name('show.file');

require __DIR__ . '/auth.php';
