<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Commerce;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CommerceTest extends TestCase
{
    public function testCreateCommerceExpectSuccess(): void
    {
        $commerce = new Commerce('en-GB', 770, 1, 2100, 'usd');
        $commerce
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('en-GB', $commerce->getLocale());
        self::assertSame(770, $commerce->getPrice());
        self::assertSame(1, $commerce->getStock());
        self::assertSame(2100, $commerce->getVat());
        self::assertSame('usd', $commerce->getCurrency());
        self::assertSame('value1', $commerce->getExtraItemByKey('key1'));
        self::assertSame('value2', $commerce->getExtraItemByKey('key2'));
    }

    public function testCreateCommerceWithoutOptionalParamsExpectSuccess(): void
    {
        $commerce = new Commerce('en-GB', 770, 0);

        self::assertNull($commerce->getVat());
        self::assertNull($commerce->getCurrency());
    }

    public function testCreateBrandWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Commerce('', 770, 1, 2100, 'usd');
    }

    public function testCreateBrandWithWrongPriceExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Commerce('en-GB', -1, 1, 2100, 'usd');
    }

    public function testCreateBrandWithWrongStockExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Commerce('en-GB', 1, -1, 2100, 'usd');
    }

    public function testCreateBrandWithWrongVatExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Commerce('en-GB', 1, 1, -1, 'usd');
    }

    public function testCreateBrandWithEmptyCurrencyExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Commerce('en-GB', 1, 1, -1, '');
    }
}
