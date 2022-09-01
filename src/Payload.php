<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use ArrayIterator;
use Traversable;

use function count;

/**
 * Payload data used in query and command connectors.
 *
 * @template TKey of array-key
 * @template TValue
 *
 */
final class Payload implements PayloadInterface
{
    /**
     * @param  array<TKey, TValue> $payloadItems
     */
    public function __construct(protected array $payloadItems = [])
    {
        foreach ($payloadItems as $key => $value) {
            $this->payloadItems[$key] = $value;
        }
    }

    /**
     * Convert the payload instance into an array.
     */
    public function toArray(): array
    {
        return $this->payloadItems;
    }

    /**
     * Get an attribute from the payload instance.
     *
     * @template TGetDefault
     *
     * @param  TKey  $key
     * @param  TGetDefault|(\Closure(): TGetDefault)  $default
     * @return TValue|TGetDefault
     */
    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->has($key) ? $this->payloadItems[$key] : $default;
    }

    public function set(mixed $key, $value): self
    {
        $this->payloadItems[$key] = $value;

        return $this;
    }

    public function has(mixed $key): bool
    {
        return isset($this->payloadItems[$key]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->payloadItems);
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  TKey  $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Get the value for the given offset.
     *
     * @param  TKey  $offset
     * @return TValue|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set the value for the given offset.
     *
     * @param  TKey  $offset
     * @param  TValue  $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * Unset the value for the given offset.
     *
     * @param  TKey  $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->payloadItems[$offset]);
    }

    public function count(): int
    {
        return count($this->payloadItems);
    }
}
