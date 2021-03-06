<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendNewCommandTest extends TestCase
{
    protected $name = 'Test';

    protected function setUp(): void
    {
        parent::setUp();
        $this->files->deleteDirectory(getcwd() . '/' . $this->name);
    }

    /**
     * @test
     */
    public function a_project_can_be_created()
    {
        $version = '3.8.0';

        $this->artisan('frontend:new ' . $this->name . ' ' . $version)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        // Asserts that webpack config exists
        $this->assertTrue($this->files->exists(getcwd() . '/' . $this->name . '/webpack.config.js'));

        // Asserts that pom config exists
        $this->assertTrue($this->files->exists(getcwd() . '/' . $this->name . '/pom.xml'));

        // Asserts that package.json exists
        $this->assertTrue($this->files->exists(getcwd() . '/' . $this->name . '/package.json'));

        // Asserts that components directory exists
        $this->assertTrue($this->files->isDirectory(getcwd() . '/' . $this->name . '/components'));

        // Asserts that services directory exists
        $this->assertTrue($this->files->isDirectory(getcwd() . '/' . $this->name . '/services'));

        $this->files->deleteDirectory(getcwd() . '/' . $this->name);
    }
}
