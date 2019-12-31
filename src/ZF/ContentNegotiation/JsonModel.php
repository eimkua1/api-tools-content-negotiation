<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\ContentNegotiation;

use JsonSerializable;
use Laminas\ApiTools\Hal\Collection as HalCollection;
use Laminas\ApiTools\Hal\Entity as HalEntity;
use Laminas\Json\Json;
use Laminas\Stdlib\JsonSerializable as StdlibJsonSerializable;
use Laminas\View\Model\JsonModel as BaseJsonModel;

class JsonModel extends BaseJsonModel
{
    /**
     * Mark view model as terminal by default (intended for use with APIs)
     *
     * @var bool
     */
    protected $terminate = true;

    /**
     * Set variables
     *
     * Overrides parent to extract variables from JsonSerializable objects.
     *
     * @param  array|Traversable|JsonSerializable|StdlibJsonSerializable $variables
     * @param  bool $overwrite
     * @return self
     */
    public function setVariables($variables, $overwrite = false)
    {
        if ($variables instanceof JsonSerializable
            || $variables instanceof StdlibJsonSerializable
        ) {
            $variables = $variables->jsonSerialize();
        }
        return parent::setVariables($variables, $overwrite);
    }

    /**
     * Override setTerminal()
     *
     * Becomes a no-op; this model should always be terminal.
     *
     * @param  bool $flag
     * @return self
     */
    public function setTerminal($flag)
    {
        // Do nothing; should always terminate
        return $this;
    }

    /**
     * Override serialize()
     *
     * Tests for the special top-level variable "payload", set by Laminas\ApiTools\Rest\RestController.
     *
     * If discovered, the value is pulled and used as the variables to serialize.
     *
     * A further check is done to see if we have a Laminas\ApiTools\Hal\Entity or
     * Laminas\ApiTools\Hal\Collection, and, if so, we pull the top-level entity or
     * collection and serialize that.
     *
     * @return string
     */
    public function serialize()
    {
        $variables = $this->getVariables();

        // 'payload' == Laminas\ApiTools\Rest\RestController payload
        if (isset($variables['payload'])) {
            $variables = $variables['payload'];
        }

        // Use Laminas\ApiTools\Hal\Entity's composed entity
        if ($variables instanceof HalEntity) {
            $variables = $variables->entity;
        }

        // Use Laminas\ApiTools\Hal\Collection's composed collection
        if ($variables instanceof HalCollection) {
            $variables = $variables->getCollection();
        }

        if ($variables instanceof Traversable) {
            $variables = ArrayUtils::iteratorToArray($variables);
        }

        if (null !== $this->jsonpCallback) {
            return $this->jsonpCallback.'('.Json::encode($variables).');';
        }
        return Json::encode($variables);
    }
}