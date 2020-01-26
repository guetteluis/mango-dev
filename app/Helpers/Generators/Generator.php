<?php


namespace App\Helpers\Generators;


use App\Traits\StubReplacer;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

abstract class Generator
{
    use StubReplacer;

    /**
     * Type of file to be generated;
     *
     * @var string
     */
    protected $type = 'File';

    /**
     * Template file extension
     *
     * @var string
     */
    protected $ext;

    /**
     * Template name
     *
     * @var string
     */
    protected $name;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * TemplateClassGenerator constructor.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Replace dummy names.
     *
     * @param string $stub
     * @return string
     */
    abstract protected function replaceDummyNames(string $stub);

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws FileNotFoundException
     */
    abstract protected function getStub();

    /**
     * Get destination directory
     *
     * @return string
     */
    abstract protected function getDirectory();

    /**
     * @param string $ext
     */
    public function setExt(string $ext): void
    {
        $this->ext = $ext;
    }

    /**
     * Creates file
     *
     * @param string $name
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function create(string $name = null)
    {
        if (!$this->name) $this->name = $name;

        if ($this->alreadyExists()) {
            throw new FileExistsException($this->type . ' file already exists');
        }

        $this->makeDirectory();

        $this->generate();
    }

    /**
     * Generates template file
     *
     * @throws FileNotFoundException
     */
    protected function generate()
    {
        $stub = $this->getStub();

        $file = $this->replaceDummyNames($stub);

        $this->files->put($this->getFilePath(), $file);
    }

    /**
     * Determine if the file already exists.
     *
     * @return bool
     */
    protected function alreadyExists():bool
    {
        return $this->files->exists($this->getFilePath());
    }

    /**
     * Get file destination path
     *
     * @return string
     */
    protected function getFilePath()
    {
        $directory = $this->getDirectory();

        return  $directory . '/' . $this->name . $this->ext;
    }

    /**
     * Creates the directory for the file if necessary.
     *
     * @return string
     */
    protected function makeDirectory()
    {
        $path = $this->getFilePath();

        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Get config directory
     *
     * @return Repository|mixed
     */
    protected function getConfigDir()
    {
        $homePath = trim(shell_exec('echo $HOME'));

        return $homePath . config('madev.config_directory');
    }
}
