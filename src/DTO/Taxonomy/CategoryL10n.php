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
 * Localized information about the category.
 */
final class CategoryL10n extends BaseTaxonomyL10n
{
    /**
     * @param string $name Name of category translated into an indicated locale (language).
     * @param string $locale Locale is a language into which name is translated. Format: 'll-CC'.
     * @param string|null $description Localized description.
     * @param array|null $keywords Localized list of keywords.
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        string $name,
        string $locale,
        private ?string $description = null,
        private ?array $keywords = null
    ) {
        Assert::lazy()
            ->that($description, 'description')->nullOr()->notBlank()
            ->that($keywords, 'keywords')->nullOr()->uniqueValues()->all()->string()->notBlank()
            ->verifyNow();

        parent::__construct($name, $locale);
    }

    /**
     * Get a localized description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get a list of localized keywords.
     *
     * @return array|null
     */
    public function getKeywords(): ?array
    {
        return $this->keywords;
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
                'keywords' => $this->keywords,
            ]
        );
    }
}
