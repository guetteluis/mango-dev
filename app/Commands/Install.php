<?php

namespace App\Commands;

use App\Helpers\Github;
use LaravelZero\Framework\Commands\Command;

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

        $this->info(shell_exec($command->implode(' && ')));

        return $this;
    }
}
