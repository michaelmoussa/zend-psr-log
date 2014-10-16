<?php
/**
 * Zend PSR Log
 *
 * @link      http://github.com/michaelmoussa/zend-psr-log
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
namespace ZendPsrLog;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Zend\Log\Logger as ZendLogger;

/**
 * A PSR-3 compliant proxy to an underlying Zend\Log\Logger
 */
class PsrLogger implements PsrLoggerInterface
{
    use LoggerTrait;

    /**
     * Instance of a ZF2 logger.
     *
     * @var ZendLogger
     */
    protected $zendLogger;

    /**
     * Mapping of Zend Log levels to PSR-3 defined LogLevels.
     *
     * @var array
     */
    public static $zendLogLevelMap = [
        LogLevel::EMERGENCY => ZendLogger::EMERG,
        LogLevel::ALERT => ZendLogger::ALERT,
        LogLevel::CRITICAL => ZendLogger::CRIT,
        LogLevel::ERROR => ZendLogger::ERR,
        LogLevel::WARNING => ZendLogger::WARN,
        LogLevel::NOTICE => ZendLogger::NOTICE,
        LogLevel::INFO => ZendLogger::INFO,
        LogLevel::DEBUG => ZendLogger::DEBUG,
    ];

    /**
     * Constructor
     *
     * @param ZendLogger $zendLogger
     */
    public function __construct(ZendLogger $zendLogger)
    {
        $this->zendLogger = $zendLogger;
    }

    /**
     * Returns the integer Zend Log Level corresponding to the PSR-3 string log level provided.
     *
     * Zend Logger throws an exception if the log level is not valid, so if there is no corresponding value,
     * then the provided level will be returned as-is.
     *
     * @param string $level
     * @return mixed
     */
    public function getZendLogLevel($level)
    {
        return isset(self::$zendLogLevelMap[$level]) ? self::$zendLogLevelMap[$level] : $level;
    }

    /**
     * Proxies log calls to the Zend Logger with the corresponding log level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function log($level, $message, array $context = array())
    {
        return $this->zendLogger->log($this->getZendLogLevel($level), $message, $context);
    }
}
