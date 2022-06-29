<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Product;

use Assert\Assert;
use GepardIO\ConnectorsSDK\DTO\Traits\IdentifierTrait;
use InvalidArgumentException;

use function sprintf;

/**
 * Represents the product identifier information.
 */
final class Identifier
{
    use IdentifierTrait;

    private array $additionalIdentifiers = [];

    /**
     * @param string               $id The product Identifier.
     * @param string               $mpn The Manufacturer Part Number.
     * @param AdditionalIdentifier ...$additionalIdentifiers A list of additional identifiers for product description
     *     with localization support (type, value, locale). The most commonly used types are MPN, GTIN, and SKU.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $id,
        private string $mpn,
        AdditionalIdentifier ...$additionalIdentifiers
    ) {
        Assert::lazy()
            ->that($id, 'id')->notEmpty()
            ->that($mpn, 'mpn')->notEmpty()
            ->verifyNow();

        foreach ($additionalIdentifiers as $additional) {
            $this->addAdditionalIdentifier($additional);
        }
    }

    /**
     * Get the MPN.
     *
     * @return string
     */
    public function getMpn(): string
    {
        return $this->mpn;
    }

    /**
     * Get a list of additional identifiers.
     *
     * @return AdditionalIdentifier[]
     */
    public function getAdditionalIdentifiers(): array
    {
        return $this->additionalIdentifiers;
    }

    /**
     * Add an additional identifier.
     *
     * @param AdditionalIdentifier $identifier
     *
     * @throws InvalidArgumentException
     */
    private function addAdditionalIdentifier(AdditionalIdentifier $identifier): void
    {
        foreach ($this->additionalIdentifiers as $additionalIdentifier) {
            if ($additionalIdentifier->equals($identifier)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Additional identifier is already exist - type: %s, locale: %s, value: %s',
                        $identifier->getType(),
                        $identifier->getLocale(),
                        $identifier->getValue(),
                    )
                );
            }
        }

        $this->additionalIdentifiers[] = $identifier;
    }
}
