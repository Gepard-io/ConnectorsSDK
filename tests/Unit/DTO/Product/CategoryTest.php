<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Category;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase
{
    public function testCreateCategoryExpectSuccess(): void
    {
        $categoryL10n = [
            new CategoryL10n('Test category (en-GB)', 'en-GB'),
            new CategoryL10n('Test category (es-ES)', 'es-ES'),
        ];
        $category = new Category('testId', ...$categoryL10n);
        $category
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('testId', $category->getId());
        self::assertSame('value1', $category->getExtraItemByKey('key1'));
        self::assertSame('value2', $category->getExtraItemByKey('key2'));
        self::assertContainsOnlyInstancesOf(CategoryL10n::class, $category->getL10n());
        self::assertSame('Test category (en-GB)', $categoryL10n[0]->getName());
        self::assertSame('en-GB', $categoryL10n[0]->getLocale());
        self::assertInstanceOf(CategoryL10n::class, $categoryL10n[0]);
        self::assertSame('Test category (es-ES)', $categoryL10n[1]->getName());
        self::assertSame('es-ES', $categoryL10n[1]->getLocale());
        self::assertInstanceOf(CategoryL10n::class, $categoryL10n[1]);
        self::assertIsArray($categoryL10n);
        self::assertCount(2, $categoryL10n);
    }

    public function testCreateCategoryWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('', new CategoryL10n('Test category (en-GB)', 'en-GB'));
    }

    public function testCreateCategoryWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('testId');
    }
}
