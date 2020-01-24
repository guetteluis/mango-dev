<?php

namespace App\Traits;

use Symfony\Component\Process\Process;

trait StubReplacer{
    /**
     * Replace the author name for the given stub.
     *
     * @param string $stub
     * @return $this
     */
    protected function replaceAuthor(string &$stub):self
    {
        $author= '';

        $process = new Process(['git', 'config', 'user.name'], null, null, null, null);

        $process->run(function ($type, $line) use (&$author) {
            $author = $line;
        });

        $stub = str_replace('DummyAuthor', $author, $stub);

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
}
