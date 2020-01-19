<?php


namespace App\Helpers;


use Illuminate\Support\Collection;

class Github
{
    public static function clone(Collection $repos):Collection
    {
        $command = collect();

        $repos->each(function ($repo) use ($command) {
            $repoUrl = self::buildRepoUrl($repo);

            $command->push("git clone {$repoUrl}");
        });

        return $command;
    }

    protected static function buildRepoUrl(string $repo):string
    {
        return "https://github.com/infiniteautomation/{$repo}.git";
    }
}
