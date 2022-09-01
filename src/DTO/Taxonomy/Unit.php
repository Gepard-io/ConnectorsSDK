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
 * Unit is a unit of measure that measures a product feature (e.g., GB, kg, cm).
 */
final class Unit extends BaseTaxonomyData
{
    /**
     * @param string     $id A unique identifier.
     * @param UnitL10n[] $l10n Localized information about unit.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $id, array $l10n)
    {
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(UnitL10n::class)
            ->verifyNow();

        parent::__construct($id, $l10n);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(UnitL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
