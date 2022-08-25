<?php

namespace TPC\Translator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use TPC\Translator\Models\PirateTranslation;

class CacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'piratetranslator:cache {locale?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the Pirates translator package cache';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        try{
            $locale = $this->argument('locale');
            if(isset($locale)){
                \PirateTranslator::updateDateCache($locale);
            }
            else{
                $locales = PirateTranslation::select('locale')->distinct()->pluck('locale');
                foreach($locales as $locale){
                    \PirateTranslator::updateDataCache($locale);
                    $this->line('Successfuly updated Translation Cache for locale ' . $locale );
                }
            }
            $this->info('The Translation Cache has been updated successfuly!');
        }
        catch(\Exception $e){
            $this->error('Something went wrong!: '.$e->getMessage());
        }
    }
}
