<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\BrandL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BrandL10nTest extends TestCase
{
    public function testCreateBrandL10nExpectSuccess(): void
    {
        $brandL10n = new BrandL10n('Name', 'en-GB');
        $brandL10nData = $brandL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $brandL10n);
        self::assertSame('Name', $brandL10n->getName());
        self::assertSame('en-GB', $brandL10n->getLocale());
        self::assertTrue($brandL10n->equals(new BrandL10n('Name', 'en-GB')));
        self::assertFalse($brandL10n->equals(new BrandL10n('Another name', 'es-ES')));
        self::assertIsArray($brandL10n->toArray());
        self::assertSame('en-GB', $brandL10nData['locale']);
        self::assertSame('Name', $brandL10nData['name']);
    }

    public function testCreateBrandL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BrandL10n('', 'en-GB');
    }

    public function testCreateBrandL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new BrandL10n('Name', '');
    }
}
