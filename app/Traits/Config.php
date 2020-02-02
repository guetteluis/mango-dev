<?php


namespace App\Traits;


use Illuminate\Filesystem\Filesystem;

trait Config
{
    protected function getApiKey(): ?string
    {
        return array_key_exists('mango_api_key', $this->getConfigData())
            ? $this->getConfigData()['mango_api_key'] : null;
    }

    protected function getUrl(): ?string
    {
        return array_key_exists('mango_url', $this->getConfigData())
            ? $this->getConfigData()['mango_url'] : null;
    }

    protected function setApiKey(string $apiKey): void
    {
        $this->setConfigValue('mango_api_key', $apiKey);
    }

    protected function setUrl(string $url): void
    {
        $this->setConfigValue('mango_url', $url);
    }

    protected function setConfigValue(string $key, $value): void
    {
        $files = new Filesystem();

        $config = $this->getConfigData();

        $config[$key] = $value;

        $files->put($this->getConfigFile(), json_encode($config));
    }

    protected function getConfigData(): array
    {
        $files = new Filesystem();

        $path = $this->getConfigFile();

        return json_decode($files->get($path), true);
    }

    protected function getConfigFile(): string
    {
        return $this->getConfigDir() . '/config.json';
    }

    protected function getConfigDir(): string
    {
        $homePath = trim(shell_exec('echo $HOME'));

        return $homePath . config('madev.config_directory');
    }
}
