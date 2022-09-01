<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Series;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\SeriesL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SeriesTest extends TestCase
{
    public function testCreateFamilyExpectSuccess(): void
    {
        $seriesL10n = [
            new SeriesL10n('Test name (en-GB)', 'en-GB'),
            new SeriesL10n('Test name (es-ES)', 'es-ES'),
        ];
        $series = new Series('testId', $seriesL10n);
        $series
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $seriesData = $series->toArray();

        self::assertSame('testId', $series->getId());
        self::assertSame('value1', $series->getExtraItemByKey('key1'));
        self::assertSame('value2', $series->getExtraItemByKey('key2'));
        self::assertIsArray($seriesL10n);
        self::assertCount(2, $seriesL10n);
        self::assertContainsOnlyInstancesOf(SeriesL10n::class, $series->getL10n());
        self::assertSame('Test name (en-GB)', $seriesL10n[0]->getName());
        self::assertSame('en-GB', $seriesL10n[0]->getLocale());
        self::assertInstanceOf(SeriesL10n::class, $seriesL10n[0]);
        self::assertSame('Test name (es-ES)', $seriesL10n[1]->getName());
        self::assertSame('es-ES', $seriesL10n[1]->getLocale());
        self::assertInstanceOf(SeriesL10n::class, $seriesL10n[1]);

        self::assertSame('testId', $seriesData['id']);
        self::assertSame('en-GB', $seriesData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $seriesData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $seriesData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $seriesData['l10n']['es-ES']['name']);
    }

    public function testCreateFamilyWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Series('', [new SeriesL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateFamilyWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Series('testId', []);
    }
}
