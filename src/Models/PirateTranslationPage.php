<?php

namespace TPG\Translator\Models;

use Illuminate\Database\Eloquent\Model;

class PirateTranslationPage extends Model
{

    protected $fillable = [
        'title',
        'route_name',
        'table_names'
    ];
    
}