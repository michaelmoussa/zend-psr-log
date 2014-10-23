<?php
/**
 * Zend PSR Log
 *
 * @link      http://github.com/michaelmoussa/zend-psr-log
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
namespace ZendPsrLog;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Standard ZF2 module class to make ZendPsrLog available as a module
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     *
     * @return array|mixed|\Traversable
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../config/service.config.php';
    }
}
