<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use Nette\Schema\Schema;

/**
 * Connector interface.
 */
interface ConnectorInterface
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
     * Get the list of query connectors as the list of classnames.
     *
     * @return string[]
     */
    public function getQueries(): array;

    /**
     * Get the list of command connectors as the list of classnames.
     *
     * @return string[]
     */
    public function getCommands(): array;
}
