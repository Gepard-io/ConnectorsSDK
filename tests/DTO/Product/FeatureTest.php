<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Feature;
use GepardIO\ConnectorsSDK\DTO\Product\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryFeature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature as TaxonomyFeature;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FeatureTest extends TestCase
{
    public function testCreateFeatureExpectSuccess(): void
    {
        $featureL10n = [
            new FeatureL10n('Test feature (en-GB)', 'en-GB', 'Value (en-GB)'),
            new FeatureL10n('Test feature (es-ES)', 'es-ES', 'Value (es-ES)'),
        ];
        $feature = new Feature(
            'testId',
            'categoryId',
            TaxonomyFeature::TYPE_TEXT,
            CategoryFeature::PRIORITY_MANDATORY,
            $featureL10n,
            'unitId',
            'featureGroupId'
        );
        $feature
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('testId', $feature->getId());
        self::assertSame('categoryId', $feature->getCategoryId());
        self::assertSame(TaxonomyFeature::TYPE_TEXT, $feature->getType());
        self::assertSame(CategoryFeature::PRIORITY_MANDATORY, $feature->getPriority());
        self::assertSame('unitId', $feature->getUnitId());
        self::assertSame('featureGroupId', $feature->getFeatureGroupId());
        self::assertContainsOnlyInstancesOf(FeatureL10n::class, $feature->getL10n());
        self::assertIsArray($featureL10n);
        self::assertCount(2, $featureL10n);
        self::assertSame('value1', $feature->getExtraItemByKey('key1'));
        self::assertSame('value2', $feature->getExtraItemByKey('key2'));
    }

    public function testCreateFeatureWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature(
            '',
            'categoryId',
            TaxonomyFeature::TYPE_TEXT,
            CategoryFeature::PRIORITY_MANDATORY,
            [new FeatureL10n('Test feature (en-GB)', 'en-GB', 'Value')],
            'unitId',
            'featureGroupId'
        );
    }

    public function testCreateFeatureWithEmptyCategoryIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature(
            'testId',
            '',
            TaxonomyFeature::TYPE_TEXT,
            CategoryFeature::PRIORITY_MANDATORY,
            [new FeatureL10n('Test feature (en-GB)', 'en-GB', 'Value')],
            'unitId',
            'featureGroupId'
        );
    }

    public function testCreateFeatureWithWrongTypeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature(
            'testId',
            'categoryId',
            'wrong type',
            CategoryFeature::PRIORITY_MANDATORY,
            [new FeatureL10n('Test feature (en-GB)', 'en-GB', 'Value')],
            'unitId',
            'featureGroupId'
        );
    }

    public function testCreateFeatureWithWrongPriorityExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Feature(
            'testId',
            'categoryId',
            TaxonomyFeature::TYPE_TEXT,
            'wrong priority',
            [new FeatureL10n('Test feature (en-GB)', 'en-GB', 'Value')],
            'unitId',
            'featureGroupId'
        );
    }
}
