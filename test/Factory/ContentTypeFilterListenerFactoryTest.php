<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\Factory;

use Laminas\ApiTools\ContentNegotiation\ContentNegotiationOptions;
use Laminas\ApiTools\ContentNegotiation\ContentTypeFilterListener;
use Laminas\ApiTools\ContentNegotiation\Factory\ContentTypeFilterListenerFactory;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

class ContentTypeFilterListenerFactoryTest extends TestCase
{
    public function testCreateServiceShouldReturnContentTypeFilterListenerInstance()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            ContentNegotiationOptions::class,
            new ContentNegotiationOptions()
        );

        $factory = new ContentTypeFilterListenerFactory();

        $service = $factory($serviceManager, 'ContentTypeFilterListener');

        $this->assertInstanceOf(ContentTypeFilterListener::class, $service);
    }
}
