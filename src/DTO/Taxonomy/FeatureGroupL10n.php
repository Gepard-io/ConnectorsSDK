<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;

use function array_merge;

/**
 * Localized information about the feature group.
 */
final class FeatureGroupL10n extends BaseTaxonomyL10n
{
    /**
     * @param string      $name Localized name of the feature group.
     * @param string      $locale Locale is a language into which name is translated. Format: 'll-CC'.
     * @param string|null $description Localized description of the feature group.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $name, string $locale, private ?string $description = null)
    {
        Assert::lazy()
            ->that($description, 'description')->nullOr()->notBlank()
            ->verifyNow();

        parent::__construct($name, $locale);
    }

    /**
     * Get a localized description of the feature group.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'description' => $this->description,
            ]
        );
    }
}
