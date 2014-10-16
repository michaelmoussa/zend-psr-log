<?php

namespace ZendPsrLog;

use Mockery as m;
use Psr\Log\LogLevel;
use Zend\Log\Logger as ZendLogger;

class PsrLoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PsrLogger
     */
    protected $psrLogger;

    /**
     * @var ZendLogger|\Mockery\Mock
     */
    protected $zendLogger;

    public function testZendLogLevelEquivalentsAreCorrect()
    {
        $this->assertSame(ZendLogger::EMERG, $this->psrLogger->getZendLogLevel(LogLevel::EMERGENCY));
        $this->assertSame(ZendLogger::ALERT, $this->psrLogger->getZendLogLevel(LogLevel::ALERT));
        $this->assertSame(ZendLogger::CRIT, $this->psrLogger->getZendLogLevel(LogLevel::CRITICAL));
        $this->assertSame(ZendLogger::ERR, $this->psrLogger->getZendLogLevel(LogLevel::ERROR));
        $this->assertSame(ZendLogger::WARN, $this->psrLogger->getZendLogLevel(LogLevel::WARNING));
        $this->assertSame(ZendLogger::NOTICE, $this->psrLogger->getZendLogLevel(LogLevel::NOTICE));
        $this->assertSame(ZendLogger::INFO, $this->psrLogger->getZendLogLevel(LogLevel::INFO));
        $this->assertSame(ZendLogger::DEBUG, $this->psrLogger->getZendLogLevel(LogLevel::DEBUG));
    }

    public function testReturnsSuppliedLogLevelAsIsIfNoMatchingZendEquivalentFound()
    {
        $this->assertSame('not a valid log level', $this->psrLogger->getZendLogLevel('not a valid log level'));
    }

    public function psrLogLevelsProvider()
    {
        return [
            [LogLevel::EMERGENCY],
            [LogLevel::ALERT],
            [LogLevel::CRITICAL],
            [LogLevel::ERROR],
            [LogLevel::WARNING],
            [LogLevel::NOTICE],
            [LogLevel::INFO],
            [LogLevel::DEBUG],
        ];
    }

    /**
     * @dataProvider psrLogLevelsProvider
     */
    public function testNamedLogMethodCallsAreProxiedToTheZendLogger($logLevel)
    {
        $message = 'it works!';
        $extra = ['foo' => 'bar'];

        $this->zendLogger->shouldReceive('log')
            ->once()
            ->with($this->psrLogger->getZendLogLevel($logLevel), $message, $extra)
            ->andReturnSelf();
        call_user_func([$this->psrLogger, $logLevel], $message, $extra);
    }

    public function testDirectLogCallsAreProxiedToTheZendLogger()
    {
        $logLevel = LogLevel::INFO;
        $message = 'it works!';
        $extra = ['foo' => 'bar'];

        $this->zendLogger->shouldReceive('log')
            ->once()
            ->with($this->psrLogger->getZendLogLevel($logLevel), $message, $extra)
            ->andReturnSelf();
        call_user_func([$this->psrLogger, 'log'], $logLevel, $message, $extra);
    }

    protected function setUp()
    {
        $this->zendLogger = m::mock('Zend\Log\Logger', [])->shouldDeferMissing();
        $this->psrLogger = new PsrLogger($this->zendLogger);
    }

    protected function tearDown()
    {
        $this->psrLogger = null;
        $this->zendLogger = null;
    }
}
