<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use InvalidArgumentException;

/**
 * Localized information about the feature value.
 */
final class FeatureValueL10n
{
    /**
     * @param string $value Localized value of the feature value.
     * @param string $locale Locale is a language into which name is translated. Format: 'll-CC'.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $value, private string $locale)
    {
        Assert::lazy()
            ->that($value, 'value')->notBlank()
            ->that($locale, 'locale')->notEmpty()
            ->verifyNow();
    }

    /**
     * Get a localized value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get a locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Determines if the name, locale and value of the instance are equal.
     *
     * @param self $other
     *
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->locale === $other->getLocale() && $this->value === $other->getValue();
    }

    /**
     * Convert the feature value localized information into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'locale' => $this->locale,
        ];
    }
}
