<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use InvalidArgumentException;

/**
 * Image item is a part of product gallery.
 */
final class ImageItem
{
    public const TYPE_HIGH = 'high';
    public const TYPE_LOW = 'low';
    public const TYPE_MEDIUM = 'medium';
    public const TYPE_THUMB = 'thumb';

    /**
     * List of available quality types
     */
    public const TYPES = [
        self::TYPE_HIGH,
        self::TYPE_MEDIUM,
        self::TYPE_LOW,
        self::TYPE_THUMB,
    ];

    /**
     * @param string   $type Quality type of image. Look to TYPE_* constants.
     * @param string   $url Source URL of image.
     * @param int|null $width Image height in pixels.
     * @param int|null $height Image width in pixels.
     * @param int|null $size Image size in bytes.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $type,
        private string $url,
        private ?int $width = null,
        private ?int $height = null,
        private ?int $size = null
    ) {
        Assert::lazy()
            ->that($type, 'type')->choice(self::TYPES)
            ->that($url, 'url')->notEmpty()->url()
            ->that($width, 'width')->nullOr()->integer()->greaterThan(0)
            ->that($height, 'height')->nullOr()->integer()->greaterThan(0)
            ->that($size, 'size')->nullOr()->integer()->greaterThan(0)
            ->verifyNow();
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get height.
     *
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * Get width.
     *
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * Get size.
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'url' => $this->url,
            'width' => $this->width,
            'height' => $this->height,
            'size' => $this->size,
        ];
    }
}
