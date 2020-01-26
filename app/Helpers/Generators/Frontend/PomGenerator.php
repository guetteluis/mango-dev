<?php


namespace App\Helpers\Generators\Frontend;

use App\Helpers\Generators\Generator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class PomGenerator extends Generator
{
    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'Pom';

    /**
     * Pom name
     *
     * @var string
     */
    protected $name = 'pom';

    /**
     * Pom file extension
     *
     * @var string
     */
    protected $ext = '.xml';

    /**
     * @var string
     */
    protected $projectName;

    /**
     * @var string
     */
    protected $version;

    /**
     * Creates file
     *
     * @param string $projectName
     * @param string $version
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function createPom(string $projectName, string $version)
    {
        $this->projectName = $projectName;
        $this->version = $version;

        $this->create();
    }

    /**
     * Replace dummy names.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceDummyNames(string $stub)
    {
        $this->replaceYear($stub)
            ->replaceAuthor($stub)
            ->replaceProjectName($stub, $this->projectName)
            ->replaceVersion($stub, $this->version);

        return $stub;
    }

    /**
     * Get stub file
     *
     * @return string
     * @throws FileNotFoundException
     */
    protected function getStub()
    {
        $stubPath = getcwd() . '/app/Commands/stubs/frontend/Pom.stub';

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
