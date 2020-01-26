<?php

namespace App\Commands;

use App\Helpers\Generators\ComponentClassGenerator;
use App\Helpers\Generators\ComponentTemplateGenerator;
use App\Traits\StubReplacer;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MakeComponent extends BaseCommand
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
    protected $description = 'Creates an AngularJS component';

    /**
     * Execute the console command.
     *
     * @param ComponentClassGenerator $classGenerator
     * @param ComponentTemplateGenerator $templateGenerator
     * @return void
     */
    public function handle(ComponentClassGenerator $classGenerator,
                           ComponentTemplateGenerator $templateGenerator)
    {
        $name = $this->getNameInput();

        try {

            $classGenerator->create($name);
            $templateGenerator->create($name);

        } catch (FileExistsException $exception) {

            $this->error('Component already exists.');
            die();

        } catch (FileNotFoundException $exception) {

            $this->error('Component stub not found.');
            die();

        }

        $this->info($name . ' created successfully.');
    }
}
