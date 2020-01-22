<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class InstallMaven extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'maven:install
                            {dest=./ : Destination directory}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Install Maven in the desired directory';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $destination = $this->argument('dest');
        $directoryName = 'apache-maven-3.6.3';
        $filename = 'apache-maven-3.6.3-bin.zip';

        $url = "https://www-eu.apache.org/dist/maven/maven-3/3.6.3/binaries/{$filename}";

        $this->info(shell_exec("curl -L -o {$filename} {$url}"));

        $this->info(shell_exec("unzip {$filename} -d {$destination}"));

        $this->info(shell_exec("sudo chmod 777 {$destination}/$directoryName"));

        $this->info(shell_exec("rm {$filename}"));

        $this->line('You need to set the next environment variable in order to run Maven:');
        $this->info("export M2_HOME={$destination}/{$directoryName}");
        $this->info('export M2=$M2_HOME/bin');
    }
}
