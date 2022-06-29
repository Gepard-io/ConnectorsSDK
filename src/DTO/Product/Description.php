<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;
use InvalidArgumentException;

/**
 * Represents the information about localized marketing information that briefs on the product's benefits
 * and technical characteristics.
 */
final class Description
{
    use ExtraTrait;
    use LocaleTrait;

    /**
     * @param string      $locale Locale is a language in which the identifier is provided. Format: 'll-CC'.
     * @param string      $title Title of description.
     * @param string      $short Short description.
     * @param string      $long Long description.
     * @param string|null $warrantyInfo Warranty information.
     * @param string|null $shortSummary Short summary.
     * @param string|null $longSummary Long summary.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $locale,
        private string $title,
        private string $short,
        private string $long,
        private ?string $warrantyInfo = null,
        private ?string $shortSummary = null,
        private ?string $longSummary = null
    ) {
        Assert::lazy()
            ->that($locale, 'locale')->notEmpty()
            ->that($title, 'title')->notEmpty()
            ->that($short, 'short')->notEmpty()
            ->that($long, 'long')->notEmpty()
            ->that($warrantyInfo, 'warrantyInfo')->nullOr()->notEmpty()
            ->that($shortSummary, 'shortSummary')->nullOr()->notEmpty()
            ->that($longSummary, 'longSummary')->nullOr()->notEmpty()
            ->verifyNow();
    }

    /**
     * Get the short description.
     *
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * Get the long description.
     *
     * @return string
     */
    public function getLong(): string
    {
        return $this->long;
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
     * Get the warranty information.
     *
     * @return string|null
     */
    public function getWarrantyInfo(): ?string
    {
        return $this->warrantyInfo;
    }

    /**
     * Get the short summary.
     *
     * @return string|null
     */
    public function getShortSummary(): ?string
    {
        return $this->shortSummary;
    }

    /**
     * Get the long summary.
     *
     * @return string|null
     */
    public function getLongSummary(): ?string
    {
        return $this->longSummary;
    }

    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'short' => $this->short,
            'long' => $this->long,
            'title' => $this->title,
            'warrantyInfo' => $this->warrantyInfo,
            'shortSummary' => $this->shortSummary,
            'longSummary' => $this->longSummary,
            'extra' => $this->extra,
        ];
    }
}
