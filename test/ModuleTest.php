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
        $this->assertEquals(include __DIR__ . '/../config/module.config.php', $this->module->getConfig());
    }

    public function testModuleConfigDefinesLoggerFactory()
    {
        $application = \Zend\Mvc\Application::init(
            array(
                'modules' => array(
                    'ZendPsrLog'
                ),
                'module_listener_options' => array(
                    'module_paths' => array(
                        __DIR__ . '/../src',
                        __DIR__ . '/../vendor'
                    ),
                )
            )
        );
        $serviceManager = $application->getServiceManager();

        $this->assertInstanceOf('ZendPsrLog\Logger', $serviceManager->get('Zend\Log\Logger'));
    }

    public function testCanGetLoggerFactoryDependencyForDefaultZendLogger()
    {
        $application = \Zend\Mvc\Application::init(
            array(
                'modules' => array(
                    'ZendPsrLog'
                ),
                'module_listener_options' => array(
                    'module_paths' => array(
                        __DIR__ . '/../src',
                        __DIR__ . '/../vendor'
                    ),
                )
            )
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
