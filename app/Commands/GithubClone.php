<?php

namespace App\Commands;

use App\Helpers\Github;
use LaravelZero\Framework\Commands\Command;

class GithubClone extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'github:clone
                            {repos=ma-core-public,ma-modules-public,ma-dashboards : Repository names separated with comma (,)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Clone Github repositories';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repos = collect(
            explode(',', $this->argument('repos'))
        )->unique();

        $invalidRepos = Github::getInvalidRepos($repos);

        if ($invalidRepos->count()){
            $this->info("These repos are not valid: {$invalidRepos->implode(', ')}");
            die();
        }

        $this->info("Cloning {$repos->implode(', ')}");
        $this->info('The process will take some minutes');

        $command = Github::clone($repos);

        $this->info(shell_exec($command->implode(' && ')));

        return $this;
    }
}
