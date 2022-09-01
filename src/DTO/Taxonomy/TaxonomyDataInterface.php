<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use InvalidArgumentException;

/**
 * Represents basic information about a taxonomy item.
 */
interface TaxonomyDataInterface
{
    /**
     * Get the identifier.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Localized information about a taxonomy item.
     *
     * @return array
     */
    public function getL10n(): array;

    /**
     * Convert the taxonomy data into an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Get L10n item by locale
     *
     * @param string $locale
     *
     * @return TaxonomyL10nInterface
     *
     * @throws InvalidArgumentException
     */
    public function getL10nItemByLocale(string $locale): TaxonomyL10nInterface;
}
