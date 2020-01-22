<?php


namespace App\Helpers;


use Illuminate\Support\Collection;

class Github
{
    public static function clone(Collection $repos):Collection
    {
        $command = collect();

        $repos->each(function (string $repo) use ($command) {
            $repoUrl = self::buildRepoUrl($repo);

            $command->push("git clone {$repoUrl}");
        });

        return $command;
    }

    public static function getInvalidRepos(Collection $repos)
    {
        return $repos->diff(config('git.repositories'));
    }

    protected static function buildRepoUrl(string $repo):string
    {
        return "https://github.com/infiniteautomation/{$repo}.git";
    }
}
