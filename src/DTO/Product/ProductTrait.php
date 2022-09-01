<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use DateTimeImmutable;

/**
 * Represents the product fields
 */
trait ProductTrait
{
    private Identifier $identifier;
    private Brand $brand;
    private Category $category;
    private string $modelName;
    private array $descriptions = [];
    private array $bulletPoints = [];
    private array $reasonsToBuy = [];
    private array $gallery = [];
    private array $media = [];
    private array $features = [];
    private array $commerces = [];
    private ?DateTimeImmutable $releaseDate = null;

    /**
     * Get the identifier.
     *
     * @return Identifier
     */
    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }

    /**
     * Get a brand of product.
     *
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * Get a category of product.
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Get a model name.
     *
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * Get a list of descriptions.
     *
     * @return Description[]
     */
    public function getDescriptions(): array
    {
        return $this->descriptions;
    }

    /**
     * Get a list of bullet points.
     *
     * @return BulletPoint[]
     */
    public function getBulletPoints(): array
    {
        return $this->bulletPoints;
    }

    /**
     * Get a list of reasons to buy.
     *
     * @return ReasonToBuy[]
     */
    public function getReasonsToBuy(): array
    {
        return $this->reasonsToBuy;
    }

    /**
     * Get a list of images.
     *
     * @return Image[]
     */
    public function getGallery(): array
    {
        return $this->gallery;
    }

    /**
     * Get a list of media.
     *
     * @return Media[]
     */
    public function getMedia(): array
    {
        return $this->media;
    }

    /**
     * Get a list of features.
     *
     * @return Feature[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * Get a list of commerce info.
     *
     * @return Commerce[]
     */
    public function getCommerces(): array
    {
        return $this->commerces;
    }

    /**
     * Get product release date.
     *
     * @return DateTimeImmutable|null
     */
    public function getReleaseDate(): ?DateTimeImmutable
    {
        return $this->releaseDate;
    }
}
