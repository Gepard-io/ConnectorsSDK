<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use Nette\Schema\Schema;

/**
 * Describes the interface of query connectors for receiving data.
 */
interface ConnectorQueryInterface
{
    /**
     * Get a unique ID of the connector configuration.
     *
     * @return string
     */
    public static function getId(): string;

    /**
     * Get the connector description.
     *
     * @return string
     */
    public static function getDescription(): string;

    /**
     * Get the connector specific settings.
     *
     * @return array<string, Schema>
     */
    public function getSettings(): array;

    /**
     * Execute the query connector. Should return DTOs.
     *
     * @return iterable
     */
    public function execute(): iterable;
}
