<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use Nette\Schema\Schema;

/**
 * Describes the connector interface.
 */
interface ConnectorCommandInterface
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
     * Execute the connector command.
     *
     * @param PayloadInterface $payload
     *
     * @return PayloadInterface|null
     */
    public function execute(PayloadInterface $payload): ?PayloadInterface;
}
