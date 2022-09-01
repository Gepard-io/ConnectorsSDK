<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit;

use GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors\TestConnector;
use GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors\TestQuery;
use InvalidArgumentException;
use League\Config\Exception\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

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
            'brand' => '',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getQuery(TestQuery::class, $settings);
        $query->execute()->current();
    }

    public function testCreateConnectorQueryWithoutProductId(): void
    {
        $settings = [
            'user' => 'testUser',
            'password' => 'secret',
            'category' => 'testCategory',
        ];
        $connector = new TestConnector(new NullLogger());
        $query = $connector->getQuery(TestQuery::getId(), $settings);
        $query->execute()->current();
        $payload = $query->execute()->current();

        self::assertEquals('queryId', $query::getId());
        self::assertEquals('Query description', $query::getDescription());
        self::assertEquals('testCategory', $payload->get('category'));
        self::assertEquals('DEFAULT-BRAND', $payload->get('brand'));
        self::assertEquals(null, $payload->get('productId'));
    }
}
