<?php

namespace TPC\Translator\Observers;

use TPC\Translator\Models\PirateTranslation;

class TranslationObserver
{
    /**
     * Handle the PirateTranslation "created" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function created(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }

    /**
     * Handle the PirateTranslation "save" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function saved(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }

    /**
     * Handle the PirateTranslation "updated" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function updated(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }

    /**
     * Handle the PirateTranslation "deleted" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function deleted(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }

    /**
     * Handle the PirateTranslation "restored" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function restored(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }

    /**
     * Handle the PirateTranslation "force deleted" event.
     *
     * @param  \App\Models\PirateTranslation  $pirateTranslations
     * @return void
     */
    public function forceDeleted(PirateTranslation $pirateTranslations)
    {
        \PirateTranslator::updateTableCache($pirateTranslations->locale, $pirateTranslations->table_name);
    }
}
