<?php


namespace App\Helpers\Generators\Frontend;

use App\Helpers\Generators\Generator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ComponentTemplateGenerator extends Generator
{
    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'Template';

    /**
     * Template file extension
     *
     * @var string
     */
    protected $ext = '.html';

    /**
     * Replace dummy names.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceDummyNames(string $stub)
    {
        return $this->replaceYear($stub)
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
        $stubPath = getcwd() . '/app/Commands/stubs/frontend/ComponentTemplate.stub';

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
