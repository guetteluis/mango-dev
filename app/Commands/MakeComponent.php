<?php

namespace App\Commands;

use App\Traits\StubReplacer;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class MakeComponent extends Command
{
    use StubReplacer;

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
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
