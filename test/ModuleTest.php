<?php

namespace ZendPsrLog;

use Mockery as m;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    public function testGetConfigReturnsCorrectConfig()
    {
        $this->assertSame(include __DIR__ . '/../config/module.config.php', $this->module->getConfig());
    }

    protected function setUp()
    {
        $this->module = new Module();
    }

    protected function tearDown()
    {
        $this->module = null;
    }
}
