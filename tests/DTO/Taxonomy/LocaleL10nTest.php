<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\LocaleL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LocaleL10nTest extends TestCase
{
    public function testCreateLocaleL10nExpectSuccess(): void
    {
        $seriesL10n = new LocaleL10n('English', 'en-GB');
        $seriesL10nData = $seriesL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $seriesL10n);
        self::assertSame('English', $seriesL10n->getName());
        self::assertSame('en-GB', $seriesL10n->getLocale());
        self::assertTrue($seriesL10n->equals(new LocaleL10n('English', 'en-GB')));
        self::assertFalse($seriesL10n->equals(new LocaleL10n('Spanish', 'es-ES')));
        self::assertIsArray($seriesL10n->toArray());
        self::assertSame('en-GB', $seriesL10nData['locale']);
        self::assertSame('English', $seriesL10nData['name']);
    }

    public function testCreateLanguageL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LocaleL10n('', 'en-GB');
    }

    public function testCreateLanguageL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LocaleL10n('Name', '');
    }
}
