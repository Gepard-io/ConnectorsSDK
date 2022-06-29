<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

/**
 * Represents the information about product's category with localized information.
 */
final class Category
{
    use ExtraTrait;
    use IdentifierTrait;

    private array $l10n;

    /**
     * @param string       $id A unique identifier of the category.
     * @param CategoryL10n ...$l10n Represents the list of the localized information of the category.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private string $id, CategoryL10n ...$l10n)
    {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($l10n, 'l10n')->minCount(1)
            ->verifyNow();

        $this->l10n = $l10n;
    }

    /**
     * Get localized information of the category.
     *
     * @return CategoryL10n[]
     */
    public function getL10n(): array
    {
        return $this->l10n;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(CategoryL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
