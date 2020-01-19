<?php

namespace App\Commands;

use App\Helpers\Github;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;

class Install extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install
                            {repos=ma-core-public,ma-modules-public,ma-dashboards : Repository names separated with comma (,)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Mango installation for development';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->cloneRepositories();
    }

    /**
     * Clone github repositories based on user selection
     *
     * @return Command
     */
    protected function cloneRepositories():Command
    {
        $repos = collect(
            explode(',', $this->argument('repos'))
        )->unique();

        $this->info("Cloning {$repos->implode(', ')}");
        $this->info('The process will take some minutes');

        $command = Github::clone($repos);

        $process = Process::fromShellCommandline($command->implode(' && '), null, null, null, null);

        $bar = $this->output->createProgressBar($repos->count());

        $process->run(function ($type, $line) use ($bar) {
            $this->info($line);
            $bar->advance();
        });

        $bar->finish();

        return $this;
    }
}
