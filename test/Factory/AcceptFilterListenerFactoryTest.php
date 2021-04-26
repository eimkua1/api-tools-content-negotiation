<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\Factory;

use Laminas\ApiTools\ContentNegotiation\AcceptFilterListener;
use Laminas\ApiTools\ContentNegotiation\ContentNegotiationOptions;
use Laminas\ApiTools\ContentNegotiation\Factory\AcceptFilterListenerFactory;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

class AcceptFilterListenerFactoryTest extends TestCase
{
    public function testCreateServiceShouldReturnAcceptFilterListenerInstance()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            ContentNegotiationOptions::class,
            new ContentNegotiationOptions()
        );

        $factory = new AcceptFilterListenerFactory();

        $service = $factory($serviceManager, 'AcceptFilterListener');

        $this->assertInstanceOf(AcceptFilterListener::class, $service);
    }
}
