<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeServiceCommandTest extends TestCase
{
    /**
     * @test
     */
    public function a_service_can_be_created()
    {
        $serviceName = 'Test';

        $this->artisan('make:service ' . $serviceName)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        $basePath = getcwd() . '/web-src/services/' . $serviceName . '/' . $serviceName;

        // Assert that services class exists
        $this->assertTrue($this->files->exists($basePath . '.js'));
    }
}
