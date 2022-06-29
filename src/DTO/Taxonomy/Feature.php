<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;
use GepardIO\ConnectorsSDK\DTO\Traits\FeatureValueValidationTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\TagsTrait;

use function array_map;

/**
 * Feature (attribute, specification) is a particular characteristic of a product
 * (e.g., Color, Display Resolution, Memory).
 */
final class Feature extends BaseTaxonomyData
{
    use TagsTrait;
    use FeatureValueValidationTrait;

    /**
     * Indicates if a category feature is present in a product.
     */
    public const TYPE_BOOLEAN = 'boolean';
    /**
     * Outputs one or more values as a list. Only one value can be selected from this list.
     */
    public const TYPE_SELECT = 'select';
    /**
     * Outputs one or more values as a list. One or more values can be selected from this list.
     */
    public const TYPE_MULTI_SELECT = 'multi_select';
    /**
     * Outputs a value as a string of letters and/or numbers. (If needed, you can set the limit for
     * the number of characters.)
     */
    public const TYPE_ALPHA_NUMERIC = 'alphanumeric';
    /**
     * Outputs a value as a number (integer or fractional), supports unit.
     */
    public const TYPE_NUMERIC = 'numeric';
    /**
     * Outputs a value as a text. It can contain letters, numbers, special characters, spaces, and line
     * breaks. (If needed, you can set the limit for the number of characters.)
     */
    public const TYPE_TEXT = 'text';
    /**
     * Outputs a value as a text, does not support symbols to move the caret to the new line, etc.
     */
    public const TYPE_STRING = 'string';
    /**
     * Outputs one of: “2D”, "RANGE", “CONTRAST RATIO”. Can be detected automatically, supports unit.
     *   - “2D” outputs two numerical values that relate to two-dimensional items (Length x Width): numerical x
     * numerical.
     *   - “RANGE” outputs two values in numbers (integer or fractional): numerical - numerical.
     *   - “CONTRAST RATIO” outputs two values as a specific ratio, in numbers (excluding decimals):
     * numerical:numerical.
     */
    public const TYPE_COMPOSITE2 = 'composite2';
    /**
     * Outputs three numerical values that relate to three-dimensional items
     * (Length x Width x Height): numerical x numerical x numerical.
     */
    public const TYPE_COMPOSITE3 = 'composite3';

    /**
     * List of available types
     */
    public const TYPES = [
        self::TYPE_BOOLEAN,
        self::TYPE_SELECT,
        self::TYPE_MULTI_SELECT,
        self::TYPE_ALPHA_NUMERIC,
        self::TYPE_NUMERIC,
        self::TYPE_TEXT,
        self::TYPE_STRING,
        self::TYPE_COMPOSITE2,
        self::TYPE_COMPOSITE3,
    ];

    /**
     * @param string         $id A unique identifier.
     * @param string         $type Indicates a format in which the values of this category feature should be displayed.
     * @param FeatureL10n[]  $l10n Represents the list of the localized information of feature.
     * @param Unit[]         $units A unit that relates to this feature in its source taxonomy.
     * @param FeatureValue[] $allowedValues A list of values that a feature has in type of "select" and "multi_select".
     * @param array          $tags An optional list of tags.
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        string $id,
        private string $type,
        array $l10n,
        private array $units = [],
        private array $allowedValues = [],
        private array $tags = []
    ) {
        Assert::lazy()
            ->that($type, 'type')->choice(self::TYPES)
            ->that($l10n, 'l10n')->all()->isInstanceOf(FeatureL10n::class)
            ->that($tags, 'tags')->all()->string()
            ->that($tags, 'tags')->uniqueValues()
            ->verifyNow();

        if ($this->isTypeSelect($type)) {
            Assert::lazy()->that($allowedValues, 'allowedValues')->minCount(1);
            $this->validateAllowedValues($allowedValues);
        }

        parent::__construct($id, $l10n);
    }

    /**
     * Get a format in which the values of this category feature should be displayed.
     *
     * @return string
     * @see Feature::TYPES
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get a list of allowed values.
     *
     * @return FeatureValue[]|null
     */
    public function getAllowedValues(): ?array
    {
        return $this->allowedValues;
    }

    /**
     * Whether the feature contains allowed values.
     *
     * @return bool
     */
    public function hasAllowedValues(): bool
    {
        return !empty($this->allowedValues);
    }

    /**
     * Whether the feature type is select.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isTypeSelect(string $type): bool
    {
        return $type === self::TYPE_SELECT || $type === self::TYPE_MULTI_SELECT;
    }

    /**
     * Get a list of units.
     *
     * @return Unit[]|null
     */
    public function getUnits(): ?array
    {
        return $this->units;
    }

    /**
     * Whether the feature contains units.
     *
     * @return bool
     */
    public function hasUnits(): bool
    {
        return !empty($this->units);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'l10n' => array_map(static fn(FeatureL10n $l10n): array => $l10n->toArray(), $this->l10n),
            'units' => array_map(
                static fn(mixed $value): array|string => is_string($value) ? $value : $value->toArray(),
                $this->units
            ),
            'allowedValues' => array_map(
                static fn(mixed $value): array|string => is_string($value) ? $value : $value->toArray(),
                $this->allowedValues
            ),
            'extra' => $this->extra,
            'tags' => $this->tags,
        ];
    }
}
