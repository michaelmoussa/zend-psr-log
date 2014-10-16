<?php

namespace ZendPsrLog;

use Mockery as m;
use Zend\Log\LoggerServiceFactory;
use Zend\ServiceManager\ServiceManager;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatesZendPsrLogger()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', array('log' => array('writers' => array(array('name' => 'mock')))));

        $factory = new LoggerFactory();
        $this->assertInstanceOf('ZendPsrLog\Logger', $factory->createService($serviceManager));
    }

    /**
     * The Zend\Log\LoggerServiceFactory can't be directly re-used because can't
     * change the type of Logger it returns, so let's at least make sure that
     * our LoggerFactory behaves the same way.
     */
    public function testCreatesLoggerEquivalentToHowTheZendLoggerServiceFactoryDoesIt()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', array('log' => array('writers' => array(array('name' => 'mock')))));

        $zendPsrLoggerFactory = new LoggerFactory();
        $zendPsrLogger = $zendPsrLoggerFactory->createService($serviceManager);

        $zendLoggerServiceFactory = new LoggerServiceFactory();
        $zendLogger = $zendLoggerServiceFactory->createService($serviceManager);

        $reflectedZendPsrLogger = new \ReflectionClass($zendPsrLogger);
        $reflectedZendLogger = new \ReflectionClass($zendLogger);

        /** @var \ReflectionProperty $property */
        foreach ($reflectedZendLogger->getProperties() as $property) {
            $this->assertEquals($property, $reflectedZendPsrLogger->getProperty($property->getName()));
        }

        $this->assertSame(
            $reflectedZendLogger->getStaticProperties(),
            $reflectedZendPsrLogger->getStaticProperties()
        );
    }
}
