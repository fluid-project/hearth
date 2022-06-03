<?php

use App\Http\Controllers\JoinController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', \locale());
Route::multilingual('/', function () {
    return view('welcome');
})->name('welcome');

Route::multilingual('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified:' . \locale() . '.verification.notice'])->name('dashboard');

Route::multilingual('/account/edit', [UserController::class, 'edit'])
    ->middleware(['auth'])
    ->name('users.edit');

Route::multilingual('/account/admin', [UserController::class, 'admin'])
    ->middleware(['auth'])
    ->name('users.admin');

Route::multilingual('/account/delete', [UserController::class, 'destroy'])
    ->method('delete')
    ->middleware(['auth'])
    ->name('users.destroy');

Route::multilingual('/requests/cancel', [JoinController::class, 'cancel'])
    ->method('post')
    ->middleware(['auth'])
    ->name('requests.cancel');

Route::multilingual('/requests/{user:id}/deny', [JoinController::class, 'deny'])
    ->method('post')
    ->middleware(['auth'])
    ->name('requests.deny');

Route::multilingual('/requests/{user:id}/approve', [JoinController::class, 'approve'])
    ->method('post')
    ->middleware(['auth'])
    ->name('requests.approve');

if (config('hearth.organizations.enabled')) {
    require __DIR__ . '/organizations.php';
}

if (config('hearth.resources.enabled')) {
    require __DIR__ . '/resources.php';
    require __DIR__ . '/resource-collections.php';
}

require __DIR__ . '/fortify.php';
