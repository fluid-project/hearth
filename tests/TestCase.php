<?php

namespace Hearth\Tests;

use ChinLeung\LaravelLocales\LaravelLocalesServiceProvider;
use ChinLeung\MultilingualRoutes\MultilingualRoutesServiceProvider;
use Hearth\HearthServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\FortifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Hearth\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            FortifyServiceProvider::class,
            HearthServiceProvider::class,
            LaravelLocalesServiceProvider::class,
            MultilingualRoutesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        Schema::create('translatable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->json('name')->nullable();
            $table->json('slug')->nullable();
        });

        $create_users_table = include __DIR__.'/../database/migrations/create_users_table.php.stub';
        $update_users_table = include __DIR__.'/../database/migrations/update_users_table.php.stub';
        $create_invitations_table = include __DIR__.'/../database/migrations/2021_03_01_000000_create_invitations_table.php';
        $add_joinable_columns = include __DIR__.'/../database/migrations/2021_03_01_000000_add_joinable_columns_to_users_table.php';
        $create_memberships_table = include __DIR__.'/../database/migrations/2021_03_01_000000_create_memberships_table.php';
        $create_organizations_table = include __DIR__.'/../database/migrations/create_organizations_table.php.stub';

        $create_users_table->up();
        $update_users_table->up();
        $add_joinable_columns->up();
        $create_invitations_table->up();
        $create_memberships_table->up();
        $create_organizations_table->up();
    }
}
