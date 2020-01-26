<?php

namespace App\Commands;

use App\Helpers\Generators\Frontend\PackageGenerator;
use App\Helpers\Generators\Frontend\PomGenerator;
use App\Helpers\Generators\Frontend\WebpackConfigGenerator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class FrontendNew extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'frontend:new
                            {name : Name of the project}
                            {version : Version of Mango}';

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

        $this->task('Creating webpack.config.js', function () {
            return $this->createWebpackFile();
        });

        $this->task('Creating pom.xml', function () {
            return $this->createPomFile();
        });

        $this->task('Creating package.json', function () {
            return $this->createPackageFile();
        });

        $this->task('Creating components folder', function () {
            return $this->makeDirectory(getcwd() . '/' . $this->getNameInput() .  '/components');
        });

        $this->task('Creating services folder', function () {
            return $this->makeDirectory(getcwd() . '/' . $this->getNameInput() .  '/services');
        });

        $this->info($name . ' created successfully.');
    }

    /**
     * @return bool
     */
    protected function createWebpackFile()
    {
        $webpackGenerator = resolve(WebpackConfigGenerator::class);

        try {

            $webpackGenerator->createFile($this->getNameInput());

        } catch (FileExistsException $exception) {

            $this->error('Webpack configuration already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Webpack configuration stub not found.');
            return false;

        }

        return true;
    }

    /**
     * @return bool
     */
    protected function createPomFile()
    {
        $pomGenerator = resolve(PomGenerator::class);

        try {

            $pomGenerator->createFile($this->getNameInput(), $this->argument('version'));

        } catch (FileExistsException $exception) {

            $this->error('Pom configuration already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Pom configuration stub not found.');
            return false;

        }

        return true;
    }

    /**
     * @return bool
     */
    protected function createPackageFile()
    {
        $packageGenerator = resolve(PackageGenerator::class);

        try {

            $packageGenerator->createFile($this->getNameInput(), $this->argument('version'));

        } catch (FileExistsException $exception) {

            $this->error('package.json already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('package.json stub not found.');
            return false;

        }

        return true;
    }

    /**
     * Creates the directory if necessary.
     *
     * @param string $path
     * @return bool
     */
    protected function makeDirectory(string $path)
    {
        $files = new Filesystem();

        if (!$files->isDirectory($path)) {
            $files->makeDirectory($path, 0777, true, true);

            return true;
        }

        return false;
    }
}
