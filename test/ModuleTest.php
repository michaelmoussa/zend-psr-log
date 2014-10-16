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

    public function testModuleConfigDefinesLoggerFactory()
    {
        $application = \Zend\Mvc\Application::init(
            [
                'modules' => [
                    'ZendPsrLog'
                ],
                'module_listener_options' => [
                    'module_paths' => [
                        __DIR__ . '/../src',
                        __DIR__ . '/../vendor'
                    ],
                ]
            ]
        );
        $serviceManager = $application->getServiceManager();

        $this->assertInstanceOf('ZendPsrLog\Logger', $serviceManager->get('Zend\Log\Logger'));
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
