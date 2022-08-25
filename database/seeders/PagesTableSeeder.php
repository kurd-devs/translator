<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TPG\Translator\Models\PirateTranslationPage;

class PagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        //Content
        $post = $this->findPage('home');
        if (!$post->exists) {
            $post->fill([
                'title'            => 'Home Page',
                'route_name'          => 'home',
                'table_names'             => '["user"]',
            ])->save();
        }
    }

    /**
     * [page description].
     *
     * @param [type] $route_name [description]
     *
     * @return [type] [description]
     */
    protected function findPage($route_name)
    {
        return PirateTranslationPage::firstOrNew(['route_name' => $route_name]);
    }
}
