<?php

namespace TPG\Translator;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TPG\Translator\Commands\CacheCommand;
use TPG\Translator\Commands\InstallCommand;
use TPG\Translator\Models\PirateTranslation;
use TPG\Translator\Models\PirateTranslationPage;
use TPG\Translator\Observers\TranslationObserver;
use TPG\Translator\Observers\TranslationPageObserver;

class TranslatorSeviceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('PirateTranslator', PirateTranslatorFacade::class);

        $this->app->singleton(PirateTranslator::class, function () {
            return new PirateTranslator();
        });
        $this->registerCommands();
        $this->configurePublishing();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(realpath(__DIR__.'/../lang/'), 'pirates');

        PirateTranslation::observe(TranslationObserver::class);
        PirateTranslationPage::observe(TranslationPageObserver::class);
    }

    /**
     * Register the console commands for the package.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                CacheCommand::class,
            ]);
        }
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('piratetranslator.php'),
            ], 'config');
            
            // Publishing the migrations files.
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');
            
            // Publishing the seeders files.
            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'seeders');

            // Publishing the translation files.
            if(file_exists(__DIR__.'/../lang')){
                $this->publishes([
                    __DIR__.'/../lang' => lang_path(),
                ], 'lang');
            }
            else{
                $this->publishes([
                    __DIR__.'/../lang' => resource_path('lang'),
                ], 'lang');
            }
        }
    }
}
