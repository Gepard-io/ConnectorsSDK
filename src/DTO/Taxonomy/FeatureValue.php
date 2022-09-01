<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

use function array_key_exists;
use function array_map;
use function sprintf;

/**
 * Feature value is a particular value of a product feature.
 * The set of values for a feature may be determined by a category to which this feature relates. In this case, a value
 * may be defined as a category feature value.
 *
 * For example, the feature "Color" has the following values - "red', "white", "black". But if the feature "Color"
 * relates to
 * "Notebooks" category, this feature may have only two values, "white" and "black".
 */
final class FeatureValue
{
    use ExtraTrait;
    use IdentifierTrait;

    protected array $l10n = [];

    /**
     * @param string             $id A unique identifier.
     * @param FeatureValueL10n[] $l10n Localized information about the feature value.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $id, array $l10n)
    {
        Assert::lazy()
            ->that($id, 'id')->notBlank()
            ->that($l10n, 'l10n')->minCount(1)
            ->that($l10n, 'l10n')->all()->isInstanceOf(FeatureValueL10n::class)
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
     * Get a list of localized information about the feature value.
     *
     * @return FeatureValueL10n[]
     */
    public function getL10n(): array
    {
        return $this->l10n;
    }

    /**
     * Convert the feature value information into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(FeatureValueL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
