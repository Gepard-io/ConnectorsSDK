<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Category;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class CategoryTest extends TestCase
{
    public function testCreateCategoryExpectSuccess(): void
    {
        $categoryL10n = [
            new CategoryL10n(
                'Test name (en-GB)',
                'en-GB',
                'Test desc (en-GB)',
                ['keyword en-GB']
            ),
            new CategoryL10n(
                'Test name (es-ES)',
                'es-ES',
                'Test desc (es-ES)',
                ['keyword es-ES']
            ),
        ];
        $category = new Category('testId', $categoryL10n, 'testParentId', '10101501');
        $category
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $categoryData = $category->toArray();

        self::assertSame('testId', $category->getId());
        self::assertSame('testParentId', $category->getParentId());
        self::assertSame('10101501', $category->getUnspsc());
        self::assertSame('value1', $category->getExtraItemByKey('key1'));
        self::assertSame('value2', $category->getExtraItemByKey('key2'));
        self::assertContainsOnlyInstancesOf(CategoryL10n::class, $category->getL10n());
        self::assertSame('Test name (en-GB)', $categoryL10n[0]->getName());
        self::assertSame('en-GB', $categoryL10n[0]->getLocale());
        self::assertSame('Test desc (en-GB)', $categoryL10n[0]->getDescription());
        self::assertEquals(['keyword en-GB'], $categoryL10n[0]->getKeywords());
        self::assertInstanceOf(CategoryL10n::class, $categoryL10n[0]);
        self::assertSame('Test name (es-ES)', $categoryL10n[1]->getName());
        self::assertSame('es-ES', $categoryL10n[1]->getLocale());
        self::assertSame('Test desc (es-ES)', $categoryL10n[1]->getDescription());
        self::assertEquals(['keyword es-ES'], $categoryL10n[1]->getKeywords());
        self::assertInstanceOf(CategoryL10n::class, $categoryL10n[1]);
        self::assertIsArray($categoryL10n);
        self::assertCount(2, $categoryL10n);
        self::assertSame('testId', $categoryData['id']);
        self::assertSame('testParentId', $categoryData['parentId']);
        self::assertSame('en-GB', $categoryData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $categoryData['l10n']['en-GB']['name']);
        self::assertSame('Test desc (en-GB)', $categoryData['l10n']['en-GB']['description']);
        self::assertEquals(['keyword en-GB'], $categoryData['l10n']['en-GB']['keywords']);
        self::assertSame('es-ES', $categoryData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $categoryData['l10n']['es-ES']['name']);
        self::assertSame('Test desc (es-ES)', $categoryData['l10n']['es-ES']['description']);
        self::assertEquals(['keyword es-ES'], $categoryData['l10n']['es-ES']['keywords']);
    }

    public function testCreateCategoryWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('', [new CategoryL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateCategoryWithWrongL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('testId', [new stdClass()], 'en-GB');
    }

    public function testCreateCategoryWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('testId', []);
    }

    public function testCreateCategoryEmptyParentIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category(
            'testId',
            [new CategoryL10n('Test name (en-GB)', 'en-GB')],
            ''
        );
    }

    public function testCreateCategoryEmptyUnspscExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Category(
            'testId',
            [new CategoryL10n('Test name (en-GB)', 'en-GB')],
            null,
            ''
        );
    }
}
