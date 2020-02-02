<?php

namespace App\Commands;

use Illuminate\Console\Command;
use \App\Traits\Config;

class ConfigApiKey extends Command
{
    use Config;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'config:api-key
                            {apiKey : Mango API key}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set Mango API key';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiKey = $this->getApiKeyInput();

        if ($this->getApiKey()) {
            if ($this->confirm('Do you really want to replace the current API key?')) {
                $this->setApiKey($apiKey);

                $this->info('The API key was set successfully');

                return true;
            }

            return false;
        }

        $this->setApiKey($apiKey);

        $this->info('The API key was set successfully');

        return true;
    }

    protected function getApiKeyInput():string
    {
        return trim($this->argument('apiKey'));
    }
}
