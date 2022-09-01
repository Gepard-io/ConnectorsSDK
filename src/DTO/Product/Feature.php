<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryFeature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature as TaxonomyFeature;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

/**
 * Represents the information about the product's feature (attribute, specification), a particular characteristic of
 * the product
 * (e.g., Color, Display Resolution, Memory).
 */
final class Feature
{
    use ExtraTrait;
    use IdentifierTrait;

    /**
     * @param string        $id An original unique identifier of the feature in its source taxonomy.
     * @param string        $categoryId An original unique identifier of the category in its source taxonomy.
     * @param string        $type Type of feature @see TaxonomyFeature::TYPES.
     * @param string        $priority Priority of the feature @see CategoryFeature::PRIORITIES.
     * @param FeatureL10n[] $l10n Represents the list of the localized information of the feature.
     * @param string|null   $unitId A unit that relates to this feature in its source taxonomy.
     * @param string|null   $featureGroupId An original unique identifier of the feature group in its source taxonomy.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $id,
        private string $categoryId,
        private string $type,
        private string $priority,
        private array $l10n,
        private ?string $unitId = null,
        private ?string $featureGroupId = null
    ) {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($categoryId, 'categoryId')->notEmpty()
            ->that($type, 'type')->choice(TaxonomyFeature::TYPES)
            ->that($priority, 'priority')->choice(CategoryFeature::PRIORITIES)
            ->that($l10n, 'l10n')->minCount(1)
            ->that($l10n, 'l10n')->all()->isInstanceOf(FeatureL10n::class)
            ->that($unitId, 'unitId')->nullOr()->notEmpty()
            ->that($featureGroupId, 'featureGroupId')->nullOr()->notEmpty()
            ->verifyNow();
    }

    /**
     * Get the category identifier.
     *
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * Get the feature type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get priority of the feature.
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Get the list of localized information.
     *
     * @return FeatureL10n[]
     */
    public function getL10n(): array
    {
        return $this->l10n;
    }

    /**
     * Get the unit identifier.
     *
     * @return string|null
     */
    public function getUnitId(): ?string
    {
        return $this->unitId;
    }

    /**
     * Get the feature group identifier.
     *
     * @return string|null
     */
    public function getFeatureGroupId(): ?string
    {
        return $this->featureGroupId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'categoryId' => $this->categoryId,
            'type' => $this->type,
            'l10n' => array_map(static fn(FeatureL10n $l10n): array => $l10n->toArray(), $this->l10n),
            'priority' => $this->priority,
            'unitId' => $this->unitId,
            'featureGroupId' => $this->featureGroupId,
            'extra' => $this->extra,
        ];
    }
}
