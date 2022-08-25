<?php

namespace TPC\Translator\Traits;

trait CacheTrait
{

    public function cachePage(string $route_name)
    {
        return cache()->rememberForever("pirates_translation_page_{$route_name}", function () use($route_name) {
            $data = json_decode(\TPC\Translator\Models\PirateTranslationPage::where('route_name', $route_name)->first()->table_names);
            return $data;
        });
    }

    public function cacheTable(string $locale, string $table_name)
    {
        return cache()->rememberForever("{$table_name}_{$locale}", function () use ($table_name) {
            $data = \TPC\Translator\Models\PirateTranslation::select(['column_name', 'phrase_key', 'value'])
                ->where('locale', 'en')
                ->where('table_name', $table_name)
                ->get()
                ->groupBy('phrase_key')
                ->map(function ($row) {
                    return $row->keyBy('column_name')->map(function ($row) {
                        return $row->value;
                    });
                });
            return $data->toArray();
        });
    }

    public function cacheAll(string $locale)
    {
        return cache()->rememberForever("data_$locale", function () {
            $data = \TPC\Translator\Models\PirateTranslation::select(['table_name', 'column_name', 'phrase_key', 'value'])
                ->where('locale', 'en')
                ->get()
                ->groupBy('table_name')
                ->map(function ($row) {
                    return $row->groupBy('phrase_key')
                        ->map(function ($row) {
                            return $row->keyBy('column_name')->map(function ($row) {
                                return $row->value;
                            });
                        });
                });
                
            return $data->toArray();
        });
    }

    public function updatePageCache(string $route_name)
    {
        cache()->forget("pirates_translation_page_{$route_name}");
        $this->cachePage($route_name);
    }

    public function updateTableCache(string $locale, string $table_name)
    {
        cache()->forget("data_$locale");
        $this->cacheAll($locale);
        cache()->forget("{$table_name}_{$locale}");
        $this->cacheTable($locale, $table_name);
    }

    public function updateDataCache(string $locale)
    {
        cache()->forget("data_$locale");
        $this->cacheAll($locale);
    }
}
