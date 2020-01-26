<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendNewCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->files->delete(getcwd() . '/webpack.config.js');
        $this->files->delete(getcwd() . '/pom.xml');
    }

    /**
     * @test
     */
    public function a_project_can_be_created()
    {
        $name = 'Test';

        $version = '3.8.0';

        $this->artisan('frontend:new ' . $name . ' ' . $version)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        // Asserts that webpack config exists
        $this->assertTrue($this->files->exists(getcwd() . '/webpack.config.js'));

        // Asserts that pom config exists
        $this->assertTrue($this->files->exists(getcwd() . '/pom.xml'));

        $this->files->delete(getcwd() . '/webpack.config.js');
        $this->files->delete(getcwd() . '/pom.xml');
    }
}
