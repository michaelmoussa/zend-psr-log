<?php

namespace ZendPsrLog;

use Mockery as m;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    protected $logger;

    public function testIsAZendLogger()
    {
        $this->assertInstanceOf('Zend\Log\Logger', $this->logger);
    }

    public function testImplementsZendPsrLoggerInterface()
    {
        $this->assertInstanceOf('ZendPsrLog\LoggerInterface', $this->logger);
    }

    public function testPsrLoggerIsCreatedAutomaticallyIfNotPreviouslySet()
    {
        $psrLogger = new \ReflectionProperty($this->logger, 'psrLogger');
        $psrLogger->setAccessible(true);
        $this->assertNull($psrLogger->getValue($this->logger));

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->logger->getPsrLogger());
    }

    public function testPsrLoggerUsesCurrentLoggerAsBackend()
    {
        $psrLogger = $this->logger->getPsrLogger();
        $zendLogger = new \ReflectionProperty($psrLogger, 'zendLogger');
        $zendLogger->setAccessible(true);

        $this->assertSame($this->logger, $zendLogger->getValue($psrLogger));
    }

    public function testReturnsSamePsrLoggerOnMultipleInvocations()
    {
        $this->assertSame($this->logger->getPsrLogger(), $this->logger->getPsrLogger());
    }

    protected function setUp()
    {
        $this->logger = new Logger();
    }

    protected function tearDown()
    {
        $this->logger = null;
    }
}
