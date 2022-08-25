<?php

namespace TPC\Translator\Models;

use Illuminate\Database\Eloquent\Model;
use TPC\Translator\Observers\TranslationObserver;

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