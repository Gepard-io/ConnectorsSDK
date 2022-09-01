<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\SeriesL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SeriesL10nTest extends TestCase
{
    public function testCreateSeriesL10nExpectSuccess(): void
    {
        $seriesL10n = new SeriesL10n('Name', 'en-GB');
        $seriesL10nData = $seriesL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $seriesL10n);
        self::assertSame('Name', $seriesL10n->getName());
        self::assertSame('en-GB', $seriesL10n->getLocale());
        self::assertTrue($seriesL10n->equals(new SeriesL10n('Name', 'en-GB')));
        self::assertFalse($seriesL10n->equals(new SeriesL10n('Another name', 'es-ES')));
        self::assertIsArray($seriesL10n->toArray());
        self::assertSame('en-GB', $seriesL10nData['locale']);
        self::assertSame('Name', $seriesL10nData['name']);
    }

    public function testCreateSeriesL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SeriesL10n('', 'en-GB');
    }

    public function testCreateSeriesL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SeriesL10n('Name', '');
    }
}
