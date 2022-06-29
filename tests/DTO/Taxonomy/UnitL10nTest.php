<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\UnitL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class UnitL10nTest extends TestCase
{
    public function testCreateUnitL10nExpectSuccess(): void
    {
        $seriesL10n = new UnitL10n('Name', 'en-GB', 'Description', 'Sign');
        $seriesL10nData = $seriesL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $seriesL10n);
        self::assertSame('Name', $seriesL10n->getName());
        self::assertSame('en-GB', $seriesL10n->getLocale());
        self::assertSame('Description', $seriesL10n->getDescription());
        self::assertSame('Sign', $seriesL10n->getSign());
        self::assertTrue($seriesL10n->equals(new UnitL10n('Name', 'en-GB')));
        self::assertFalse($seriesL10n->equals(new UnitL10n('Another name', 'es-ES')));
        self::assertIsArray($seriesL10n->toArray());
        self::assertSame('en-GB', $seriesL10nData['locale']);
        self::assertSame('Name', $seriesL10nData['name']);
        self::assertSame('Description', $seriesL10nData['description']);
        self::assertSame('Sign', $seriesL10nData['sign']);
    }

    public function testCreateUnitL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UnitL10n('', 'en-GB');
    }

    public function testCreateUnitL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UnitL10n('Name', '');
    }
}
