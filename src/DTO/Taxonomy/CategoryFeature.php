<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\FeatureValueValidationTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

use function array_map;
use function is_object;
use function is_string;

/**
 * Category feature is a product feature that relates to a particular category and may have specific values, defined by
 * this category.
 *
 * E.g., "Color" feature for "Mobile Phones" category may have values that are absent in "Color" feature for
 * "Notebooks" - "night blue" Color for "Mobile Phones" may be absent for "Notebooks".
 */
final class CategoryFeature
{
    use ExtraTrait;
    use IdentifierTrait;
    use FeatureValueValidationTrait;

    /**
     * Priority means that the values of the category may be not displayed.
     */
    public const PRIORITY_OPTIONAL = 'optional';
    /**
     * Priority means that the values of the category feature must be displayed.
     */
    public const PRIORITY_MANDATORY = 'mandatory';
    /**
     * List of available priorities.
     */
    public const PRIORITIES = [
        self::PRIORITY_OPTIONAL,
        self::PRIORITY_MANDATORY,
    ];

    /**
     * @param string            $id A unique identifier.
     * @param string            $priority Specifies whether the values of this feature may be not or must be displayed
     *     in a product.
     * @param Category|string   $category The category used to form a category feature.
     * @param Feature           $feature The feature, used to form a category feature.
     * @param Unit|string|null  $unit The feature group, used to form a category feature.
     * @param FeatureGroup|null $featureGroup The feature group, used to form a category feature.
     * @param FeatureValue[]    $allowedValues A list of values that a feature has in type of "select" and
     *     "multi_select".
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $id,
        private string $priority,
        private Feature $feature,
        private Category|string $category,
        private Unit|string|null $unit = null,
        private ?FeatureGroup $featureGroup = null,
        private array $allowedValues = [],
    ) {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($priority, 'priority')->choice(self::PRIORITIES)
            ->verifyNow();

        if ($this->feature->isTypeSelect($this->feature->getType())) {
            $this->validateAllowedValues($allowedValues);
        }
    }

    /**
     * Get a category of the category feature.
     *
     * @return Category|string
     */
    public function getCategory(): Category|string
    {
        return $this->category;
    }

    /**
     * Get a category group of category feature.
     *
     * @return FeatureGroup|null
     */
    public function getFeatureGroup(): ?FeatureGroup
    {
        return $this->featureGroup;
    }

    /**
     * Whether the category feature contains a feature group.
     *
     * @return bool
     */
    public function hasFeatureGroup(): bool
    {
        return $this->featureGroup !== null;
    }

    /**
     * Get a feature of the category feature.
     *
     * @return Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
    }

    /**
     * Whether the category feature contains a unit.
     *
     * @return bool
     */
    public function hasUnit(): bool
    {
        return $this->unit !== null;
    }

    /**
     * Get a unit of the category feature.
     *
     * @return Unit|null
     */
    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    /**
     * Get priority of the category feature. Specifies if the values of this feature may be not or must be displayed.
     *
     * @return string
     * @see CategoryFeature::PRIORITIES
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Converts the category feature information into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'featureId' => $this->feature->getId(),
            'categoryId' => is_object($this->category) ? $this->category->getId() : $this->category,
            'unitId' => is_object($this->unit) ? $this->unit->getId() : $this->unit,
            'featureGroupId' => $this->hasFeatureGroup() ? $this->featureGroup->getId() : null,
            'allowedValues' => array_map(
                static fn(mixed $value): array|string => is_string($value) ? $value : $value->toArray(),
                $this->allowedValues
            ),
            'extra' => $this->extra,
        ];
    }
}
