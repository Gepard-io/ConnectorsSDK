<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Brand;
use GepardIO\ConnectorsSDK\DTO\Product\BulletPoint;
use GepardIO\ConnectorsSDK\DTO\Product\Category;
use GepardIO\ConnectorsSDK\DTO\Product\Commerce;
use GepardIO\ConnectorsSDK\DTO\Product\Description;
use GepardIO\ConnectorsSDK\DTO\Product\Feature;
use GepardIO\ConnectorsSDK\DTO\Product\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Product\Identifier;
use GepardIO\ConnectorsSDK\DTO\Product\Image;
use GepardIO\ConnectorsSDK\DTO\Product\ImageItem;
use GepardIO\ConnectorsSDK\DTO\Product\Media;
use GepardIO\ConnectorsSDK\DTO\Product\Product;
use GepardIO\ConnectorsSDK\DTO\Product\ProductBuilder;
use GepardIO\ConnectorsSDK\DTO\Product\ReasonToBuy;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\BrandL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryFeature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature as TaxonomyFeature;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testCreateProductExpectSuccess(): void
    {
        $productBuilder = new ProductBuilder(
            new Identifier('testId', 'test-mpn'),
            new Brand('brandId', new BrandL10n('Brand name', 'en-GB')),
            new Category('categoryId', new CategoryL10n('Category name', 'en-GB')),
            'Model name'
        );
        $product = $productBuilder
            ->setDescriptions(
                new Description('en-GB', 'Title en-GB', 'Short en-GB', 'Long en-GB'),
                new Description('es-ES', 'Title es-ES', 'Short es-ES', 'Long es-ES'),
            )
            ->setReasonsToBuy(
                new ReasonToBuy('testId1', 'en-GB', 'Title en-GB', 'Value 1', 1),
                new ReasonToBuy('testId2', 'es-ES', 'Title es-ES', 'Value 2', 2),
            )
            ->setBulletPoints(
                new BulletPoint('en-GB', ['bullet point1 en-GB', 'bullet point2 en-GB']),
                new BulletPoint('es-ES', ['bullet point1 es-ES', 'bullet point2 es-ES']),
            )
            ->setMedia(
                $this->createMedia('https://company.test/leaflet1.pdf'),
                $this->createMedia('https://company.test/leaflet2.pdf'),
            )
            ->setGallery(
                $this->createImage('https://img.com/picture1.jpg', 1, true),
                $this->createImage('https://img.com/picture2.jpg', 2, false),
            )
            ->setFeatures(
                $this->createFeature('featureId1', 'Name1', 'en-GB', 'Value1'),
                $this->createFeature('featureId2', 'Name2', 'es-ES', 'Value2'),
            )
            ->setCommerces(
                new Commerce('en-GB', 1, 1),
                new Commerce('es-ES', 2, 1),
            )
            ->build();

        self::assertInstanceOf(Product::class, $product);
        self::assertSame('testId', $product->getIdentifier()->getId());
        self::assertSame('test-mpn', $product->getIdentifier()->getMpn());
        self::assertSame('brandId', $product->getBrand()->getId());
        self::assertSame('categoryId', $product->getCategory()->getId());
        self::assertSame('Model name', $product->getModelName());
        self::assertContainsOnlyInstancesOf(Description::class, $product->getDescriptions());
        self::assertCount(2, $product->getDescriptions());
        self::assertContainsOnlyInstancesOf(ReasonToBuy::class, $product->getReasonsToBuy());
        self::assertCount(2, $product->getReasonsToBuy());
        self::assertContainsOnlyInstancesOf(BulletPoint::class, $product->getBulletPoints());
        self::assertCount(2, $product->getBulletPoints());
        self::assertContainsOnlyInstancesOf(Media::class, $product->getMedia());
        self::assertCount(2, $product->getMedia());
        self::assertContainsOnlyInstancesOf(Image::class, $product->getGallery());
        self::assertCount(2, $product->getGallery());
        self::assertContainsOnlyInstancesOf(Feature::class, $product->getFeatures());
        self::assertCount(2, $product->getFeatures());
        self::assertContainsOnlyInstancesOf(Commerce::class, $product->getCommerces());
        self::assertCount(2, $product->getCommerces());
    }

    public function testCreateProductWithoutOptionalParamsExpectSuccess(): void
    {
        $productBuilder = new ProductBuilder(
            new Identifier('testId', 'test-mpn'),
            new Brand('brandId', new BrandL10n('Brand name', 'en-GB')),
            new Category('categoryId', new CategoryL10n('Category name', 'en-GB')),
            'Model name'
        );

        self::assertInstanceOf(Product::class, $productBuilder->build());
    }

    private function createMedia(string $url): Media
    {
        return new Media(
            'leaflet',
            'pdf',
            $url,
            ['en-GB', 'es-ES'],
            'description',
            100
        );
    }

    private function createImage(string $url, int $no, bool $isMain): Image
    {
        return new Image(
            'testId',
            $no,
            $isMain,
            ['en-GB', 'es-ES'],
            new ImageItem(ImageItem::TYPE_HIGH, $url, 1000, 1000, 1000),
        );
    }

    private function createFeature(string $id, string $name, string $locale, string $value): Feature
    {
        return new Feature(
            $id,
            'categoryId',
            TaxonomyFeature::TYPE_TEXT,
            CategoryFeature::PRIORITY_MANDATORY,
            [new FeatureL10n($name, $locale, $value)],
            'unitId'
        );
    }
}
