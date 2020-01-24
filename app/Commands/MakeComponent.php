<?php

namespace App\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;

class MakeComponent extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:component
                            {name : Component name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a AngularJS component';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new controller creator command instance.
     *
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
     * @return bool|null
     *
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $name = $this->getNameInput();

        $path = $this->getPath($name);

        if ((!$this->hasOption('force') || !$this->option('force'))
            && $this->alreadyExists($name)) {

            $this->error('Component already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->generateTemplate($name);

        $this->info('Component created successfully.');
    }

    protected function generateTemplate(string $name)
    {
        $stub = $this->files->get($this->getStub('template'));
        $path = getcwd() . '/web-src/components/' . $name . '/' . $name . '.html';

        $this->files->put($path, $this->replaceClass($stub, $name));
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string $type
     * @return string
     */
    protected function getStub(string $type = 'component'):string
    {
        if ($type === 'template') {
            return __DIR__ . '/stubs/ComponentTemplate.stub';
        }

        return __DIR__ . '/stubs/Component.stub';
    }

    /**
     * Determine if the component already exists.
     *
     * @param string $name
     * @return bool
     */
    protected function alreadyExists(string $name):bool
    {
        return $this->files->exists($this->getPath($name));
    }

    /**
     * Get the destination component path.
     *
     * @param $name
     * @return string
     */
    protected function getPath($name):string
    {
        $path = getcwd() . '/web-src/components/' . $name;

        return  $path . '/' . $name . '.js';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceAuthor($stub)
            ->replaceTemplate($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the author name for the given stub.
     *
     * @param string $stub
     * @return $this
     */
    protected function replaceAuthor(string &$stub):self
    {
        $author= '';

        $process = new Process(['git', 'config', 'user.name'], null, null, null, null);

        $process->run(function ($type, $line) use (&$author) {
            $author = $line;
        });

        $stub = str_replace('DummyAuthor', $author, $stub);

        return $this;
    }

    /**
     * Replace the template name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceTemplate(string &$stub, string $name):self
    {
        $stub = str_replace('DummyTemplate', $name . 'Template', $stub);

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass(string $stub, string $name):string
    {
        return str_replace('DummyClassname', $name, $stub);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
