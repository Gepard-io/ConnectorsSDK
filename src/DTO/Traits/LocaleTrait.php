<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Traits;

/**
 * Represents the locale field.
 */
trait LocaleTrait
{
    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }
}
