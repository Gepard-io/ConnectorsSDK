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
 * Feature group is an established set of category features that are grouped by a particular common
 * characteristic.
 *
 * For example, the feature group "Weight & dimensions" includes the following category features: "Weight",
 * "Package width", "Package depth", "Package height", "Package weight". (All these category features describe the
 * physical parameters of a packaged product.)
 *
 * Feature groups are optional and may not be used in the project (they may take no part in mappings), though remain
 * available. Feature groups may be present in a taxonomy from any source (our system, content provider, etc.).
 */
final class FeatureGroup extends BaseTaxonomyData
{
    /**
     * @param string             $id A unique identifier.
     * @param FeatureGroupL10n[] $l10n Represents the list of the localized information of feature group.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $id, array $l10n)
    {
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(FeatureGroupL10n::class)
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
            'l10n' => array_map(static fn(FeatureGroupL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
