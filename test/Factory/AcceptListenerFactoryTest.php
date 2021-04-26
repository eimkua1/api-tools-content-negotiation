<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\Factory;

use Laminas\ApiTools\ContentNegotiation\AcceptListener;
use Laminas\ApiTools\ContentNegotiation\ContentNegotiationOptions;
use Laminas\ApiTools\ContentNegotiation\Factory\AcceptListenerFactory;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

class AcceptListenerFactoryTest extends TestCase
{
    public function testCreateServiceShouldReturnAcceptListenerInstance()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            ContentNegotiationOptions::class,
            new ContentNegotiationOptions()
        );

        $factory = new AcceptListenerFactory();

        $service = $factory($serviceManager, 'AcceptListener');

        $this->assertInstanceOf(AcceptListener::class, $service);
    }
}
