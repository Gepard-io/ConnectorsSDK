<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;
use GepardIO\ConnectorsSDK\DTO\Traits\TagsTrait;

use function array_map;

/**
 * Category is a group of products of the same type (e.g., Notebooks, Tablets, Smartphones).
 */
final class Category extends BaseTaxonomyData
{
    use TagsTrait;

    /**
     * @param string         $id A unique identifier.
     * @param CategoryL10n[] $l10n Localized information about the category.
     * @param string|null    $parentId Identifier of the parent category.
     * @param string|null    $unspsc The standard United Nations Standard Products and Services Code used to classify a
     *     category. https://www.ungm.org/Public/UNSPSC.
     * @param array|null     $path An array of categories that are parent to this category.
     * @param array          $tags An optional list of tags.
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        protected string $id,
        array $l10n,
        private ?string $parentId = null,
        private ?string $unspsc = null,
        private ?array $path = null,
        protected array $tags = []
    ) {
        Assert::lazy()
            ->that($l10n, 'l10n')->all()->isInstanceOf(CategoryL10n::class)
            ->that($parentId, 'parentId')->nullOr()->notBlank()
            ->that($unspsc, 'unspsc')->nullOr()->notEmpty()
            ->that($tags, 'tags')->all()->string()
            ->that($tags, 'tags')->uniqueValues()
            ->verifyNow();

        parent::__construct($id, $l10n);
    }

    /**
     * Get an identifier of the parent category.
     *
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * Get United Nations Standard Products and Services Code (UNSPSC).
     *
     * @return string|null
     */
    public function getUnspsc(): ?string
    {
        return $this->unspsc;
    }

    /**
     * Get categories that are parent to this category.
     *
     * @return array|null
     */
    public function getPath(): ?array
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'l10n' => array_map(static fn(CategoryL10n $l10n) => $l10n->toArray(), $this->l10n),
            'parentId' => $this->parentId,
            'unspsc' => $this->unspsc,
            'path' => $this->path,
            'extra' => $this->extra,
            'tags' => $this->tags,
        ];
    }
}
