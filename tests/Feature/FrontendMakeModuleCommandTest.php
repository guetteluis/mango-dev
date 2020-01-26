<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendMakeModuleCommandTest extends TestCase
{
    /**
     * @test
     */
    public function a_module_can_be_created()
    {
        $name = 'Test';

        $this->artisan('frontend:make:module ' . $name)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        $basePath = getcwd() . '/web-src/' . $name;

        // Assert that module exists
        $this->assertTrue($this->files->exists($basePath . '.js'));
    }
}
