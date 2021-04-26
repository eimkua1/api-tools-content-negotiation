<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\TestAsset;

use Laminas\EventManager\EventManagerInterface;

class EventTarget
{
    /** @var EventManagerInterface */
    public $events;

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->events;
    }
}
