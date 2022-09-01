<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use Assert\Assertion;
use Assert\AssertionFailedException;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

use function array_key_exists;
use function sprintf;

/**
 * Represents the information about the product gallery image with detailed information on each image.
 */
final class Image
{
    use ExtraTrait;
    use IdentifierTrait;

    private array $imageItems = [];

    /**
     * @param string    $id Identifier of image.
     * @param int       $no Order by number.
     * @param bool      $isMain Whether the image is main in the gallery.
     * @param string[]  $locales List of locales. Format: 'll-CC'.
     * @param ImageItem ...$imageItems List of image items.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $id,
        private int $no,
        private bool $isMain,
        private array $locales,
        ImageItem ...$imageItems
    ) {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($no, 'no')->greaterThan(0)
            ->that($locales, 'locales')->minCount(1)->uniqueValues()
            ->that($locales, 'locales')->all()->string()->notEmpty()
            ->that($imageItems, 'imageItems')->minCount(1)
            ->verifyNow();

        foreach ($imageItems as $imageItem) {
            if (array_key_exists($imageItem->getType(), $this->imageItems)) {
                throw new InvalidArgumentException(
                    sprintf('Image item with type %s is already exist', $imageItem->getType())
                );
            }

            $this->imageItems[$imageItem->getType()] = $imageItem;
        }
    }

    /**
     * Get the number by order.
     *
     * @return int
     */
    public function getNo(): int
    {
        return $this->no;
    }

    /**
     * Whether the image is main in the gallery.
     *
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->isMain;
    }

    /**
     * Get the list of locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * Get the list of image items.
     *
     * @return array
     */
    public function getImageItems(): array
    {
        return $this->imageItems;
    }

    /**
     * Get the image item by type.
     *
     * @param string $type
     *
     * @return ImageItem|null
     *
     * @throws AssertionFailedException
     */
    public function getImageItemByType(string $type): ?ImageItem
    {
        Assertion::choice($type, ImageItem::TYPES);

        return $this->imageItems[$type] ?: null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'no' => $this->no,
            'isMain' => $this->isMain,
            'locales' => $this->locales,
            'imageItems' => array_map(static fn(ImageItem $item): array => $item->toArray(), $this->imageItems),
            'extra' => $this->extra,
        ];
    }
}
