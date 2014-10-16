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
     * The key immediately under "log" in the config to use for this logger.
     *
     * @var string
     */
    protected $configKey;

    /**
     * Constructor
     *
     * @param string $configKey
     */
    public function __construct($configKey)
    {
        $this->configKey = $configKey;
    }

    /**
     * Creates the ZendPsrLog logger.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (!empty($this->configKey)) {
            $loggerConfig = isset($config['log'][$this->configKey]) ? $config['log'][$this->configKey] : array();
        } else {
            $loggerConfig = isset($config['log']) ? $config['log'] : array();
        }

        return new Logger($loggerConfig);
    }
}
