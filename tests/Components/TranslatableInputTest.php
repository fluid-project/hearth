<?php

uses(\Hearth\Tests\TestCase::class);
use Illuminate\Support\Facades\App;

test('translatable input component render in english', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-translatable-input :name="$name" :label="$label" :locales="$locales" :model="$model"> </x-hearth-translatable-input>',
            [
                'name' => 'resource',
                'label' => 'test resource',
                'locales' => ['en', 'fr'],
                'model' => null,
            ],
        );

    $view->assertSee('for="resource_en"', false);
    $view->assertSee('name="resource[en]"', false);
    $view->assertSee('id="resource_en"', false);
    $view->assertSee('id="test-resource-french"', false);
    $view->assertSee('id="resource.en-error', false);
    $view->assertSeeText('test resource (English)', false);
    $view->assertSeeText('test resource (French)', false);
});

test('translatable input component render in french', function () {
    App::setLocale('fr');
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-translatable-input :name="$name" :label="$label" :locales="$locales" :model="$model"> </x-hearth-translatable-input>',
            [
                'name' => 'resource',
                'label' => 'test resource',
                'locales' => ['en', 'fr'],
                'model' => null,
            ],
        );
    $view->assertSee('for="resource_fr"', false);
    $view->assertSee('name="resource[fr]"', false);
    $view->assertSee('id="resource_fr"', false);
    $view->assertSee('id="test-resource-english"', false);
    $view->assertSee('id="resource.fr-error', false);
    $view->assertSeeText('test resource (French)', false);
    $view->assertSeeText('test resource (English)', false);
});
