<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\ExtraTrait;
use InvalidArgumentException;

/**
 * Represents the detailed information about product's multimedia content.
 */
final class Media
{
    use ExtraTrait;

    /**
     * @param string      $type Media file type, e.g. "leaflet", "video", "manual pdf".
     * @param string      $contentType File content type, e.g. "image/png", "video/mp4", "application/pdf".
     * @param string      $url Source URL of file.
     * @param string[]    $locales List of locales.
     * @param string|null $description Description of media file.
     * @param int|null    $size Size of media file.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $type,
        private string $contentType,
        private string $url,
        private array $locales,
        private ?string $description = null,
        private ?int $size = null
    ) {
        Assert::lazy()
            ->that($type, 'type')->notEmpty()
            ->that($contentType, 'contentType')->notEmpty()
            ->that($url, 'url')->notEmpty()->url()
            ->that($locales, 'locales')->minCount(0)->uniqueValues()
            ->that($description, 'description')->nullOr()->notEmpty()
            ->that($size, 'size')->nullOr()->integer()->greaterThan(0)
            ->verifyNow();
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get content type.
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Get source URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get list of locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * Get file size.
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Determines if the type and URL of the instance are equal.
     *
     * @param self $other
     *
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->type === $other->getType() && $this->url === $other->getUrl();
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'contentType' => $this->contentType,
            'description' => $this->description,
            'url' => $this->url,
            'size' => $this->size,
            'locales' => $this->locales,
            'extra' => $this->extra,
        ];
    }
}
