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
 * Localized information of feature.
 */
final class FeatureL10n
{
    use LocaleTrait;

    /**
     * @param string $locale Locale is a language in which the identifier is provided. Format: 'll-CC'.
     * @param string $name Localized name of the feature.
     * @param array  $values Localized values of the feature.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $locale, private string $name, private array $values)
    {
        Assert::lazy()
            ->that($locale, 'locale')->notEmpty()
            ->that($name, 'name')->notEmpty()
            ->that($values, 'values')->minCount(1)->uniqueValues()->all()->string()->notBlank()
            ->verifyNow();
    }

    /**
     * Get localized name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get localized value.
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
            'name' => $this->name,
            'values' => $this->values,
        ];
    }
}
