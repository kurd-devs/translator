<?php

namespace TPG\Translator\Traits;

use Illuminate\Support\Facades\Validator;

trait DataTrait
{

    public function addLanguage(string $locale)
    {
        try {
            $locale = $this->clean($locale);
            if (!empty($locale)) {
                set_time_limit(0);
                $dir = lang_path($locale);

                if (is_dir($dir) === false) {
                    mkdir($dir, 0755, true);
                }

                if (file_exists(__DIR__ . '/../../lang/pirates.php')) {
                    $newlocale = $dir . "/pirates.php";
                    $defaultlocale = __DIR__ . '/../../lang/pirates.php';

                    $str = file_get_contents($defaultlocale);

                    if ($str !== false) {
                        $str = str_replace('en', $locale, $str);

                        file_put_contents($newlocale, $str);
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    public function addTranslation(array $data)
    {
        $validator = Validator::make($data, [
            'table_name' => 'required|string|max:255',
            'column_name' => 'required|string|max:255',
            'phrase_key' => 'required|string|max:255',
            'locale' => 'required|string|regex:/^[a-zA-Z0-9\-]+$/',
            'value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) return false;

        $conditions = \Arr::except($data, ['value']);
        $newRecord = \TPG\Translator\Models\PirateTranslation::firstOrNew($conditions, $data);
        if ($newRecord->exists) {
            return false;
        } else {
            return $newRecord->save();
        }
    }

    public function updateTranslation(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|exists:pirate_translations,id',
            'table_name' => 'string|max:255',
            'column_name' => 'string|max:255',
            'phrase_key' => 'string|max:255',
            'locale' => 'string|regex:/^[a-zA-Z0-9\-]+$/',
            'value' => 'string|max:255',
        ]);

        if ($validator->fails()) return false;
        $updatedRecord = \TPG\Translator\Models\PirateTranslation::where('id', $data['id'])->update($data);
        if($updatedRecord){
            \PirateTranslator::updateTableCache($data['locale'], $data['table_name']);
        }
        return $updatedRecord;
    }

    public function blukInsert(array $data, $validation = true)
    {
        if ($validation) {
            $validator = Validator::make($data, [
                '*.table_name' => 'required|string|max:255',
                '*.column_name' => 'required|string|max:255',
                '*.phrase_key' => 'required|string|max:255',
                '*.locale' => 'required|string|regex:/^[a-zA-Z0-9\-]+$/',
                '*.value' => 'required|string|max:255',
            ]);

            if ($validator->fails()) return false;
        }
        $newRecord = \TPG\Translator\Models\PirateTranslation::insertOrIgnore($data);
        if($newRecord){
            $tables = collect($data)->unique(['locale', 'table_name'])->pluck('table_name', 'locale');
            // dd($data, $tables);
            foreach ($tables as $locale  => $table){
                \PirateTranslator::updateTableCache($locale, $table);
            }
        }
        return $newRecord;
    }

    private function clean(string $string)
    {
        $string = str_replace([' ', 'function'], '', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
