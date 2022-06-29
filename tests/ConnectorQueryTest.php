<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests;

use GepardIO\ConnectorsSDK\Tests\CommandQueryConnectors\TestQuery;
use GepardIO\ConnectorsSDK\Tests\CommandQueryConnectors\TestConnector;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use InvalidArgumentException;
use League\Config\Exception\ValidationException;

final class ConnectorQueryTest extends TestCase
{
    public function testCreateConnectorQueryExpectSuccess(): void
    {
        $settings = [
            'user' => 'testUser',
            'password' => 'secret',
            'category' => 'testCategory',
            'brand' => 'testBrand',
            'productId' => 'testProductId',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getQuery(TestQuery::class, $settings);
        $payload = $query->execute()->current();

        self::assertEquals('connectorId', $connector::getId());
        self::assertEquals('Connector description', $connector::getDescription());
        self::assertEquals('queryId', $query::getId());
        self::assertEquals('Query description', $query::getDescription());
        self::assertEquals('testCategory', $payload->get('category'));
        self::assertEquals('testBrand', $payload->get('brand'));
        self::assertEquals('testProductId', $payload->get('productId'));
    }

    public function testCreateConnectorUnknownQueryExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $connector = new TestConnector(new NullLogger());
        $connector->getQuery('undefinedQuery', ['undefinedSetting' => 'test']);
    }

    public function testCreateConnectorQueryWithoutRequiredSettingExpectException(): void
    {
        $this->expectException(ValidationException::class);
        $settings = [
            'user' => 'testUser',
            'password' => 'secret',
            'category' => 'testCategory',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getQuery(TestQuery::class, $settings);
        $query->execute()->current();
    }
}
