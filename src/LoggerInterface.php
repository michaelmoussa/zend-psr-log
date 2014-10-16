<?php
/**
 * Zend PSR Log
 *
 * @link      http://github.com/michaelmoussa/zend-psr-log
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
namespace ZendPsrLog;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Zend\Log\LoggerInterface as ZendLoggerInterface;

/**
 * Interface describing a Zend LoggerInterface capable of providing a
 * PSR-3 compliant interface to itself.
 */
interface LoggerInterface extends ZendLoggerInterface
{
    /**
     * Returns a PSR-3 compliant logger that acts as a proxy
     * to the Zend LoggerInterface.
     *
     * @return PsrLoggerInterface
     */
    public function getPsrLogger();
}
