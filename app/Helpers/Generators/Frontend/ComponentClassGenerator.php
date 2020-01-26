<?php


namespace App\Helpers\Generators\Frontend;

use App\Helpers\Generators\Generator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ComponentClassGenerator extends Generator
{
    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'Component';

    /**
     * Component class name
     *
     * @var string
     */
    protected $name;

    /**
     * Component class file extension
     *
     * @var string
     */
    protected $ext = '.js';


    /**
     * Replace dummy names.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceDummyNames(string $stub)
    {
        return $this->replaceYear($stub)
            ->replaceAuthorName($stub)
            ->replaceTemplate($stub, $this->name)
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
        $stubPath = $this->getConfigDir() . '/stubs/frontend/Component.stub';

        return $this->files->get($stubPath);
    }

    /**
     * Get destination directory
     *
     * @return string
     */
    protected function getDirectory()
    {
        return getcwd() . '/web-src/components/' . $this->name;
    }
}
