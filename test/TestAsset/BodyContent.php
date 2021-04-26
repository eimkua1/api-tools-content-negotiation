<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\TestAsset;

use function json_encode;

class BodyContent
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) json_encode(['foo' => 'bar']);
    }
}
