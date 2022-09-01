<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;
use InvalidArgumentException;

/**
 *  An additional identifier for the product
 */
final class AdditionalIdentifier
{
    use LocaleTrait;

    /**
     * The Manufacturer Part Number; an identifier of a particular part design used in a particular industry.
     */
    public const TYPE_MPN = 'mpn';
    /**
     * GTIN (Global Trade Item Number).
     */
    public const TYPE_GTIN = 'gtin';
    /**
     * Stock keeping unit
     */
    public const TYPE_SKU = 'sku';
    public const TYPES = [
        self::TYPE_MPN,
        self::TYPE_GTIN,
        self::TYPE_SKU,
    ];

    /**
     * @param string $type Type of product identifier, one of: MPN, GTIN, SKU.
     * @param string $locale Locale is a language in which the identifier is provided. Format: 'll-CC'.
     * @param string $value Value of identifier.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $type, private string $locale, private string $value)
    {
        Assert::lazy()
            ->that($type, 'type')->choice(self::TYPES)
            ->that($locale, 'locale')->notEmpty()
            ->that($value, 'value')->notEmpty()
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
     * Get value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Determines if the name, locale and value of the instance are equal to another.
     *
     * @param self $other
     *
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->type === $other->getType()
            && $this->locale === $other->getLocale()
            && $this->value === $other->getValue();
    }
}
