<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;

use function array_map;

/**
 * Family is a brand's product line that describes related products with one or more common and global specific
 * characteristic.
 */
final class Family extends BaseTaxonomyData
{
    /**
     * @param string       $id A unique identifier.
     * @param FamilyL10n[] $l10n Localized information about the category.
     * @param Series[]     $series A list of Series is a product's model that relates to a particular family.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $id, array $l10n, private array $series = [])
    {
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(FamilyL10n::class)
            ->that($series, 'series')->nullOr()->all()->isInstanceOf(Series::class)
            ->verifyNow();

        parent::__construct($id, $l10n);
    }

    /**
     * Get a list of series.
     *
     * @return Series[]|null
     */
    public function getSeries(): ?array
    {
        return $this->series;
    }

    /**
     * Whether the family contains series.
     *
     * @return bool
     */
    public function hasSeries(): bool
    {
        return $this->series !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(FamilyL10n $l10n) => $l10n->toArray(), $this->l10n),
            'series' => $this->hasSeries()
                ? array_map(static fn(Series $series) => $series->toArray(), $this->series)
                : null,
            'extra' => $this->extra,
        ];
    }
}
