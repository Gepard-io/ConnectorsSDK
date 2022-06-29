<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;

use function array_filter;
use function sprintf;

/**
 * Product builder. lets construct the Product step by step
 */
final class ProductBuilder
{
    use ProductTrait;

    /**
     * @param Identifier $identifier A unique identifier of the product.
     * @param Brand      $brand Brand of product.
     * @param Category   $category Category of product.
     * @param string     $modelName Model name of product
     *
     * @throws AssertionFailedException
     */
    public function __construct(Identifier $identifier, Brand $brand, Category $category, string $modelName)
    {
        Assertion::notEmpty($modelName);

        $this->identifier = $identifier;
        $this->brand = $brand;
        $this->category = $category;
        $this->modelName = $modelName;
    }

    /**
     * Build the product.
     *
     * @return Product
     */
    public function build(): Product
    {
        return new Product($this);
    }

    /**
     * Set list of descriptions.
     *
     * @param Description ...$descriptions
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setDescriptions(Description ...$descriptions): self
    {
        Assertion::minCount($descriptions, 1);
        $this->descriptions = $descriptions;

        return $this;
    }

    /**
     * Set list of bullet points.
     *
     * @param BulletPoint ...$bulletPoints
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setBulletPoints(BulletPoint ...$bulletPoints): self
    {
        Assertion::minCount($bulletPoints, 1);
        $this->bulletPoints = [];
        foreach ($bulletPoints as $bulletPoint) {
            if (array_key_exists($bulletPoint->getLocale(), $this->bulletPoints)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'BulletPoint is already exist - locale: %s',
                        $bulletPoint->getLocale()
                    )
                );
            }

            $this->bulletPoints[$bulletPoint->getLocale()] = $bulletPoint;
        }

        return $this;
    }

    /**
     * Set a list of reasons to buy.
     *
     * @param ReasonToBuy ...$reasonsToBuy
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setReasonsToBuy(ReasonToBuy ...$reasonsToBuy): self
    {
        Assertion::minCount($reasonsToBuy, 1);
        $this->reasonsToBuy = [];
        foreach ($reasonsToBuy as $reason) {
            if (array_key_exists($reason->getLocale(), $this->reasonsToBuy)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'ReasonToBuy is already exist - locale: %s, title: %s',
                        $reason->getLocale(),
                        $reason->getTitle()
                    )
                );
            }

            $this->reasonsToBuy[$reason->getLocale()] = $reason;
        }

        return $this;
    }

    /**
     * Set a list of images.
     *
     * @param Image ...$gallery
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setGallery(Image ...$gallery): self
    {
        Assertion::count(array_filter($gallery, static fn(Image $image) => $image->isMain()), 1);

        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Set a list of media.
     *
     * @param Media ...$media
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setMedia(Media ...$media): self
    {
        Assertion::minCount($media, 1);
        $this->media = $media;

        return $this;
    }

    /**
     * Set a list of features.
     *
     * @param Feature ...$features
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setFeatures(Feature ...$features): self
    {
        Assertion::minCount($features, 1);
        $this->features = $features;

        return $this;
    }

    /**
     * Set a list of commerce info.
     *
     * @param Commerce ...$commerces
     *
     * @return self
     *
     * @throws AssertionFailedException
     */
    public function setCommerces(Commerce ...$commerces): self
    {
        Assertion::minCount($commerces, 1);
        $this->commerces = [];
        foreach ($commerces as $commerce) {
            if (array_key_exists($commerce->getLocale(), $this->commerces)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Commerce is already exist - locale: %s',
                        $commerce->getLocale()
                    )
                );
            }

            $this->commerces[$commerce->getLocale()] = $commerce;
        }

        return $this;
    }
}
