<?php
/**
 * Zend PSR Log
 *
 * @link      http://github.com/michaelmoussa/zend-psr-log
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
namespace ZendPsrLog;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for creating ZendPsrLog logger instances.
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * Creates the ZendPsrLog logger.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new Logger(isset($config['log']) ? $config['log'] : array());
    }
}
