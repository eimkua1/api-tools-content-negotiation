<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\ContentNegotiation\Factory;

use Laminas\ApiTools\ContentNegotiation\AcceptListener;
use Laminas\Mvc\Controller\Plugin\AcceptableViewModelSelector;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class AcceptListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = array();

        if ($serviceLocator->has('Config')) {
            $appConfig = $serviceLocator->get('Config');
            if (isset($appConfig['api-tools-content-negotiation'])
                && is_array($appConfig['api-tools-content-negotiation'])
            ) {
                $config = $appConfig['api-tools-content-negotiation'];
            }
        }

        $selector = null;
        if ($serviceLocator->has('ControllerPluginManager')) {
            $plugins = $serviceLocator->get('ControllerPluginManager');
            if ($plugins->has('AcceptableViewModelSelector')) {
                $selector = $plugins->get('AcceptableViewModelSelector');
            }
        }

        if (null === $selector) {
            $selector = new AcceptableViewModelSelector();
        }

        return new AcceptListener($selector, $config);
    }
}
