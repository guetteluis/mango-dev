<?php

namespace App\Commands;

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
        $this->call('github:clone', [
            'repos' => $this->argument('repos')
        ]);
        return $this;
    }
}
