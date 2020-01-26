<?php

namespace App\Commands;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class Config extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'config:set
                            {--force : Force}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates configuration folder';

    protected $files;

    /**
     * Config constructor.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->makeDirectory($this->getConfigDir());

        $this->cloneStubsRepo();

        $this->generateConfigFile();
    }

    /**
     * Creates the directory if necessary.
     *
     * @param string $path
     * @return void
     */
    protected function makeDirectory(string $path)
    {
        if ($this->option('force') || !$this->files->isDirectory(dirname($path))) {

            $this->files->deleteDirectory($path);

            $this->files->makeDirectory(dirname($path), 0777, true, true);

            $this->info($this->getConfigDir() . ' directory was created successfully');

            return null;
        }

        $this->line($this->getConfigDir() . ' already exists');
    }

    /**
     * @return void
     */
    protected function cloneStubsRepo()
    {
        $path = $this->getConfigDir() . '/stubs';

        if ($this->option('force') || !$this->files->isDirectory(dirname($path))) {

            $this->info(shell_exec(
                'git clone '
                . $this->getStubsRepoUri() . ' '
                . $this->getConfigDir() . '/stubs'
            ));

            $this->info('Stubs directory was created successfully');

            return null;
        }

        $this->line('Stubs directory already exists');
    }

    /**
     * @return void
     */
    protected function generateConfigFile()
    {
        $path = $this->getConfigDir() . '/config.json';

        if ($this->option('force') || !$this->files->exists($path)) {

            $this->files->put($path, json_encode([
                'mango_api_key' => null
            ]));

            $this->info('Config file was generated successfully');

            return null;
        }

        $this->line('Config file already exists');
    }

    /**
     * Get stubs github repository
     *
     * @return Repository|mixed
     */
    protected function getStubsRepoUri()
    {
        return config('madev.stubs.git_repo_uri');
    }
}
