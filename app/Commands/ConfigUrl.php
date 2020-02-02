<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use \App\Traits\Config;

class ConfigUrl extends Command
{
    use Config;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'config:url
                            {url : Mango URL}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set Mango URL';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->getUrlInput();

        if ($this->getUrl($url)) {
            if ($this->confirm('Do you really want to replace the current URL?')) {
                $this->setUrl($url);

                $this->info('The URL was set successfully');

                return true;
            }

            return false;
        }

        $this->setUrl($url);

        $this->info('The URL was set successfully');

        return true;
    }

    protected function getUrlInput():string
    {
        return trim($this->argument('url'));
    }
}
