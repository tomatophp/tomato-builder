<?php

namespace TomatoPHP\TomatoBuilder;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoAdmin\Facade\TomatoMenu;
use TomatoPHP\TomatoAdmin\Services\Contracts\Menu;
use TomatoPHP\TomatoBuilder\Views\Digram;


class TomatoBuilderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\TomatoBuilder\Console\TomatoBuilderInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-builder.php', 'tomato-builder');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/tomato-builder.php' => config_path('tomato-builder.php'),
        ], 'tomato-builder-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'tomato-builder-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-builder');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-builder'),
        ], 'tomato-builder-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tomato-builder');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/tomato-builder'),
        ], 'tomato-builder-lang');

        //Publish Stubs
        $this->publishes([
            __DIR__.'/stubs' => base_path('stubs/vendor/tomato-builder'),
        ], 'tomato-builder-stubs');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    }

    public function boot(): void
    {
       $this->loadViewComponentsAs('tomato', [
           Digram::class
       ]);

        TomatoMenu::register([
            Menu::make()
                ->group(__('Tools'))
                ->label(__('Builder'))
                ->route("admin.builder.index")
                ->icon("bx bx-square")
        ]);
    }
}
