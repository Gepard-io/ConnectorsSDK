<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

/**
 * Represents localized information about the taxonomy item.
 */
interface TaxonomyL10nInterface
{
    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale(): string;

    /**
     * Get the localized name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Determines if the name and locale of the instance are equal.
     *
     * @param TaxonomyL10nInterface $other
     *
     * @return bool
     */
    public function equals(self $other): bool;

    /**
     * Convert the taxonomy localized information into an array.
     *
     * @return array
     */
    public function toArray(): array;
}
