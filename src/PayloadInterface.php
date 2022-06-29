<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Represents the Payload data object used in query and command connectors.
 * For query connectors, PayloadInterface is returned from the execute method .
 * For connector connectors, PayloadInterface is used as a parameter of execute method and returns as a result.
 */
interface PayloadInterface extends ArrayAccess, IteratorAggregate, Countable
{
    /**
     * Convert the payload data into an array.
     *
     * @return array
     */
    public function toArray(): array;
}
