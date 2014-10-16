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
        $serviceManager->setService(
            'config',
            array('log' => array('Zend\Log\Logger' => array('writers' => array(array('name' => 'mock')))))
        );

        $factory = new LoggerFactory('Zend\Log\Logger');
        $logger = $factory->createService($serviceManager);
        $this->assertInstanceOf('ZendPsrLog\Logger', $logger);
        $this->assertSame(1, count($logger->getWriters()));
    }

    public function testNullConfigKeyUsesRootLogKeyAsLoggerConfig()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'config',
            array('log' => array('writers' => array(array('name' => 'mock'))))
        );

        $factory = new LoggerFactory(null);
        $logger = $factory->createService($serviceManager);
        $this->assertInstanceOf('ZendPsrLog\Logger', $logger);
        $this->assertSame(1, count($logger->getWriters()));
    }

    /**
     * The Zend\Log\LoggerServiceFactory can't be directly re-used because can't
     * change the type of Logger it returns, so let's at least make sure that
     * our LoggerFactory behaves the same way.
     */
    public function testCreatesLoggerEquivalentToHowTheZendLoggerServiceFactoryDoesIt()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'config',
            array('log' => array('writers' => array(array('name' => 'mock'))))
        );

        $zendPsrLoggerFactory = new LoggerFactory(null);
        $zendPsrLogger = $zendPsrLoggerFactory->createService($serviceManager);

        $zendLoggerServiceFactory = new LoggerServiceFactory();
        $zendLogger = $zendLoggerServiceFactory->createService($serviceManager);

        $reflectedZendPsrLogger = new \ReflectionClass($zendPsrLogger);
        $reflectedZendLogger = new \ReflectionClass($zendLogger);

        /** @var \ReflectionProperty $property */
        foreach ($reflectedZendLogger->getProperties() as $property) {
            $zendLoggerProperty = new \ReflectionProperty($zendLogger, $property->getName());
            $zendLoggerProperty->setAccessible(true);

            $zendPsrLoggerProperty = new \ReflectionProperty($zendPsrLogger, $property->getName());
            $zendPsrLoggerProperty->setAccessible(true);

            $this->assertEquals(
                $zendLoggerProperty->getValue($zendLogger),
                $zendPsrLoggerProperty->getValue($zendPsrLogger)
            );
        }

        $this->assertSame(
            $reflectedZendLogger->getStaticProperties(),
            $reflectedZendPsrLogger->getStaticProperties()
        );
    }
}
