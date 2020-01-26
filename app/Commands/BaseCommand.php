<?php

namespace App\Commands;

use Illuminate\Config\Repository;
use LaravelZero\Framework\Commands\Command;

abstract class BaseCommand extends Command
{
    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Get config directory path
     *
     * @return Repository|mixed
     */
    protected function getConfigDir()
    {
        $homePath = trim(shell_exec('echo $HOME'));

        return $homePath . config('madev.config_directory');
    }
}
