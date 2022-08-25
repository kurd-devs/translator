<?php

namespace TPG\Translator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use TPG\Translator\TranslatorSeviceProvider;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'piratetranslator:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Pirates translator package';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * Seed Folder name.
     *
     * @var string
     */
    protected $seedFolder;

    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
        ];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing the Pirates Translator Models, database, and config files');

        // Publish only relevant resources on install
        $tags = ['seeders', 'config', 'lang'];

        $this->call('vendor:publish', ['--provider' => TranslatorSeviceProvider::class, '--tag' => $tags]);


        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);

        // $this->info('Adding Voyager routes to routes/web.php');
        // $routes_contents = $filesystem->get(base_path('routes/web.php'));
        // if (false === strpos($routes_contents, 'Voyager::routes()')) {
        //     $filesystem->append(
        //         base_path('routes/web.php'),
        //         PHP_EOL.PHP_EOL."Route::group(['prefix' => 'admin'], function () {".PHP_EOL."    Voyager::routes();".PHP_EOL."});".PHP_EOL
        //     );
        // }

        $this->info('Dumping the autoloaded files and reloading all new files');
        $this->composer->dumpAutoloads();
        require_once base_path('vendor/autoload.php');

        $this->info('Seeding data into the database');
        $this->call('db:seed', ['--class' => 'TranslatorDatabaseSeeder']);

        $this->info('Successfully installed Pirates Translator! Enjoy');
    }
}
