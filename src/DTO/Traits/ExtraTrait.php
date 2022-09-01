<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Traits;

/**
 * Additional fields containing custom product and taxonomy data.
 */
trait ExtraTrait
{
    /**
     * @var array<string, mixed>
     */
    protected array $extra = [];

    /**
     * Get the list of extra.
     *
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getExtraItemByKey(string $key): mixed
    {
        return $this->extra[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed  $data
     *
     * @return self
     */
    public function setExtraItemByKey(string $key, mixed $data): self
    {
        $this->extra[$key] = $data;

        return $this;
    }
}
