<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;
use GepardIO\ConnectorsSDK\DTO\Traits\LocaleTrait;

/**
 * Base class for taxonomy localized information.
 */
abstract class BaseTaxonomyL10n implements TaxonomyL10nInterface
{
    use LocaleTrait;

    /**
     * @param string $name Name of taxonomy item translated into an indicated locale (language).
     * @param string $locale Locale is a language into which the name is translated. Format: 'll-CC'.
     *
     * @throws AssertionFailedException
     */
    public function __construct(private string $name, protected string $locale)
    {
        Assert::lazy()
            ->that($name, 'id')->notEmpty()
            ->that($locale, 'locale')->notEmpty()
            ->verifyNow();
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(TaxonomyL10nInterface $other): bool
    {
        return $this->name === $other->getName() && $this->locale === $other->getLocale();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'locale' => $this->locale,
        ];
    }
}
