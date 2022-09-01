<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use DateTimeImmutable;

/**
 * A product is a set of data that describes the actual object of the trade.
 */
final class Product
{
    use ProductTrait;

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
        $this->releaseDate = $productBuilder->getReleaseDate();
        $this->productAdded = $productBuilder->getProductAdded() ?: new DateTimeImmutable();
        $this->productUpdated = $productBuilder->getProductUpdated() ?: new DateTimeImmutable();
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
