<?php

namespace App\Commands;

use App\Helpers\JavaInstaller;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class InstallJava extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'java:install';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Install latest OpenJDK';

    /**
     * Helper class.
     *
     * @var JavaInstaller
     */
    protected $javaInstaller;

    /**
     * Selected JDK version.
     *
     * @var int
     */
    protected $jdkVersion;

    /**
     * Selected OS.
     *
     * @var int
     */
    protected $os;

    /**
     * Selected architecture.
     *
     * @var int
     */
    protected $arch;

    /**
     * Collection of available JDK Releases
     *
     * @var Collection
     */
    protected $jdkReleases;

    /**
     * Selected JDK release.
     *
     * @var int
     */
    protected $jdkRelease;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->javaInstaller = new JavaInstaller();

        $this->selectJDKVersion()
            ->selectOS()
            ->selectArchitecture()
            ->selectJDKRelease()
            ->downloadJDKInstaller();
    }

    protected function selectJDKVersion():InstallJava
    {
        $this->jdkVersion = $this->menu('JDK Version', $this->javaInstaller->getJDKVersions())->open();

        if ($this->jdkVersion === null) {
            $this->info('Process cancelled');
            die();
        };

        return $this;
    }

    protected function selectOS():InstallJava
    {
        $this->os = $this->menu('OS', $this->javaInstaller->getOSNames())->open();

        if ($this->os === null) {
            $this->info('Process cancelled');
            die();
        };

        return $this;
    }

    protected function selectArchitecture():InstallJava
    {
        $this->arch = $this->menu('Arch', $this->javaInstaller->getArchs())->open();

        if ($this->arch === null) {
            $this->info('Process cancelled');
            die();
        };

        return $this;
    }

    protected function selectJDKRelease():InstallJava
    {
        $this->info('Loading JDK versions...');

        $this->jdkReleases = $this->javaInstaller->getJDks($this->jdkVersion, $this->os, $this->arch);

        $jdkNames = $this->jdkReleases->map(function ($option) {
            return $option['release_name'];
        })->toArray();

        $this->jdkRelease = $this->menu('JDK Version', $jdkNames)->open();

        if ($this->jdkRelease === null) {
            $this->info('Process cancelled');
            die();
        };

        return $this;
    }

    protected function downloadJDKInstaller():InstallJava
    {
        $jdkBinary = $this->jdkReleases->get($this->jdkRelease)['binaries'][0];

        if (!$jdkBinary['installer_link']) {
            $this->info('There is no installer for this version');
            $this->info('We will download the binary file');

            $url = $jdkBinary['binary_link'];
            $filename = $jdkBinary['binary_name'];
        } else {
            $url = $jdkBinary['installer_link'];
            $filename = $jdkBinary['installer_name'];
        }

        $this->info(shell_exec("curl -L -o {$filename} {$url}"));
        $this->info("{$filename} has been downloaded in the current directory");
        $this->info('Please, click on it to finish installation');

        return $this;
    }
}
