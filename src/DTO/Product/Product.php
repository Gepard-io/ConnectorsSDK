<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use DateTimeImmutable;

/**
 * A product is a set of data that describes the actual object of the trade.
 */
final class Product
{
    use ProductTrait;

    private DateTimeImmutable $releaseDate;
    private DateTimeImmutable $productAdded;
    private DateTimeImmutable $productUpdated;

    /**
     * @param ProductBuilder $productBuilder
     */
    public function __construct(ProductBuilder $productBuilder)
    {
        $this->identifier = $productBuilder->getIdentifier();
        $this->brand = $productBuilder->getBrand();
        $this->category = $productBuilder->getCategory();
        $this->modelName = $productBuilder->getModelName();
        $this->descriptions = $productBuilder->getDescriptions();
        $this->bulletPoints = $productBuilder->getBulletPoints();
        $this->reasonsToBuy = $productBuilder->getReasonsToBuy();
        $this->gallery = $productBuilder->getGallery();
        $this->media = $productBuilder->getMedia();
        $this->features = $productBuilder->getFeatures();
        $this->commerces = $productBuilder->getCommerces();
        $this->releaseDate = new DateTimeImmutable();
        $this->productAdded = new DateTimeImmutable();
        $this->productUpdated = new DateTimeImmutable();
    }

    /**
     * Get the product release date.
     *
     * @return DateTimeImmutable
     */
    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * Get the product added date.
     *
     * @return DateTimeImmutable
     */
    public function getProductAdded(): DateTimeImmutable
    {
        return $this->productAdded;
    }

    /**
     * Get the product updated date.
     *
     * @return DateTimeImmutable
     */
    public function getProductUpdated(): DateTimeImmutable
    {
        return $this->productUpdated;
    }
}
