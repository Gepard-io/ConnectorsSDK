<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit;

use GepardIO\ConnectorsSDK\Payload;
use GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors\TestCommand;
use GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors\TestConnector;
use InvalidArgumentException;
use League\Config\Exception\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ConnectorCommandTest extends TestCase
{
    public function testCreateConnectorQueryExpectSuccess(): void
    {
        $settings = [
            'user' => 'testUser',
            'password' => 'secret',
            'format' => 'json',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getCommand(TestCommand::class, $settings);
        $payload = $query->execute(new Payload());

        self::assertEquals('connectorId', $connector::getId());
        self::assertEquals('Connector description', $connector::getDescription());
        self::assertEquals('commandId', $query::getId());
        self::assertEquals('Command description', $query::getDescription());
        self::assertEquals('json', $payload->get('format'));
        self::assertEquals('newId', $payload->get('productId'));
    }

    public function testCreateConnectorUnknownCommandExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $connector = new TestConnector(new NullLogger());
        $connector->getQuery('undefinedQuery', ['undefinedSetting' => 'test']);
    }

    public function testCreateConnectorCommandWithoutRequiredSettingExpectException(): void
    {
        $this->expectException(ValidationException::class);
        $settings = [
            'user' => 'testUser',
            'password' => 'secret',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getCommand(TestCommand::class, $settings);
        $query->execute(new Payload());
    }
}
