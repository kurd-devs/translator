<?php

namespace TPG\Translator\Observers;

use TPG\Translator\Models\PirateTranslationPage;

class TranslationPageObserver
{
    /**
     * Handle the PirateTranslation "created" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function created(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }

    /**
     * Handle the PirateTranslation "save" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function saved(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }

    /**
     * Handle the PirateTranslation "updated" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function updated(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }

    /**
     * Handle the PirateTranslation "deleted" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function deleted(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }

    /**
     * Handle the PirateTranslation "restored" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function restored(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }

    /**
     * Handle the PirateTranslation "force deleted" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslationPage
     * @return void
     */
    public function forceDeleted(PirateTranslationPage $pirateTranslationPage)
    {
        \PirateTranslator::updatePageCache($pirateTranslationPage->route_name);
    }
}
