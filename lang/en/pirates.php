<?php


$tables = cache()->rememberForever('pirates_translation_page_'.request()->route()->getName(), function ()
{
    $data = PirateTranslator::cachePage('en', request()->route()->getName());
    
    return $data;
});

$translation_data = [];

if(isset($tables) && count($tables) > 0){
    foreach($tables as $table){
        $translation_data[$table] = PirateTranslator::cacheTable('en', $table);
    }
}
else{
    $translation_data = PirateTranslator::cacheAll('en');
}

return $translation_data;