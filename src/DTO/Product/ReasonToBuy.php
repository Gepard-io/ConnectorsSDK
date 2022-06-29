<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;
use InvalidArgumentException;

/**
 * Product’s benefits that provide additional information on the product as on a real-life trade item.
 */
final class ReasonToBuy
{
    use ExtraTrait;
    use LocaleTrait;
    use IdentifierTrait;

    /**
     * @param string      $id Identifier of the reason to buy.
     * @param string      $locale Locale is a language in which the reason-to-buy value is provided. Format: 'll-CC'.
     * @param string      $title Title of the reason to buy.
     * @param string      $value Value of the reason to buy.
     * @param int         $no Order by number.
     * @param string|null $pictureUrl Url for the picture.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $id,
        private string $locale,
        private string $title,
        private string $value,
        private int $no,
        private ?string $pictureUrl = null
    ) {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($locale, 'locale')->notEmpty()
            ->that($title, 'title')->notEmpty()
            ->that($value, 'value')->notEmpty()
            ->that($no, 'no')->greaterThan(0)
            ->that($pictureUrl, 'pictureUrl')->nullOr()->url()
            ->verifyNow();
    }

    /**
     * Get the identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Order by number.
     *
     * @return int
     */
    public function getNo(): int
    {
        return $this->no;
    }

    /**
     * Get the picture URL.
     *
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * Determines if the title, locale and picture Url of the instance are equal.
     *
     * @param self $other
     *
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->title === $other->getTitle()
            && $this->locale === $other->getLocale()
            && $this->pictureUrl === $other->getPictureUrl();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'locale' => $this->locale,
            'title' => $this->title,
            'value' => $this->value,
            'no' => $this->no,
            'pictureUrl' => $this->pictureUrl,
            'extra' => $this->extra,
        ];
    }
}
