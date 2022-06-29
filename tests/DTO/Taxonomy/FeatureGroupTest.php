<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureGroup;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureGroupL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class FeatureGroupTest extends TestCase
{
    public function testCreateFeatureGroupExpectSuccess(): void
    {
        $featureGroupL10n = [
            new FeatureGroupL10n('Test name (en-GB)', 'en-GB'),
            new FeatureGroupL10n('Test name (es-ES)', 'es-ES'),
        ];
        $featureGroup = new FeatureGroup('testId', $featureGroupL10n);
        $featureGroup
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $featureGroupData = $featureGroup->toArray();

        self::assertSame('testId', $featureGroup->getId());
        self::assertSame('value1', $featureGroup->getExtraItemByKey('key1'));
        self::assertSame('value2', $featureGroup->getExtraItemByKey('key2'));
        self::assertSame('Test name (en-GB)', $featureGroupL10n[0]->getName());
        self::assertSame('en-GB', $featureGroupL10n[0]->getLocale());
        self::assertContainsOnlyInstancesOf(FeatureGroupL10n::class, $featureGroup->getL10n());
        self::assertInstanceOf(FeatureGroupL10n::class, $featureGroupL10n[0]);
        self::assertSame('Test name (es-ES)', $featureGroupL10n[1]->getName());
        self::assertSame('es-ES', $featureGroupL10n[1]->getLocale());
        self::assertInstanceOf(FeatureGroupL10n::class, $featureGroupL10n[1]);
        self::assertIsArray($featureGroupL10n);
        self::assertCount(2, $featureGroupL10n);
        self::assertSame('testId', $featureGroupData['id']);
        self::assertSame('en-GB', $featureGroupData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $featureGroupData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $featureGroupData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $featureGroupData['l10n']['es-ES']['name']);
    }

    public function testCreateFeatureGroupWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureGroup('', [new FeatureGroupL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateFeatureGroupWithWrongL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureGroup('testId', [new stdClass()]);
    }

    public function testCreateFeatureGroupWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureGroup('testId', []);
    }
}
