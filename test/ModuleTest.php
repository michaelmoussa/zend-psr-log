<?php

namespace ZendPsrLog;

use Mockery as m;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    public function testIsConfigProvider()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ConfigProviderInterface', $this->module);
    }

    public function testIsServiceProvider()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ServiceProviderInterface', $this->module);
    }

    public function testGetConfigReturnsCorrectConfig()
    {
        $this->assertEquals(include __DIR__ . '/../config/module.config.php', $this->module->getConfig());
    }

    public function testGetServiceConfigReturnsCorrectConfig()
    {
        $this->assertEquals(include __DIR__ . '/../config/service.config.php', $this->module->getServiceConfig());
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

    public function testCanGetLoggerFactoryDependencyForDefaultZendLogger()
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

        $this->assertInstanceOf('ZendPsrLog\LoggerFactory', $serviceManager->get('ZendPsrLog\LoggerFactory'));
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
