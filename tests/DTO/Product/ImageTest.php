<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Image;
use GepardIO\ConnectorsSDK\DTO\Product\ImageItem;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{
    public function testCreateImageExpectSuccess(): void
    {
        $image = new Image(
            'testId',
            1,
            true,
            ['en-GB', 'es-ES'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
            $this->createImageItem(ImageItem::TYPE_MEDIUM, 'https://img.com/medium.jpg'),
            $this->createImageItem(ImageItem::TYPE_LOW, 'https://img.com/low.jpg'),
            $this->createImageItem(ImageItem::TYPE_THUMB, 'https://img.com/thumb.jpg'),
        );
        $image
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('testId', $image->getId());
        self::assertSame(1, $image->getNo());
        self::assertTrue($image->isMain());
        self::assertIsArray($image->getLocales());
        self::assertCount(2, $image->getLocales());
        self::assertEqualsCanonicalizing(['en-GB', 'es-ES'], $image->getLocales());
        self::assertContainsOnlyInstancesOf(ImageItem::class, $image->getImageItems());
        self::assertCount(4, $image->getImageItems());
        $highImage = $image->getImageItemByType(ImageItem::TYPE_HIGH);
        self::assertSame('https://img.com/high.jpg', $highImage->getUrl());
        $mediumImage = $image->getImageItemByType(ImageItem::TYPE_MEDIUM);
        self::assertSame('https://img.com/medium.jpg', $mediumImage->getUrl());
        $lowImage = $image->getImageItemByType(ImageItem::TYPE_LOW);
        self::assertSame('https://img.com/low.jpg', $lowImage->getUrl());
        $thumbImage = $image->getImageItemByType(ImageItem::TYPE_THUMB);
        self::assertSame('https://img.com/thumb.jpg', $thumbImage->getUrl());
        self::assertSame('value1', $image->getExtraItemByKey('key1'));
        self::assertSame('value2', $image->getExtraItemByKey('key2'));
    }

    public function testCreateImageWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            '',
            1,
            true,
            ['en-GB', 'es-ES'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
            $this->createImageItem(ImageItem::TYPE_MEDIUM, 'https://img.com/medium.jpg'),
            $this->createImageItem(ImageItem::TYPE_LOW, 'https://img.com/low.jpg'),
            $this->createImageItem(ImageItem::TYPE_THUMB, 'https://img.com/thumb.jpg'),
        );
    }

    public function testCreateImageWithDuplicateLocalesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            'testId',
            1,
            true,
            ['en-GB', 'en-GB'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
            $this->createImageItem(ImageItem::TYPE_MEDIUM, 'https://img.com/medium.jpg'),
            $this->createImageItem(ImageItem::TYPE_LOW, 'https://img.com/low.jpg'),
            $this->createImageItem(ImageItem::TYPE_THUMB, 'https://img.com/thumb.jpg'),
        );
    }

    public function testCreateImageWithDuplicateItemTypesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            'testId',
            1,
            true,
            ['en-GB', 'es-ES'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/medium.jpg'),
            $this->createImageItem(ImageItem::TYPE_LOW, 'https://img.com/low.jpg'),
            $this->createImageItem(ImageItem::TYPE_THUMB, 'https://img.com/thumb.jpg'),
        );
    }

    public function testCreateImageWithEmptyArrayValuesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            'testId',
            1,
            true,
            [],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
        );
    }

    public function testCreateImageWithEmptyValueExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            'testId',
            1,
            true,
            ['', 'en-GB'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
        );
    }

    public function testCreateImageWithNotStringValuesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(
            'testId',
            1,
            true,
            [10, 'en-GB'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg'),
        );
    }

    public function testGetImageItemWithInvalidTypeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $image = new Image(
            'testId',
            1,
            true,
            ['en-GB', 'es-ES'],
            $this->createImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg')
        );

        $image->getImageItemByType('wrong type');
    }

    private function createImageItem(string $type, string $url): ImageItem
    {
        return new ImageItem($type, $url, 1000, 1000, 1000);
    }
}
