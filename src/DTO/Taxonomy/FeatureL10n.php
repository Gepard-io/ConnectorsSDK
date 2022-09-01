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
 * Localized information about feature.
 */
final class FeatureL10n extends BaseTaxonomyL10n
{
    /**
     * @param string      $name Localized name of the feature.
     * @param string      $locale Locale is a language into which name is translated. Format: 'll-CC'.
     * @param string|null $description description name of the feature.
     * @param string|null $example Localized example of the feature.
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        string $name,
        string $locale,
        private ?string $description = null,
        private ?string $example = null
    ) {
        parent::__construct($name, $locale);
        Assert::lazy()
            ->that($description, 'description')->nullOr()->notBlank()
            ->that($example, 'example')->nullOr()->notBlank()
            ->verifyNow();
    }

    /**
     * Get the localized description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the localized example.
     *
     * @return string|null
     */
    public function getExample(): ?string
    {
        return $this->example;
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
                'example' => $this->example,
            ]
        );
    }
}
