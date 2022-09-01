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
 * Series is a product's model that relates to a particular family of this product's brand.
 */
final class Series extends BaseTaxonomyData
{
    /**
     * @param string       $id A unique identifier.
     * @param SeriesL10n[] $l10n Localized information about series.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $id, array $l10n)
    {
        parent::__construct($id, $l10n);
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(SeriesL10n::class)
            ->verifyNow();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(SeriesL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
