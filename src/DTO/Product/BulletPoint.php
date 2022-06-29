<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;
use InvalidArgumentException;

/**
 * Represents the information about the product's characteristics. The value of the characteristic is localized.
 */
final class BulletPoint
{
    use ExtraTrait;
    use LocaleTrait;

    /**
     * @param string   $locale Locale is the language in which the bullet point values are provided. Format: 'll-CC'.
     * @param string[] $values List of localized values of the bullet point.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $locale, private array $values)
    {
        Assert::lazy()
            ->that($locale, 'locale')->notEmpty()
            ->that($values, 'values')->minCount(1)->uniqueValues()
            ->that($values, 'values')->all()->string()->notEmpty()
            ->verifyNow();
    }

    /**
     * Get list of values.
     *
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'values' => $this->values,
            'extra' => $this->extra,
        ];
    }
}
