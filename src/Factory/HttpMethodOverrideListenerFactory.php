<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\ContentNegotiation\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ApiTools\ContentNegotiation\ContentNegotiationOptions;
use Laminas\ApiTools\ContentNegotiation\HttpMethodOverrideListener;

class HttpMethodOverrideListenerFactory
{
    /**
     * @return HttpMethodOverrideListener
     */
    public function __invoke(ContainerInterface $container)
    {
        $options             = $container->get(ContentNegotiationOptions::class);
        $httpOverrideMethods = $options->getHttpOverrideMethods();
        return new HttpMethodOverrideListener($httpOverrideMethods);
    }
}
