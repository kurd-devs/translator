<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslatorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PagesTableSeeder::class,
        ]);
    }
}
