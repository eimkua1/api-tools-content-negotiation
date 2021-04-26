<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation\TestAsset;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Stdlib\RequestInterface as Request;

class ContentTypeController extends AbstractActionController
{
    /**
     * @param Request $request
     * @return void
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
