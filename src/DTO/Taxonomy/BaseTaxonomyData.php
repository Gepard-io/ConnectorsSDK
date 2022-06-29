<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

use function array_key_exists;
use function sprintf;

/**
 * Base class for taxonomy information.
 */
abstract class BaseTaxonomyData implements TaxonomyDataInterface
{
    use ExtraTrait;
    use IdentifierTrait;

    /**
     * @var array<string, BaseTaxonomyL10n>
     */
    protected array $l10n = [];

    /**
     * @param string             $id A unique identifier of taxonomy data.
     * @param BaseTaxonomyL10n[] $l10n Represents the list of the localized information of taxonomy data.
     *
     * @throws AssertionFailedException|InvalidArgumentException
     */
    public function __construct(protected string $id, array $l10n)
    {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($l10n, 'l10n')->minCount(1)
            ->verifyNow();

        foreach ($l10n as $l10nItem) {
            if (array_key_exists($l10nItem->getLocale(), $this->l10n)) {
                throw new InvalidArgumentException(
                    sprintf('Localized value %s is already exist', $l10nItem->getLocale())
                );
            }

            $this->l10n[$l10nItem->getLocale()] = $l10nItem;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getL10n(): array
    {
        return $this->l10n;
    }

    /**
     * {@inheritDoc}
     */
    public function getL10nItemByLocale(string $locale): TaxonomyL10nInterface
    {
        foreach ($this->l10n as $l10n) {
            if ($l10n->getLocale() === $locale) {
                return $l10n;
            }
        }

        throw new InvalidArgumentException(sprintf('L10n item with locale %s does not exist.', $locale));
    }
}
