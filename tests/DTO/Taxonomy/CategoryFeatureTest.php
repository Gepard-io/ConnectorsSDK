<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Category;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryFeature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureGroup;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureGroupL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Unit;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\UnitL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CategoryFeatureTest extends TestCase
{
    private Feature $feature;
    private Category $category;
    private Unit $unit;
    private FeatureGroup $featureGroup;

    protected function setUp(): void
    {
        $this->feature = new Feature(
            'featureId',
            Feature::TYPE_TEXT,
            [new FeatureL10n('name', 'en-GB')]
        );
        $this->category = new Category(
            'categoryId',
            [new CategoryL10n('name', 'en-GB')]
        );
        $this->unit = new Unit(
            'unitId',
            [new UnitL10n('name', 'en-GB')]
        );
        $this->featureGroup = new FeatureGroup(
            'featureGroupId',
            [new FeatureGroupL10n('name', 'en-GB')]
        );
    }

    public function testCreateCategoryFeatureExpectSuccess(): void
    {
        $categoryFeature = new CategoryFeature(
            'testId',
            CategoryFeature::PRIORITY_MANDATORY,
            $this->feature,
            $this->category,
            $this->unit,
            $this->featureGroup
        );
        $categoryFeature
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $categoryFeatureData = $categoryFeature->toArray();

        self::assertSame('testId', $categoryFeature->getId());
        self::assertSame(CategoryFeature::PRIORITY_MANDATORY, $categoryFeature->getPriority());
        self::assertSame('value1', $categoryFeature->getExtraItemByKey('key1'));
        self::assertSame('value2', $categoryFeature->getExtraItemByKey('key2'));
        self::assertSame('testId', $categoryFeatureData['id']);
        self::assertSame('categoryId', $categoryFeatureData['categoryId']);
        self::assertSame('featureId', $categoryFeatureData['featureId']);
        self::assertSame('unitId', $categoryFeatureData['unitId']);
        self::assertSame('featureGroupId', $categoryFeatureData['featureGroupId']);
    }

    public function testCreateCategoryFeatureWithoutFeatureGroupExpectSuccess(): void
    {
        $categoryFeature = new CategoryFeature(
            'testId',
            CategoryFeature::PRIORITY_MANDATORY,
            $this->feature,
            $this->category,
            $this->unit
        );
        $categoryFeatureData = $categoryFeature->toArray();

        self::assertNull($categoryFeature->getFeatureGroup());
        self::assertFalse($categoryFeature->hasFeatureGroup());
        self::assertNull($categoryFeatureData['featureGroupId']);
    }

    public function testCreateCategoryFeatureWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryFeature(
            '',
            CategoryFeature::PRIORITY_MANDATORY,
            $this->feature,
            $this->category,
            $this->unit
        );
    }
}
