<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class MakeComponentCommandTest extends TestCase
{
    /**
     * @test
     *
     */
    public function a_component_can_be_created()
    {
        $files = new Filesystem();

        $componentName = 'Test';

        $this->artisan('make:component ' . $componentName)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        $basePath = getcwd() . '/web-src/components/' . $componentName . '/' . $componentName;

        // Assert that component class exists
        $this->assertTrue($files->exists($basePath . '.js'));

        // Assert that component template exists
        $this->assertTrue($files->exists($basePath . '.html'));

        $files->deleteDirectory(getcwd() . '/web-src');
    }
}
