<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeComponentCommandTest extends TestCase
{
    /**
     * @test
     */
    public function a_component_can_be_created()
    {
        $componentName = 'Test';

        $this->artisan('make:component ' . $componentName)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        $basePath = getcwd() . '/web-src/components/' . $componentName . '/' . $componentName;

        // Assert that component class exists
        $this->assertTrue($this->files->exists($basePath . '.js'));

        // Assert that component template exists
        $this->assertTrue($this->files->exists($basePath . '.html'));
    }
}
