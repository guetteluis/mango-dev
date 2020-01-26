<?php

namespace App\Commands;

use App\Helpers\Generators\WebpackConfigGenerator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FrontendNew extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'frontend:new
                            {name : Name of the project}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a new AngularJS project';

    /**
     * Execute the console command.
     *
     * @return bool|void
     */
    public function handle()
    {
        $name = $this->getNameInput();

        $this->createWebpackFile();

        $this->info($name . ' created successfully.');
    }

    /**
     * @return bool
     */
    protected function createWebpackFile()
    {
        $webpackGenerator = resolve(WebpackConfigGenerator::class);

        try {

            $webpackGenerator->create();

        } catch (FileExistsException $exception) {

            $this->error('Webpack configuration already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Webpack configuration stub not found.');
            return false;

        }

        return true;
    }
}
