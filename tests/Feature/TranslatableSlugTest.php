<?php

namespace Hearth\Tests\Feature;

use ChinLeung\LaravelLocales\LaravelLocalesServiceProvider;
use ChinLeung\MultilingualRoutes\DetectRequestLocale;
use ChinLeung\MultilingualRoutes\MultilingualRoutesServiceProvider;
use Closure;
use Hearth\Tests\Fixtures\TranslatableModel;
use Hearth\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class TranslatableSlugTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['locales.supported' => [
            'en', 'fr',
        ]]);
    }

    protected function setUpDatabaseRequirements(Closure $callback): void
    {
        Schema::dropAllTables();

        Schema::create('translatable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->json('name')->nullable();
            $table->json('slug')->nullable();
        });
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelLocalesServiceProvider::class,
            MultilingualRoutesServiceProvider::class,
        ];
    }

    public function test_trans_current_route_uses_translated_slug()
    {
        $translatable = new TranslatableModel();

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

        $response = $this->get('/translatables/the-fellowship-of-the-ring');
        $response->assertOk();

        $response = $this->get('/fr/translatables/la-communaute-de-lanneau');
        $response->assertOk();
    }
}
