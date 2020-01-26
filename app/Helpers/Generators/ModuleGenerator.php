<?php


namespace App\Helpers\Generators;


use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ModuleGenerator extends Generator
{
    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Module class name
     *
     * @var string
     */
    protected $name;

    /**
     * Module class file extension
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
        return $this->replaceAuthor($stub)
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
        $stubPath = getcwd() . '/app/Commands/stubs/frontend/Module.stub';

        return $this->files->get($stubPath);
    }

    /**
     * Get destination directory
     *
     * @return string
     */
    protected function getDirectory()
    {
        return getcwd() . '/web-src';
    }
}
