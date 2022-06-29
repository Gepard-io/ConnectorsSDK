<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Traits;

/**
 * An additional field with string values
 */
trait TagsTrait
{
    /**
     * Get tags
     *
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
