<?php

namespace TPC\Translator;

use Illuminate\Support\Facades\Facade;

class PirateTranslatorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PirateTranslator::class;
    }
}