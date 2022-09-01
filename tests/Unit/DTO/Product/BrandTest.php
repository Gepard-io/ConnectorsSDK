<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Brand;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\BrandL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BrandTest extends TestCase
{
    public function testCreateBrandExpectSuccess(): void
    {
        $brandL10n = [
            new BrandL10n('Test brand (en-GB)', 'en-GB'),
            new BrandL10n('Test brand (es-ES)', 'es-ES'),
        ];
        $brand = new Brand('testId', ...$brandL10n);
        $brand
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('testId', $brand->getId());
        self::assertSame('value1', $brand->getExtraItemByKey('key1'));
        self::assertSame('value2', $brand->getExtraItemByKey('key2'));
        self::assertContainsOnlyInstancesOf(BrandL10n::class, $brand->getL10n());
        self::assertSame('Test brand (en-GB)', $brandL10n[0]->getName());
        self::assertSame('en-GB', $brandL10n[0]->getLocale());
        self::assertInstanceOf(BrandL10n::class, $brandL10n[0]);
        self::assertSame('Test brand (es-ES)', $brandL10n[1]->getName());
        self::assertSame('es-ES', $brandL10n[1]->getLocale());
        self::assertInstanceOf(BrandL10n::class, $brandL10n[1]);
        self::assertIsArray($brandL10n);
        self::assertCount(2, $brandL10n);
    }

    public function testCreateBrandWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Brand('', new BrandL10n('Test brand (en-GB)', 'en-GB'));
    }

    public function testCreateBrandWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Brand('testId');
    }
}
