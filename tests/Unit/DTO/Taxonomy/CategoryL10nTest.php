<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CategoryL10nTest extends TestCase
{
    public function testCreateCategoryL10nExpectSuccess(): void
    {
        $categoryL10n = new CategoryL10n(
            'Test name',
            'en-GB',
            'Test description',
            ['keyword1, keyword2']
        );
        $categoryL10nData = $categoryL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $categoryL10n);
        self::assertSame('Test name', $categoryL10n->getName());
        self::assertSame('en-GB', $categoryL10n->getLocale());
        self::assertSame('Test description', $categoryL10n->getDescription());
        self::assertEquals(['keyword1, keyword2'], $categoryL10n->getKeywords());
        self::assertTrue($categoryL10n->equals(new CategoryL10n('Test name', 'en-GB')));
        self::assertFalse($categoryL10n->equals(new CategoryL10n('Another name', 'es-ES')));
        self::assertIsArray($categoryL10n->toArray());
        self::assertSame('en-GB', $categoryL10nData['locale']);
        self::assertSame('Test name', $categoryL10nData['name']);
        self::assertSame('Test description', $categoryL10nData['description']);
        self::assertEquals(['keyword1, keyword2'], $categoryL10nData['keywords']);
    }

    public function testCreateCategoryL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryL10n('', 'en-GB');
    }

    public function testCreateCategoryL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryL10n('Name', '');
    }
}
