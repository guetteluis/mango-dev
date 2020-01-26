<?php

namespace App\Traits;

use Carbon\Carbon;
use Symfony\Component\Process\Process;

trait StubReplacer
{
    /**
     * Replace the year for the given stub.
     *
     * @param string $stub
     * @return $this
     */
    protected function replaceYear(string &$stub):self
    {
        $year = Carbon::now()->year;

        $stub = str_replace('DummyYear', $year, $stub);

        return $this;
    }

    /**
     * Replace the author name for the given stub.
     *
     * @param string $stub
     * @return $this
     */
    protected function replaceAuthorName(string &$stub):self
    {
        $author = '';

        $process = new Process(['git', 'config', 'user.name'], null, null, null, null);

        $process->run(function ($type, $line) use (&$author) {
            $author = $line;
        });

        $stub = str_replace('DummyAuthorName', trim($author), $stub);

        return $this;
    }

    /**
     * Replace the author email for the given stub.
     *
     * @param string $stub
     * @return $this
     */
    protected function replaceAuthorEmail(string &$stub):self
    {
        $authorEmail = '';

        $process = new Process(['git', 'config', 'user.email'], null, null, null, null);

        $process->run(function ($type, $line) use (&$authorEmail) {
            $authorEmail = $line;
        });

        $stub = str_replace('DummyAuthorEmail', trim($authorEmail), $stub);

        return $this;
    }

    /**
     * Replace the template name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceTemplate(string &$stub, string $name):self
    {
        $stub = str_replace('DummyTemplate', $name, $stub);

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass(string $stub, string $name):string
    {
        return str_replace('DummyClassname', $name, $stub);
    }

    /**
     * Replace the project name for the given stub.
     *
     * @param $stub
     * @param string $name
     * @return $this
     */
    protected function replaceProjectName(string &$stub, string $name):self
    {
        $stub = str_replace('DummyProjectName', $name, $stub);

        return $this;
    }

    /**
     * Replace the version for the given stub.
     *
     * @param $stub
     * @param string $version
     * @return $this
     */
    protected function replaceVersion(string &$stub, string $version):self
    {
        $stub = str_replace('DummyVersion', $version, $stub);

        return $this;
    }
}
