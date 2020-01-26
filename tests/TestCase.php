<?php

namespace Tests;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var Filesystem $files
     */
    protected $files;

    protected function setUp(): void
    {
        parent::setUp();

        $this->files = new Filesystem();

        $this->files->deleteDirectory(getcwd() . '/web-src');
    }


}
