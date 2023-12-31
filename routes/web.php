<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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
    return redirect(route('posts.index'));
});

Route::get('dashboard', function () {
    return redirect(route('posts.index'));
})->name('dashboard');

Route::group(['namespace'=>'\\App\\Http\\Controllers'],function(){
    Route::resource('posts', 'PostController');
    Route::get('/download/{post}', 'PostController@download')->name('post.download');
    Route::get('/download-backup', 'PostController@downloadBackup')->name('backup.download');
    Route::get('/download-backup-db', 'PostController@downloadBackupDB')->name('backup.download-db');


});




require __DIR__.'/auth.php';
