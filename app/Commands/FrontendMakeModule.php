<?php

namespace App\Commands;

use App\Helpers\Generators\Frontend\ModuleGenerator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FrontendMakeModule extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'frontend:make:module
                            {name : Module name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates an AngularJS module';

    /**
     * Execute the console command.
     *
     * @param ModuleGenerator $generator
     * @return bool|void
     */
    public function handle(ModuleGenerator $generator)
    {
        $name = $this->getNameInput();

        try {

            $generator->create($name);

        } catch (FileExistsException $exception) {

            $this->error('Module already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Module stub not found.');
            return false;

        }

        $this->info($name . ' created successfully.');
    }
}
