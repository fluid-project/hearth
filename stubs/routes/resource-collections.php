<?php

use App\Http\Controllers\ResourceCollectionController;
use Illuminate\Support\Facades\Route;

Route::multilingual('/resource-collections', [ResourceCollectionController::class, 'index'])
    ->name('resource-collections.index');

Route::multilingual('/resource-collections/create', [ResourceCollectionController::class, 'create'])
    ->middleware(['auth', 'can:create,App\Models\ResourceCollection'])
    ->name('resource-collections.create');

Route::multilingual('/resource-collections/create', [ResourceCollectionController::class, 'store'])
    ->method('post')
    ->middleware(['auth', 'can:create,App\Models\ResourceCollection'])
    ->name('resource-collections.store');

Route::multilingual('/resource-collections/{resourceCollection}', [ResourceCollectionController::class, 'show'])
    ->name('resource-collections.show');

Route::multilingual('/resource-collections/{resourceCollection}/edit', [ResourceCollectionController::class, 'edit'])
    ->middleware(['auth', 'can:update,resourceCollection'])
    ->name('resource-collections.edit');

Route::multilingual('/resource-collections/{resourceCollection}/edit', [ResourceCollectionController::class, 'update'])
    ->middleware(['auth', 'can:update,resourceCollection'])
    ->method('put')
    ->name('resource-collections.update');

Route::multilingual('/resource-collections/{resourceCollection}/delete', [ResourceCollectionController::class, 'destroy'])
    ->middleware(['auth', 'can:delete,resourceCollection'])
    ->method('delete')
    ->name('resource-collections.destroy');
