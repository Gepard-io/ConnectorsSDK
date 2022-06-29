<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\ImageItem;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ImageItemTest extends TestCase
{
    /**
     * @dataProvider providerItemImages
     */
    public function testCreateImageExpectSuccess(string $type, string $url, int $width, int $height, int $size): void
    {
        $imageItem = new ImageItem($type, $url, $width, $height, $size);

        self::assertSame($type, $imageItem->getType());
        self::assertSame($url, $imageItem->getUrl());
        self::assertSame($width, $imageItem->getWidth());
        self::assertSame($height, $imageItem->getHeight());
        self::assertSame($size, $imageItem->getSize());
    }

    public function providerItemImages(): array
    {
        return [
            ImageItem::TYPE_HIGH => [ImageItem::TYPE_HIGH, 'https://img.com/high.jpg', 1000, 1000, 1000],
            ImageItem::TYPE_MEDIUM => [ImageItem::TYPE_MEDIUM, 'https://img.com/medium.jpg', 1000, 1000, 1000],
            ImageItem::TYPE_LOW => [ImageItem::TYPE_LOW, 'https://img.com/low.jpg', 1000, 1000, 1000],
            ImageItem::TYPE_THUMB => [ImageItem::TYPE_THUMB, 'https://img.com/thumb.jpg', 1000, 1000, 1000],
        ];
    }

    public function testCreateImageItemWithOptionalParamsExpectSuccess(): void
    {
        $imageItem = new ImageItem(ImageItem::TYPE_HIGH, 'https://img.com/high.jpg');

        self::assertNull($imageItem->getSize());
        self::assertNull($imageItem->getWidth());
        self::assertNull($imageItem->getSize());
    }

    public function testGetImageItemWithInvalidTypeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ImageItem(
            'wrong type',
            'https://img.com/high.jpg',
            1000,
            1000,
            1000
        );
    }

    public function testGetImageItemWithInvalidWidthExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ImageItem(
            ImageItem::TYPE_HIGH,
            'https://img.com/high.jpg',
            0,
            1000,
            1000
        );
    }

    public function testGetImageItemWithInvalidSizeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ImageItem(
            ImageItem::TYPE_HIGH,
            'https://img.com/high.jpg',
            1000,
            1000,
            0
        );
    }

    public function testGetImageItemWithInvalidUrlExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ImageItem(
            ImageItem::TYPE_HIGH,
            'wrong url',
            1000,
            1000,
            1000
        );
    }
}
