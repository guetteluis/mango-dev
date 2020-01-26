<?php


namespace App\Helpers\Generators\Frontend;

use App\Helpers\Generators\Generator;
use Illuminate\Contracts\Filesystem\FileExistsException;
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
     * Webpack name
     *
     * @var string
     */
    protected $name = 'webpack';

    /**
     * Webpack file extension
     *
     * @var string
     */
    protected $ext = '.config.js';

    /**
     * @var string
     */
    protected $projectName;

    /**
     * Creates file
     *
     * @param string $projectName
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function createFile(string $projectName)
    {
        $this->projectName = $projectName;
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
            ->replaceAuthor($stub);

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
        return getcwd(). '/' . $this->projectName;
    }
}
