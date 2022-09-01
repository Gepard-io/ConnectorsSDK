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
 * Localized information about the unit.
 */
final class UnitL10n extends BaseTaxonomyL10n
{
    /**
     * @param string      $name Localized name.
     * @param string      $locale Locale is a language into which the name is translated. Format: 'll-CC'.
     * @param string|null $description Localized description.
     * @param string|null $sign A character or combination of characters to designate a unit of measure.
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        string $name,
        string $locale,
        private ?string $description = null,
        private ?string $sign = null
    ) {
        Assert::lazy()
            ->that($description, 'description')->nullOr()->notEmpty()
            ->that($sign, 'sign')->nullOr()->notEmpty()
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
     * Get a localized sign.
     *
     * @return string|null
     */
    public function getSign(): ?string
    {
        return $this->sign;
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
                'sign' => $this->sign,
            ]
        );
    }
}
