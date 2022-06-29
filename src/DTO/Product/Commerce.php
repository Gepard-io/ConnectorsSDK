<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;
use InvalidArgumentException;

/**
 * Represents the data about the product commerce information.
 */
final class Commerce
{
    use ExtraTrait;
    use LocaleTrait;

    /**
     * @param string      $locale Locale is a language in which the identifier is provided. Format: 'll-CC'.
     * @param int         $price Selling price value in the smallest currency unit.
     * @param int         $stock The number of items in stock.
     * @param int|null    $vat Value Added Tax.
     * @param string|null $currency ISO-4217 currency code.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $locale,
        private int $price = 0,
        private int $stock = 0,
        private ?int $vat = null,
        private ?string $currency = null
    ) {
        Assert::lazy()
            ->that($locale, 'locale')->notEmpty()
            ->that($price, 'price')->greaterOrEqualThan(0)
            ->that($stock, 'stock')->greaterOrEqualThan(0)
            ->that($vat, 'vat')->nullOr()->greaterOrEqualThan(0)
            ->that($currency, 'currency')->nullOr()->notEmpty()
            ->verifyNow();
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Get stock.
     *
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Get VAT.
     *
     * @return int|null
     */
    public function getVat(): ?int
    {
        return $this->vat;
    }

    /**
     * Get currency.
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'price' => $this->price,
            'stock' => $this->stock,
            'vat' => $this->vat,
            'currency' => $this->currency,
            'extra' => $this->extra,
        ];
    }
}
