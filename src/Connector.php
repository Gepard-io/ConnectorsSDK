<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

use Nette\Schema\Schema;
use Psr\Log\LoggerInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;
use RuntimeException;

use function sprintf;
use function is_a;

/**
 * Base class of connector represents the list of query and command connectors.
 * Instantiate the registered query and command connectors by id or class name.
 */
abstract class Connector implements ConnectorInterface
{
    private const CONNECTOR_QUERY_TYPE = 'query';
    private const CONNECTOR_COMMAND_TYPE = 'command';
    public const CONNECTOR_TYPES = [
        self::CONNECTOR_QUERY_TYPE,
        self::CONNECTOR_COMMAND_TYPE,
    ];

    private array $normalizedConnectors = [];

    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Get the input connector instance with the configured settings.
     *
     * @param string $idOrName ID or class name of the input connector.
     * @param array<string, mixed> $settings List of settings.
     *
     * @return ConnectorQueryInterface
     * @throws AssertionFailedException
     */
    public function getQuery(string $idOrName, array $settings = []): ConnectorQueryInterface
    {
        $type = self::CONNECTOR_QUERY_TYPE;
        $this->normalizeConnectorList($type, $this->getQueries());
        Assertion::keyExists(
            $this->normalizedConnectors[$type],
            $idOrName,
            sprintf('Unknown Query: %s', $idOrName)
        );

        /** @var ConnectorQueryInterface $connectorClass */
        $connectorClass = $this->normalizedConnectors[$type][$idOrName];

        return new $connectorClass($this, $this->logger, $settings);
    }

    /**
     * Get the output connector instance with the configured settings.
     *
     * @param string $idOrName ID or class name of the input connector.
     * @param array<string, mixed> $settings List of settings.
     *
     * @return ConnectorCommandInterface
     * @throws AssertionFailedException
     */
    public function getCommand(string $idOrName, array $settings = []): ConnectorCommandInterface
    {
        $type = self::CONNECTOR_COMMAND_TYPE;
        $this->normalizeConnectorList($type, $this->getCommands());
        Assertion::keyExists(
            $this->normalizedConnectors[$type],
            $idOrName,
            sprintf('Unknown Command: %s', $idOrName)
        );

        /** @var ConnectorCommandInterface $connectorClass */
        $connectorClass = $this->normalizedConnectors[$type][$idOrName];

        return new $connectorClass($this, $this->logger, $settings);
    }

    /**
     * Normalize the list of connectors to "ID => class name" and "class name => class name" list.
     *
     * @param string   $type
     * @param string[] $connectorsList
     *
     * @return void
     */
    private function normalizeConnectorList(string $type, array $connectorsList): void
    {
        if (!isset($this->normalizedConnectors[$type])) {
            $oppositeType = $type === self::CONNECTOR_QUERY_TYPE
                ? self::CONNECTOR_COMMAND_TYPE
                : self::CONNECTOR_QUERY_TYPE;

            $this->normalizedConnectors[$type] = [];
            foreach ($connectorsList as $connectorClass) {
                if (is_a($connectorClass, CommandQueryBase::class, true)) {
                    $id = $connectorClass::getId();
                    if (
                        isset($this->normalizedConnectors[$type][$id])
                        || isset($this->normalizedConnectors[$oppositeType][$id])
                    ) {
                        throw new RuntimeException('Connector with same ID already registered: ' . $id);
                    }
                    $this->normalizedConnectors[$type][$id] = $connectorClass;
                    $this->normalizedConnectors[$type][$connectorClass] = $connectorClass;
                } else {
                    throw new RuntimeException('Connector is not an instance of the BaseConnectorInterface');
                }
            }
        }
    }

    /**
     * Get the list of global settings that will be merged with settings of each connector.
     *
     * @return array<string, Schema>
     */
    public function getSettings(): array
    {
        return [];
    }
}
