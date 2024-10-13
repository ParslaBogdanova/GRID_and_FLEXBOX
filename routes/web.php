<?php
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('playlist', PlaylistController::class);
Route::post('playlist/{playlist}/addSong',[PlaylistController::class, 'addSong'])->name('playlist.addSong');
Route::delete('playlist/{playlist}/removeSong',[PlaylistController::class, 'removeSong'])->name('playlist.removeSong');
Route::resource('song', SongController::class);
Route::post('song/{song}/addPlaylist', [SongController::class, 'addPlaylist'])->name('song.addPlaylist');
Route::delete('song/{song}/removePlaylist', [SongController::class, 'removePlaylist'])->name('song.removePlaylist');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';