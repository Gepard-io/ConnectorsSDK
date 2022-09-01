<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Traits;

/**
 * Represents the identifier field.
 */
trait IdentifierTrait
{
    /**
     * Get the identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
