<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;

use function array_map;

/**
 * Brand is a name that a manufacturer or seller uses to identify their products from products
 * of other manufacturers or sellers.
 */
final class Brand extends BaseTaxonomyData
{
    /**
     * @param string      $id A unique identifier.
     * @param BrandL10n[] $l10n Localized information about the brand.
     * @param string|null $logoUrl URL for the brand’s logo.
     *
     * @throws AssertionFailedException
     */
    public function __construct(protected string $id, array $l10n, private ?string $logoUrl = null)
    {
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(BrandL10n::class)
            ->that($logoUrl, 'logoUrl')->nullOr()->url()
            ->verifyNow();

        parent::__construct($id, $l10n);
    }

    /**
     * Get the brand’s logo Url.
     *
     * @return string|null
     */
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(BrandL10n $l10n) => $l10n->toArray(), $this->l10n),
            'logoUrl' => $this->logoUrl,
            'extra' => $this->extra,
        ];
    }
}
