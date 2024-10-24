<?php

use ChinLeung\MultilingualRoutes\DetectRequestLocale;
use Hearth\Tests\Fixtures\TranslatableModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    config(['locales.supported' => [
        'en', 'fr',
    ]]);
});

test('trans current route uses translated slug', function () {
    $translatable = new TranslatableModel;

    $translatable->setTranslation('name', 'en', 'The Fellowship of the Ring');
    $translatable->setTranslation('name', 'fr', 'La communauté de l’anneau');

    $translatable->save();

    Route::multilingual(
        '/translatables/{translatable}',
        function (TranslatableModel $translatable) {
            return $translatable->name;
        }
    )
        ->middleware(DetectRequestLocale::class)
        ->name('translatables.show');

    Route::dispatch(Request::create(localized_route('translatables.show', $translatable)));

    expect(trans_current_route('fr'))->toEqual(localized_route('translatables.show', $translatable, 'fr'));
});
