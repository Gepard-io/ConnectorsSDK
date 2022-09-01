<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Family;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FamilyL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Series;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\SeriesL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class FamilyTest extends TestCase
{
    public function testCreateFamilyExpectSuccess(): void
    {
        $familyL10n = [
            new FamilyL10n('Test name (en-GB)', 'en-GB'),
            new FamilyL10n('Test name (es-ES)', 'es-ES'),
        ];
        $family = new Family('testId', $familyL10n);
        $family
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $familyData = $family->toArray();

        self::assertSame('testId', $family->getId());
        self::assertSame('value1', $family->getExtraItemByKey('key1'));
        self::assertSame('value2', $family->getExtraItemByKey('key2'));
        self::assertSame('Test name (en-GB)', $familyL10n[0]->getName());
        self::assertIsArray($familyL10n);
        self::assertCount(2, $familyL10n);
        self::assertContainsOnlyInstancesOf(FamilyL10n::class, $family->getL10n());
        self::assertSame('en-GB', $familyL10n[0]->getLocale());
        self::assertInstanceOf(FamilyL10n::class, $familyL10n[0]);
        self::assertSame('Test name (es-ES)', $familyL10n[1]->getName());
        self::assertSame('es-ES', $familyL10n[1]->getLocale());
        self::assertInstanceOf(FamilyL10n::class, $familyL10n[1]);
        self::assertSame('testId', $familyData['id']);
        self::assertSame('en-GB', $familyData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $familyData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $familyData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $familyData['l10n']['es-ES']['name']);
    }

    public function testCreateFamilyWithSeriesExpectSuccess(): void
    {
        $seriesL10n = [
            new SeriesL10n('Test name (en-GB)', 'en-GB'),
            new SeriesL10n('Test name (es-ES)', 'es-ES'),
        ];
        $series = new Series('testId', $seriesL10n);
        $family = new Family(
            'featureId',
            [new FamilyL10n('Test name (en-GB)', 'en-GB')],
            [$series]
        );

        self::assertTrue($family->hasSeries());
        self::assertIsArray($family->getSeries());
        self::assertNotEmpty($family->getSeries());
        self::assertCount(1, $family->getSeries());
    }

    public function testCreateFamilyWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Family('', [new FamilyL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateFamilyWithWrongL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Family('testId', [new stdClass()]);
    }

    public function testCreateFamilyWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Family('testId', []);
    }
}
