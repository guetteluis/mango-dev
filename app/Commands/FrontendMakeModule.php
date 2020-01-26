<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

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
     * @return mixed
     */
    public function handle()
    {

    }
}
