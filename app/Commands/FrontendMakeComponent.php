<?php

namespace App\Commands;

use App\Helpers\Generators\ComponentClassGenerator;
use App\Helpers\Generators\ComponentTemplateGenerator;
use App\Traits\StubReplacer;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FrontendMakeComponent extends BaseCommand
{
    use StubReplacer;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'frontend:make:component
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
     * @return bool|void
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
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Component stub not found.');
            return false;

        }

        $this->info($name . ' created successfully.');
    }
}
