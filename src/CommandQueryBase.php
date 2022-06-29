<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use League\Config\Configuration;
use League\Config\ReadOnlyConfiguration;
use Nette\Schema\Schema;
use Psr\Log\LoggerInterface;

use function array_merge;

/**
 * Base command and query class.
 */
abstract class CommandQueryBase
{
    protected ReadOnlyConfiguration $config;

    /**
     * Get a unique ID of the connector configuration.
     *
     * @return string
     */
    abstract public static function getId(): string;

    /**
     * @param ConnectorInterface   $connector
     * @param LoggerInterface      $logger
     * @param array<string, mixed> $settings
     */
    public function __construct(
        protected ConnectorInterface $connector,
        protected LoggerInterface $logger,
        array $settings = []
    ) {
        $allSettings = array_merge($connector->getSettings(), $this->getSettings());
        $config = new Configuration($allSettings);
        $config->merge($settings);
        $this->config = new ReadOnlyConfiguration($config);
    }

    /**
     * Get the connector specific settings.
     *
     * @return array<string, Schema>
     */
    public function getSettings(): array
    {
        return [];
    }
}
