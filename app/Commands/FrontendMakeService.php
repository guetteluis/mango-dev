<?php

namespace App\Commands;

use App\Helpers\Generators\ServiceClassGenerator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FrontendMakeService extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'frontend:make:service
                            {name : Service name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates an AngularJS service';

    /**
     * Execute the console command.
     *
     * @param ServiceClassGenerator $generator
     * @return bool|void
     */
    public function handle(ServiceClassGenerator $generator)
    {
        $name = $this->getNameInput();

        try {

            $generator->create($name);

        } catch (FileExistsException $exception) {

            $this->error('Service already exists.');
            return false;

        } catch (FileNotFoundException $exception) {

            $this->error('Service stub not found.');
            return false;

        }

        $this->info($name . ' created successfully.');
    }
}
