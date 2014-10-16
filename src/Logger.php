<?php
/**
 * Zend PSR Log
 *
 * @link      http://github.com/michaelmoussa/zend-psr-log
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
namespace ZendPsrLog;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Zend\Log\Logger as ZendLogger;

/**
 * A drop-in replacement for Zend\Log\Logger capable of providing a
 * PSR-3 compliant interface to itself.
 */
class Logger extends ZendLogger implements LoggerInterface
{
    /**
     * A PSR-3 compliant logger that proxies calls to this Zend Logger.
     *
     * @var PsrLoggerInterface
     */
    protected $psrLogger;

    /**
     * {@inheritDoc}
     *
     * @return PsrLoggerInterface
     */
    public function getPsrLogger()
    {
        if (!isset($this->psrLogger)) {
            $this->psrLogger = new PsrLogger($this);
        }

        return $this->psrLogger;
    }
}
