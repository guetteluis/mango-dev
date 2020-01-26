<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendNewCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->files->delete(getcwd() . '/webpack.config.js');
    }

    /**
     * @test
     */
    public function a_project_can_be_created()
    {
        $name = 'Test';

        $this->artisan('frontend:new ' . $name)
            ->expectsOutput('Test created successfully.')
            ->assertExitCode(0);

        // Asserts that service class exists
        $this->assertTrue($this->files->exists(getcwd() . '/webpack.config.js'));

        $this->files->delete(getcwd() . '/webpack.config.js');
    }
}
