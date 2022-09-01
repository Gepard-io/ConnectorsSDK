<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\BulletPoint;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BulletPointTest extends TestCase
{
    public function testCreateBulletPointsExpectSuccess(): void
    {
        $bulletPoint = new BulletPoint('en-GB', ['bullet point1', 'bullet point2']);
        $bulletPoint
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('en-GB', $bulletPoint->getLocale());
        self::assertSame('value1', $bulletPoint->getExtraItemByKey('key1'));
        self::assertSame('value2', $bulletPoint->getExtraItemByKey('key2'));
        self::assertIsArray($bulletPoint->getValues());
        self::assertCount(2, $bulletPoint->getValues());
        self::assertEqualsCanonicalizing(['bullet point1', 'bullet point2'], $bulletPoint->getValues());
    }

    public function testCreateBulletPointsWithDuplicateValuesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BulletPoint('en-GB', ['bullet point1', 'bullet point1']);
    }

    public function testCreateBulletPointsWithEmptyArrayValuesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BulletPoint('en-GB', []);
    }

    public function testCreateBulletPointsWithEmptyValueExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BulletPoint('en-GB', ['', 'bullet point']);
    }

    public function testCreateBulletPointsWithNotStringValuesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BulletPoint('en-GB', [10, 'bullet point']);
    }

    public function testCreateBulletPointsWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BulletPoint('', ['bullet point1']);
    }
}
