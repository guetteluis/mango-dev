<?php


namespace App\Helpers\Generators\Frontend;

use App\Helpers\Generators\Generator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class WebpackConfigGenerator extends Generator
{
    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'Webpack Configuration';

    /**
     * Component class name
     *
     * @var string
     */
    protected $name = 'webpack';

    /**
     * Component class file extension
     *
     * @var string
     */
    protected $ext = '.config.js';

    /**
     * Replace dummy names.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceDummyNames(string $stub)
    {
        return $this->replaceYear($stub)
            ->replaceAuthor($stub)
            ->replaceClass($stub, $this->name);
    }

    /**
     * Get stub file
     *
     * @return string
     * @throws FileNotFoundException
     */
    protected function getStub()
    {
        $stubPath = getcwd() . '/app/Commands/stubs/frontend/Webpack.stub';

        return $this->files->get($stubPath);
    }

    /**
     * Get destination directory
     *
     * @return string
     */
    protected function getDirectory()
    {
        return getcwd();
    }
}
