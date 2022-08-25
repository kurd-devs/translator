<?php

namespace TPG\Translator\Models;

use Illuminate\Database\Eloquent\Model;
use TPG\Translator\Observers\TranslationObserver;

class PirateTranslation extends Model
{

    protected $fillable = [
        'table_name',
        'column_name',
        'phrase_key',
        'locale',
        'value'
    ];
}