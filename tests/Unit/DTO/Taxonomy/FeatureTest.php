<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValue;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValueL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Unit;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\UnitL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class FeatureTest extends TestCase
{
    public function testCreateFeatureExpectSuccess(): void
    {
        $featureL10n = [
            new FeatureL10n('Test name (en-GB)', 'en-GB'),
            new FeatureL10n('Test name (es-ES)', 'es-ES'),
        ];
        $altUnits = [
            $this->createUnit('unitId1', 'Test unit name (en-GB)', 'en-GB'),
            $this->createUnit('unitId2', 'Test unit name (es-ES)', 'es-ES'),
        ];
        $feature = new Feature('testId', Feature::TYPE_NUMERIC, $featureL10n, $altUnits);
        $feature
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $featureData = $feature->toArray();

        self::assertSame('testId', $feature->getId());
        self::assertSame(Feature::TYPE_NUMERIC, $feature->getType());
        self::assertSame('value1', $feature->getExtraItemByKey('key1'));
        self::assertSame('value2', $feature->getExtraItemByKey('key2'));
        self::assertIsArray($feature->getL10n());
        self::assertContainsOnlyInstancesOf(FeatureL10n::class, $feature->getL10n());
        self::assertCount(2, $feature->getL10n());
        self::assertIsArray($feature->getUnits());
        self::assertCount(2, $feature->getUnits());
        self::assertEmpty($feature->getAllowedValues());
        self::assertSame('Test name (en-GB)', $featureL10n[0]->getName());
        self::assertSame('en-GB', $featureL10n[0]->getLocale());
        self::assertInstanceOf(FeatureL10n::class, $featureL10n[0]);
        self::assertSame('Test name (es-ES)', $featureL10n[1]->getName());
        self::assertSame('es-ES', $featureL10n[1]->getLocale());
        self::assertInstanceOf(FeatureL10n::class, $featureL10n[1]);
        self::assertSame('testId', $featureData['id']);
        self::assertSame('en-GB', $featureData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $featureData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $featureData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $featureData['l10n']['es-ES']['name']);
    }

    public function testCreateFeatureWithValuesExpectSuccess(): void
    {
        $feature = new Feature(
            'featureId',
            Feature::TYPE_SELECT,
            [new FeatureL10n('Test name (en-GB)', 'en-GB')],
            [],
            [
                $this->createFeatureValue('1', 'First', 'en-GB'),
                $this->createFeatureValue('2', 'Second', 'es-ES'),
            ]
        );

        self::assertTrue($feature->hasAllowedValues());
        self::assertIsArray($feature->getAllowedValues());
        self::assertCount(2, $feature->getAllowedValues());
        self::assertContainsOnlyInstancesOf(FeatureValue::class, $feature->getAllowedValues());
    }

    public function testCreateFeatureWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature('', Feature::TYPE_TEXT, [new FeatureL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateFeatureWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature('testId', Feature::TYPE_TEXT, []);
    }

    public function testCreateFeatureWithWrongL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature('testId', Feature::TYPE_TEXT, [new stdClass()]);
    }

    public function testCreateFeatureWithWrongTypeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature('testId', 'wrong type', [new FeatureL10n('name', 'en-GB')]);
    }

    private function createFeatureValue(string $id, string $name, string $locale): FeatureValue
    {
        return new FeatureValue($id, [new FeatureValueL10n($name, $locale)]);
    }

    private function createUnit(string $id, string $name, string $locale): Unit
    {
        return new Unit($id, [new UnitL10n($name, $locale)]);
    }
}
