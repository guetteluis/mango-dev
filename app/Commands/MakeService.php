<?php

namespace App\Commands;

use App\Helpers\Generators\ServiceClassGenerator;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LaravelZero\Framework\Commands\Command;

class MakeService extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:service
                            {name : Service name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a AngularJS service';

    /**
     * Execute the console command.
     *
     * @param ServiceClassGenerator $generator
     * @return void
     */
    public function handle(ServiceClassGenerator $generator)
    {
        $name = $this->getNameInput();

        try {

            $generator->create($name);

        } catch (FileExistsException $exception) {

            $this->error('Service already exists.');
            die();

        } catch (FileNotFoundException $exception) {

            $this->error('Service stub not found.');
            die();

        }

        $this->info($name . ' created successfully.');
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
