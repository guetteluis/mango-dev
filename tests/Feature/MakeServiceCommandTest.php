<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class MakeServiceCommandTest extends TestCase
{
    /**
     * @test
     */
    public function a_service_can_be_created()
    {
        $files = new Filesystem();

        $serviceName = 'Test';

        $this->artisan('make:service ' . $serviceName)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        $basePath = getcwd() . '/web-src/services/' . $serviceName . '/' . $serviceName;

        // Assert that services class exists
        $this->assertTrue($files->exists($basePath . '.js'));

        $files->deleteDirectory(getcwd() . '/web-src');
    }
}
